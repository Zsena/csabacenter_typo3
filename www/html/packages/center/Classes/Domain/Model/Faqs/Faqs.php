<?php

namespace DigitalZombies\Center\Domain\Model\Faqs;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

use DigitalZombies\Center\Domain\Model\Center\Center;
use

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 */


/**
 * Faq's
 */
class Faqs extends AbstractEntity
{
	/**
	 * function
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $centerId = null;


	/**
	 * Section Id
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Faqs\FaqsSections
	 */
	protected $sectionId = '';

	/**
	 * Question
	 *
	 * @var string
	 */
	protected $question = '';

	/**
	 * Answer
	 *
	 * @var string
	 */
	protected $answer = '';

	/**
	 * @return Center
	 */
	public function getCenterId(): Center
	{
		return $this->centerId;
	}



	/**
	 * @param int $sectionId
	 */
	public function setSectionId($sectionId)
	{
		$this->sectionId = $sectionId;
	}

	/**
	 * @return string
	 */
	public function getQuestion()
	{
		return $this->question;
	}

	/**
	 * @param string $question
	 */
	public function setQuestion($question)
	{
		$this->question = $question;
	}

	/**
	 * @return string
	 */
	public function getAnswer()
	{
		return $this->answer;
	}

	/**
	 * @param string $answer
	 */
	public function setAnswer($answer)
	{
		$this->answer = $answer;
	}

	/**
	 * @return FaqsSections
	 */
	public function getSectionId() : FaqsSections
	{
		return $this->sectionId;
	}

	/**
	 * @param FaqsSections $sectionId
	 */
	public function setCenterId(FaqsSections $sectionId)
	{
		$this->sectionId = $sectionId;
	}
}
