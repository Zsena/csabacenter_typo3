<?php
namespace DigitalZombies\Center\Constants;

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
 * RecordBase
 *
 *
 * This is the class where the big journey begins.
 * Only the well prepared souls can understand what lies under this mighty construct.
 *
 * This class implements some stuff needed by each end every record types.
 * They have three groups:
 * SEO
 * Teaser
 * Social Media
 *
 * The fields are defined in the TCAFieldHelper. This little class is very useful
 * if you inherit these fields in the TCA Configuration.
 *
 * To this class is a view provided, which collects and transform each end every "teaserable" types,
 * filters them and helps prepare a teaser view.
 *
 */
class HideInApp
{
	const NO_RESTRICTION = 0;
	const HIDE_IN_APP = 1;
	const ONLY_IN_APP = 2;
}
