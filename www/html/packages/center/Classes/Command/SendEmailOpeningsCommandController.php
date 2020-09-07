<?php
namespace DigitalZombies\Center\Command;

use DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository;
use DigitalZombies\Center\Utility\Mail\SendMail;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;

class SendEmailOpeningsCommandController extends CommandController
{
	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(ObjectManagerInterface $objectManager)
	{
		$this->objectManager = $objectManager;
	}

	/**
	 * Deletes send Email with openings to central editor
	 * @param string $emailTo E-Mailadresse des Empfängers
	 * @param string $emailFrom E-Mailadresse des Versenders
	 * @param string $subject Betreff der E-Mail
	 * @param string $senderName Name des Senders
	 * @param string $receiverName Name des Empfängers
	 * @param integer $days Interval
	 * @return boolean
	 */
	public function sendEmailCommand($emailTo="", $subject = "Sonderöffnungszeiten", $emailFrom="", $senderName="", $receiverName="", $days = 7)
	{
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		/** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
		$configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
		$settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

		//Get openings from repository
		/** @var \DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository $openingsRepository */
		$openingsRepository = $this->objectManager->get(SpecialClosingDaysRepository::class);
		$openings = $openingsRepository->findOpenings($days);

		if(count($openings) > 0) {

			// get template paths from typoscript settings
			$templatePath = $settings['plugin.']['tx_center.']['emailTemplates.']['SendEmailOpeningsTemplatePath'];
			$templateName = $settings['plugin.']['tx_center.']['emailTemplates.']['SendEmailOpeningsTemplate'];
			$emailsArray = explode(',', $emailTo);

			// send E-Mail
			foreach ($emailsArray as $email) {
				SendMail::sendEmail(['openings' => $openings], $subject, $emailFrom, $senderName, trim($email), $receiverName, $templatePath, $templateName);
			}

			$statusMessage = 'Email sent';

		}else {
			$statusMessage = 'Email not sent. No openings in the given interval!';
		}

		// Display flash message in scheduler modul
		/** @var FlashMessage $message */
		$message = GeneralUtility::makeInstance(FlashMessage::class,
			$statusMessage,
			'', // [optional] the header
			FlashMessage::INFO,
			true
		);

		$flashMessageService = $this->objectManager->get(FlashMessageService::class);
		/** @var \TYPO3\CMS\Core\Messaging\FlashMessageQueue $messageQueue */
		$messageQueue = $flashMessageService->getMessageQueueByIdentifier();
		$messageQueue->addMessage($message);

		return true;
	}
}