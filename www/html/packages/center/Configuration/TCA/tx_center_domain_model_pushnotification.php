<?php
defined('TYPO3_MODE') or die();

$ll = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_pushnotification.';

$frontendLL = 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:';

$pushNotificationTca['interface'] = [
    'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, push_date, push_time, title, text, sent_date',
];

$pushNotificationTca['ctrl'] = [
    'title' => $ll . 'title',
    'type' => 'type',
    'label' => 'title',
    'label_alt' => 'text',
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'cruser_id' => 'cruser_id',
    'versioningWS' => true,
    'languageField' => 'sys_language_uid',
    'transOrigPointerField' => 'l10n_parent',
    'transOrigDiffSourceField' => 'l10n_diffsource',
    'delete' => 'deleted',
    'enablecolumns' => [
        'disabled' => 'hidden'
    ],
    'searchFields' => 'title,text,center',
    'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
];

$pushNotificationTca['palettes'] = [
    'timePallete' => [
        'label' => $ll . 'time_pallete',
        'showitem' => 'push_date, push_time',
    ],
];


$pushNotificationTca['types'] = [
    // Center Push Notification
    '1' => [
        'showitem' => 'type, sent_date, linked_element, title, text,' .
            '--div--;' . $ll . 'delivery_div, delivery_type, is_test, ' .
            '--palette--;' . $ll . 'time_pallete;timePallete, ' .
            '--div--;' . $ll . 'language_div,sys_language_uid'
    ],
    // Multi-Center Push Notification
    '2' => [
        'showitem' => 'type, sent_date, linked_element, title, text, center, ' .
            '--div--;' . $ll . 'delivery_div, delivery_type, is_test,' .
            '--palette--;' . $ll . 'time_pallete;timePallete, ' .
            '--div--;' . $ll . 'language_div,sys_language_uid'
    ],
    // Global Push Notification
    '3' => [
        'showitem' => 'type, sent_date, linked_element, title, text,' .
            '--div--;' . $ll . 'delivery_div, delivery_type, is_test,' .
            '--palette--;' . $ll . 'time_pallete;timePallete, ' .
            '--div--;' . $ll . 'language_div,sys_language_uid'
    ],
];


$pushNotificationTca['columns'] = [
    'type' => [
        'exclude' => true,
        'label' => $ll . 'type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    $ll . 'type.center_push_notification',
                    \DigitalZombies\Center\Domain\Model\PushNotification\CenterPushNotification::TYPE
                ],
                [
                    $ll . 'type.multi_center_push_notification',
                    \DigitalZombies\Center\Domain\Model\PushNotification\MultiCenterPushNotification::TYPE
                ],
                [
                    $ll . 'type.global_push_notification',
                    \DigitalZombies\Center\Domain\Model\PushNotification\GlobalPushNotification::TYPE
                ],
            ],
        ],
    ],
    'sys_language_uid' => [
        'displayCond' => 'FIELD:linked_element:=:',
        'exclude' => true,
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'special' => 'languages',
            'items' => [
                [
                    'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                    -1,
                    'flags-multiple'
                ],
            ],
            'default' => 0,
        ],
    ],
    'l10n_parent' => [
        'displayCond' => 'FIELD:sys_language_uid:>:0',
        'exclude' => true,
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'default' => 0,
            'items' => [
                ['', 0],
            ],
            'foreign_table' => 'tx_center_domain_model_pushnotification',
            'foreign_table_where' => 'AND tx_center_domain_model_pushnotification.pid=###CURRENT_PID### 
            AND tx_center_domain_model_pushnotification.sys_language_uid IN (-1,0)',
        ],
    ],
    'l10n_diffsource' => [
        'config' => [
            'type' => 'passthrough',
        ],
    ],
    't3ver_label' => [
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'max' => 255,
        ],
    ],
    'hidden' => [
        'exclude' => true,
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
        'config' => [
            'type' => 'check',
            'items' => [
                '1' => [
                    '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                ],
            ],
        ],
    ],

    'is_test' => [
        'exclude' => 1,
        'l10n_mode' => 'exclude',
        'label' => 'Test record',
        'config' => [
            'type' => 'check',
            'default' => '0'
        ]
    ],

    'delivery_type' => [
        'exclude' => true,
        'onChange' => 'reload',
        'label' => 'Test record',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    $ll . 'delivery_type.1',
                    \DigitalZombies\Center\Domain\Model\PushNotification\PushNotification::STANDARD_DELIVERY
                ],
                [
                    $ll . 'delivery_type.2',
                    \DigitalZombies\Center\Domain\Model\PushNotification\PushNotification::TIME_BASED_DELIVERY
                ],
            ],
        ],
    ],
    'push_date' => [
        'exclude' => true,
        'displayCond' => 'FIELD:delivery_type:=:' .
            \DigitalZombies\Center\Domain\Model\PushNotification\PushNotification::TIME_BASED_DELIVERY,
        'label' => $ll . 'push_date',
        'config' => [
            'dbType' => 'datetime',
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'size' => 7,
            'eval' => 'date',
            'default' => null,
        ],
    ],
    'push_time' => [
        'exclude' => true,
        'displayCond' => 'FIELD:delivery_type:=:' .
            \DigitalZombies\Center\Domain\Model\PushNotification\PushNotification::TIME_BASED_DELIVERY,
        'label' => $ll . 'push_time',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'size' => 4,
            'eval' => 'time',
            'default' => 0
        ],
    ],
    'title' => [
        'onChange' => 'reload',
        'exclude' => true,
        'label' => $ll . 'title',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'text' => [
        'exclude' => true,
        'label' => $ll . 'text',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim,required'
        ],
    ],
    'actual_delivery_date' => [
        'exclude' => true,
        'displayCond' => 'FIELD:actual_delivery_date:!=:null',
        'label' => $ll . 'actual_delivery_date',
        'config' => [
            'dbType' => 'date',
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime',
            'size' => 7,
            'default' => null,
            'readOnly' => 1
        ],
    ],
    'marked_for_delivery' => [
        'exclude' => true,
        'label' => '',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'max' => 255,
        ],
    ],
    'center' => [
        'exclude' => true,
        'label' => $ll .'center',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'enableMultiSelectFilterTextfield' => true,
            'foreign_table' => 'tx_center_domain_model_center_center',
            'foreign_table_where' =>
                'AND ( (tx_center_domain_model_center_center.push_server_ios_topic <> \'\' AND ' .
                'tx_center_domain_model_center_center.push_server_ios_authorization_key <> \'\') OR ' .
                '(tx_center_domain_model_center_center.push_server_android_topic <> \'\' AND ' .
                'tx_center_domain_model_center_center.push_server_android_authorization_key <> \'\'))',
            'MM' => 'tx_center_domain_model_pushnotification_center_mm',
            'size' => 10,
            'maxitems' => 9999,
        ],
    ],
    'linked_element' => [
        'onChange' => 'reload',
        'exclude' => true,
        'label' => $ll .'linked_element',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputLink',
            'fieldControl' => [
                'linkPopup' => [
                    'options' => [
                        'blindLinkOptions' => 'file, mail, page, spec, url, folder, job, service, email',
                        'blindLinkFields' => 'class, params, title, target',
                    ]
                ]
            ],
        ]
    ],
];

return $pushNotificationTca;
