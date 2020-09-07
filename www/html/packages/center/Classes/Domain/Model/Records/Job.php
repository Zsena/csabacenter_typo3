<?php
namespace DigitalZombies\Center\Domain\Model\Records;

use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;


/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>, Plan.Net Pulse
 *
 */


/**
 * Job
 */
class Job extends RecordBase
{
	const TYPE = 'tx_center_domain_model_records_job';

	/**
	 * Table name in the database
	 */
	const TABLE_NAME = self::TYPE;

	/**
	 * @var string
	 */
	protected $partialName = 'Job';

	/**
	 * @var string
	 */
	protected $jobCategory = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
	 * @lazy
	 */
	protected $jobTags = null;


	/**
	 * Job constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->jobTags = new ObjectStorage();
	}

	/**
	 * @return string
	 */
	public function getJobCategory(): string
	{
		return $this->jobCategory;
	}

	/**
	 * @param string $jobCategory
	 */
	public function setJobCategory(string $jobCategory)
	{
		$this->jobCategory = $jobCategory;
	}

	/**
	 * @return ObjectStorage
	 */
	public function getJobTags()
	{
		return $this->jobTags;
	}

	/**
	 * @param ObjectStorage $jobTags
	 */
	public function setJobTags(ObjectStorage $jobTags)
	{
		$this->jobTags = $jobTags;
	}
}
