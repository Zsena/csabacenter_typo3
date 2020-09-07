<?php

namespace DigitalZombies\Center\Domain\Repository\Misc;

use Doctrine\DBAL\Query\QueryBuilder;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

use DigitalZombies\Center\Domain\Model\Misc\Sender;

class IcalRepository extends Repository
{
	/**
	 * @param $uid
	 * @return mixed
	 */
	public function getEventData($uid)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_records_event');

		$eventData = $queryBuilder->select('title', 'content_abstract', 'event_starttime', 'event_endtime')
			->from('tx_center_domain_model_records_event')
			->where('uid = ' . $uid)
			->execute()
			->fetchAll();

		$eventData[0]['uid'] = $uid;
		$eventData[0]['timestamp'] = time();

		($eventData[0]['event_starttime']) ?
			$eventData[0]['event_starttime'] = date('Ymd', $eventData[0]['event_starttime']) . 'T' .
				date('His', $eventData[0]['event_starttime'])
			: '';

		($eventData[0]['event_endtime']) ?
			$eventData[0]['event_endtime'] = date('Ymd', $eventData[0]['event_endtime']) . 'T' .
				date('His', $eventData[0]['event_endtime'])
			: '';

		$sender = new Sender();

		$eventData[0]['address'] = preg_replace("/\r|\n/", " ", strip_tags($sender->getCenter()->getAddress()));
		$eventData[0]['email'] = $sender->getCenter()->getEmail();
		$eventData[0]['center_name'] = $sender->getCenter()->getCenterName();

		return $eventData[0];
	}

}
