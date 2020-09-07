<?php
$bannerConfig =  \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
    \DigitalZombies\Center\Domain\Model\Records\Banner::TYPE,
    'EXT:center/Resources/Public/Icons/ext_icon.png',
    false, false);


$bannerConfig['columns']['title']['config']['eval'] = 'trim, required';

$bannerConfig['columns']['title'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_banner.title',
    'config' => [
        'type' => 'input',
        'size' => 30,
        'max' => 255,
    ],
];

$bannerConfig['columns']['link'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_banner.link',
    'config' => array(
        'type' => 'input',
        'size' => '50',
        'max' => '256',
        'eval' => 'trim',
        'wizards' => array(
            'link' => array(
                'type' => 'popup',
                'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                'icon' => 'actions-wizard-link',
                'module' => array(
                    'name' => 'wizard_link',
                ),
                'JSopenParams' => 'height=800,width=600,status=0,menubar=0,scrollbars=1'
            )
        ),
        'softref' => 'typolink'
    )
];

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(1,
    \DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_COVER,
    false,
    false,
    false,
    false,
    true,
    true,
    1,
    false,
false
);
$bannerConfig['columns'] = array_merge($bannerConfig['columns'], $teaserFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
    $bannerConfig['palettes'][$paletteName] = $paletteConf;
}

$bannerConfig['types'][1] = [
    'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, title, link,--linebreak--, reference_type, shop, center, chain_store, centers,
 				--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserTab()
];

/*
 * END TCAHelper
 */

return $bannerConfig;
