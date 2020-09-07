<?php
$jobConfig = \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
    \DigitalZombies\Center\Domain\Model\Records\Job::TYPE,
    'EXT:center/Resources/Public/Icons/job.svg', false, false);


$jobConfig['columns']['job_category'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_job.job_category',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
            [
                'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_job.job_category.1',
                '1'
            ],
            [
                'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_job.job_category.2',
                '2'
            ],
            [
                'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_job.job_category.3',
                '3'
            ]
        ],
    ],
];
$jobConfig['columns']['teaser_format'] = [
    'exclude' => 1,
    'l10n_mode' => 'exclude',
    'onChange' => 'reload',
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_format',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'default' => '1',
        'items' => [
            ['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_format.1', '1'],
        ],
        'minitems' => (1)
    ],
];


/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$jobConfig['columns'] = array_merge($jobConfig['columns'], $seoFields);

$contactPerson = \DigitalZombies\Center\Utility\TCAFieldHelper::getContactPersonRelation(
    \DigitalZombies\Center\Domain\Model\Misc\Contactperson::JOBS);
$jobConfig['columns'] = array_merge($jobConfig['columns'], $contactPerson);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$jobConfig['columns'] = array_merge($jobConfig['columns'], $ogFields);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(1,
    \DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_COVER, false, false, true, false, false, false);
$jobConfig['columns'] = array_merge($jobConfig['columns'], $teaserFields);

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should be required or optional. (if it is not defined, the default is false)
 */

$config = [
    'abstract' => [
        'required' => false
    ],
    'text' => [],
    'downloadfile' => [],
    'downloadfiletext' => [],
    'downloadlink' => [],
    'downloadlinktext' => [],
    'gallery' => ['tablenames' => 'tx_center_domain_model_records_job']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$jobConfig['columns'] = array_merge($jobConfig['columns'], $contentFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
    $jobConfig['palettes'][$paletteName] = $paletteConf;
}

//Type setting for the shop page type only (everything hidden from the page and each needed fields are "white-listed")
$jobConfig['types'][1] = [
    'showitem' => '
 +          --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, title, alternative_title,  reference_type, shop, center, chain_store, centers, job_category,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab('content_abstract, content_text, content_downloadfile, content_downloadfiletext, content_downloadlink, content_downloadlinktext, content_gallery')
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getContactTab()
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserTab()
];


/*
 * END TCAHelper
 */

return $jobConfig;
