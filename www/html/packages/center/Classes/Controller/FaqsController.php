<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Domain\Repository\Faqs\FaqsRepository;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class FaqsController
 * @package DigitalZombies\Center\Controller
 */
class FaqsController extends ActionController
{
	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Faqs\FaqsRepository
	 */
	protected $faqsRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Faqs\FaqsRepository $repository
	 *
	 * @return void
	 */
	public function injectEventRepository(FaqsRepository $repository)
	{
		$this->faqsRepository = $repository;
	}

	public function showAction()
	{
		$faqs = $this->faqsRepository->findFaqsByCenterId(ScopeConfiguration::getScope()->getUid());

		$flagedFaqs = [];
		foreach ($faqs as $faq) {
			$flagedFaqs[$faq['section_name']][] = $faq;
		}

		$this->view->assign('hideSearch', $this->settings['faqs']['hideSearch']);
		$this->view->assign('faqs', $flagedFaqs);
	}
}
