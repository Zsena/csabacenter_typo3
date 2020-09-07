<?php
namespace DigitalZombies\Center\Domain\Model\Records;
use DigitalZombies\Center\Domain\Model\RecordBase;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 David Miltz <d.miltz@plan-net.com>, Plan.Net Pulse
 *
 */


/**
 * Blog
 *
 * Blog is a class to map properties from pages with doktype = 135.
 * !!!!This is a page !!!!
 * The record stored in the pages table.
 *
 */
class Blog extends RecordBase
{
	/**
	 * Dok type for the page
	 */
	const DOKTYPE = 135;

	/**
	 * @var string
	 */
	protected $partialName = 'Blog';

	/**
	 * Type for tags
	 */
	const TYPE = 'tx_center_domain_model_records_blog';

	/**
	 * Table name in the database
	 */
	const TABLE_NAME = 'pages';
}
