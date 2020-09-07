<?php

namespace DigitalZombies\Center\Domain\Repository\Faqs;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

class FaqsRepository extends Repository
{
	public function findFaqsByCenterId($centerId) {

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_faqs');

		$faqs = $queryBuilder->select('faqs.center_id',
			'faqs.question',
			'faqs.answer',
			'faqs.sorting as faq_sorting',
			'faqssections.section_name',
			'faqssections.sorting as section_sorting')
			->from('tx_center_domain_model_faqs','faqs')
			->innerJoin('faqs',
				'tx_center_domain_model_faqs_sections',
				'faqssections',
				'faqssections.uid = faqs.section_id')
			->where($queryBuilder->expr()->eq('faqs.center_id',$queryBuilder->createNamedParameter($centerId)))
			->andWhere($queryBuilder->expr()->eq('faqs.sys_language_uid',$GLOBALS['TSFE']->sys_language_uid))
			->orderBy('section_sorting')
			->addOrderBy('faq_sorting')
			->execute()
			->fetchAll();

		return $faqs;
	}
}
