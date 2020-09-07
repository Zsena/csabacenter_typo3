<?php
$recordBaseConfig =  \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
	\DigitalZombies\Center\Domain\Model\Records\News::TYPE, 'EXT:center/Resources/Public/Icons/ext_icon.png', false);


$recordBaseConfig['columns']['type'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_recordbase.type',
	'config' => [
		'type' => 'select',
		'renderType' => 'selectSingle',
		'items' => [
			['', \DigitalZombies\Center\Domain\Model\Records\Service::TYPE],
			['', \DigitalZombies\Center\Domain\Model\Records\Event::TYPE],
			['', \DigitalZombies\Center\Domain\Model\Records\Job::TYPE],
			['', \DigitalZombies\Center\Domain\Model\Records\Offer::TYPE],
            ['', \DigitalZombies\Center\Domain\Model\Records\Coupon::TYPE],
			['', \DigitalZombies\Center\Domain\Model\Records\News::TYPE]
		],
	],
];

$recordBaseConfig['ctrl']['type'] = 'type';
$recordBaseConfig['ctrl']['hideTable'] = true;

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$recordBaseConfig['columns'] = array_merge($recordBaseConfig['columns'], $seoFields);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$recordBaseConfig['columns'] = array_merge($recordBaseConfig['columns'], $ogFields);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields();
$recordBaseConfig['columns'] = array_merge($recordBaseConfig['columns'], $teaserFields);

/*
 * END TCAHelper
 */

return $recordBaseConfig;
