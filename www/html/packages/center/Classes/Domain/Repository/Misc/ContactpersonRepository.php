<?php
namespace DigitalZombies\Center\Domain\Repository\Misc;

use Doctrine\DBAL\Query\QueryBuilder;
use DigitalZombies\Center\Domain\Model\Misc\Contactperson;
use DigitalZombies\Center\Domain\Model\Misc\Sender;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ContactpersonRepository extends Repository
{

	/**
	 *
	 */
	public function initializeObject() {
		/** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface */
		$defaultQuerySettings = $this->objectManager->get(QuerySettingsInterface::class);
		$defaultQuerySettings->setRespectStoragePage(false);

		$this->setDefaultQuerySettings($defaultQuerySettings);
	}

	/**
	 * @param Sender $sender
	 * @param int $responsibility
	 * @return array
	 */
	public function findByTypeAndResponsibility($sender, $responsibility = 0) {

		$contactPerson = null;

		return $contactPerson;
	}

}