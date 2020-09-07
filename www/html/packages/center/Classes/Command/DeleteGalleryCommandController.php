<?php
namespace DigitalZombies\Center\Command;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Repository\Center\CenterRepository;
use DigitalZombies\Center\Domain\Repository\Misc\GalleryRepository;
use DigitalZombies\Center\Utility\Mail\SendMail;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class DeleteGalleryCommandController extends CommandController
{
	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(ObjectManagerInterface $objectManager)
	{
		$this->objectManager = $objectManager;
	}

	/**
	 * Deletes old galleries
	 *
	 * @return boolean
	 */
	public function deleteGalleryCommand()
	{
		//Delete Gallery records
		/** @var \DigitalZombies\Center\Domain\Repository\Misc\GalleryRepository $galleryRepository */
		$galleryRepository = $this->objectManager->get(GalleryRepository::class);
		$result = $galleryRepository->deleteOldGalleries();
		// flash message
		/** @var FlashMessage $message */
		$message = GeneralUtility::makeInstance(FlashMessage::class,
			$result . ' galleries deleted',
			'', // [optional] the header
			FlashMessage::INFO,
			true
		);
		/** @var FlashMessageService $flashMessageService */
		$flashMessageService = $this->objectManager->get(FlashMessageService::class);

		$messageQueue = $flashMessageService->getMessageQueueByIdentifier();
		$messageQueue->addMessage($message);
		return true;
	}

    /**
     * Sends an email to notify $days before a gallery gets deleted.
     * @param int $days
     *
     * @return boolean
     */
    public function sendEmailAboutGalleriesToDeleteCommand($days = 11)
    {
        //Delete Gallery records
        /** @var \DigitalZombies\Center\Domain\Repository\Misc\GalleryRepository $galleryRepository */
        $galleryRepository = $this->objectManager->get(GalleryRepository::class);
        $galleries = $galleryRepository->findGalleriesToDelete($days);

        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

        if(count($galleries) > 0) {

            // get template paths from TypoScript settings
            $templatePath = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleries.']['templatePath'];
            $templateName = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleries.']['templateName'];
            $receiverEmail = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleries.']['receiverEmail'];
            $receiverName = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleries.']['receiverName'];
            $senderName = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleries.']['senderName'];
            $senderEmail = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleries.']['senderEmail'];
            $subject = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleries.']['subject'];

            $centersWithGalleries = [];

            foreach ($galleries as $galleryId => $gallery) {
                if($gallery['center']) {
                    /** @var CenterRepository $centerRepository */
                    $centerRepository = $this->objectManager->get(CenterRepository::class);
                    if ($center = $centerRepository->findByUid((int)$gallery['center'])) {
                        $centersWithGalleries[$center->getUid()]['center'] = $center;
                        $galleries[$galleryId]['center'] = $center;
                        $gallery['center'] = $center;

                        $centersWithGalleries[$center->getUid()]['galleries'][] = $gallery;
                    }
                }
            }

            SendMail::sendEmail(['galleries' => $galleries], $subject, $senderEmail, $senderName, trim($receiverEmail), $receiverName, $templatePath, $templateName);

            // send E-Mail

            // send E-Mail
            foreach ($centersWithGalleries as $centerGalleries) {
                if($centerGalleries['center']) {
                    /** @var Center $center */
                    $center = $centerGalleries['center'];
                    if($center->getEmail()) {
                        $templateName = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleriesToCenter.']['templateName'];
                        $subject = $settings['plugin.']['tx_center.']['emailTemplates.']['sendEmailGalleriesToCenter.']['subject'];
                        SendMail::sendEmail(['galleries' => $centerGalleries['galleries']], $subject, $senderEmail, $senderName,
                            trim($center->getEmail()), $center->getCenterName(), $templatePath, $templateName);
                    }

                }
            }

        }
        return true;
    }
}