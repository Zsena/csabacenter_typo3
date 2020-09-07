<?php
namespace DigitalZombies\Center\Domain\Model\Records;


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
 * ContentLinkTeaser
 */
class ContentLinkTeaser extends ContentTeaser
{
	const TYPE = '3';

	/**
	 * Table name in the database
	 */
	const TABLE_NAME = 'pages';
}
