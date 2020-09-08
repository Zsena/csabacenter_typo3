<?php
return [
    'BE' => [
        'debug' => true,
        'explicitADmode' => 'explicitAllow',
        'installToolPassword' => '$argon2i$v=19$m=65536,t=16,p=1$UURLOTBvb0llUGpRUTJKSA$cyEFRgIhcAoQKWg5l/xrSJjpUFzLxrogq6gkZny6lqw',
        'loginSecurityLevel' => 'normal',
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
            'options' => [],
        ],
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8mb4',
                'driver' => 'mysqli',
                'host' => 'csabacenter_typo3_db_1',
                'password' => 'root',
                'port' => 3306,
                'tableoptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci',
                ],
                'user' => 'root',
            ],
        ],
    ],
    'EXT' => [
        'extConf' => [
            'backend' => 'a:6:{s:9:"loginLogo";s:0:"";s:19:"loginHighlightColor";s:0:"";s:20:"loginBackgroundImage";s:0:"";s:13:"loginFootnote";s:0:"";s:11:"backendLogo";s:0:"";s:14:"backendFavicon";s:0:"";}',
            'center' => 'a:2:{s:11:"previewUser";s:0:"";s:15:"previewPassword";s:0:"";}',
            'extensionmanager' => 'a:2:{s:21:"automaticInstallation";s:1:"1";s:11:"offlineMode";s:1:"0";}',
            'mask' => 'a:9:{s:4:"json";s:48:"EXT:csabacentersite/Configuration/Json/mask.json";s:18:"backendlayout_pids";s:3:"0,1";s:7:"content";s:61:"EXT:csabacentersite/Resources/Private/Templates/Mask/Frontend";s:7:"layouts";s:60:"EXT:csabacentersite/Resources/Private/Layouts/Mask/Frontend/";s:8:"partials";s:60:"EXT:csabacentersite/Resources/Private/Partials/Mask/Frontend";s:7:"backend";s:61:"EXT:csabacentersite/Resources/Private/Templates/Mask/Backend/";s:15:"layouts_backend";s:58:"EXT:csabacentersite/Resources/Private/Layouts/Mask/Backend";s:16:"partials_backend";s:59:"EXT:csabacentersite/Resources/Private/Partials/Mask/Backend";s:7:"preview";s:59:"EXT:csabacentersite/Resources/Private/Previews/Mask/Backend";}',
            'scheduler' => 'a:2:{s:11:"maxLifetime";s:4:"1440";s:15:"showSampleTasks";s:1:"1";}',
            'solr' => 'a:4:{s:35:"useConfigurationFromClosestTemplate";s:1:"0";s:43:"useConfigurationTrackRecordsOutsideSiteroot";s:1:"1";s:29:"useConfigurationMonitorTables";s:0:"";s:27:"allowSelfSignedCertificates";s:1:"0";}',
            'vhs' => 'a:1:{s:20:"disableAssetHandling";s:1:"0";}',
        ],
    ],
    'EXTENSIONS' => [
        'backend' => [
            'backendFavicon' => '',
            'backendLogo' => '',
            'loginBackgroundImage' => '',
            'loginFootnote' => '',
            'loginHighlightColor' => '',
            'loginLogo' => '',
        ],
        'center' => [
            'previewPassword' => '',
            'previewUser' => '',
        ],
        'extensionmanager' => [
            'automaticInstallation' => '1',
            'offlineMode' => '0',
        ],
        'mask' => [
            'backend' => 'EXT:csabacentersite/Resources/Private/Templates/Mask/Backend/',
            'backendlayout_pids' => '0,1',
            'content' => 'EXT:csabacentersite/Resources/Private/Templates/Mask/Frontend',
            'json' => 'EXT:csabacentersite/Configuration/Json/mask.json',
            'layouts' => 'EXT:csabacentersite/Resources/Private/Layouts/Mask/Frontend/',
            'layouts_backend' => 'EXT:csabacentersite/Resources/Private/Layouts/Mask/Backend',
            'partials' => 'EXT:csabacentersite/Resources/Private/Partials/Mask/Frontend',
            'partials_backend' => 'EXT:csabacentersite/Resources/Private/Partials/Mask/Backend',
            'preview' => 'EXT:csabacentersite/Resources/Private/Previews/Mask/Backend',
        ],
        'scheduler' => [
            'maxLifetime' => '1440',
            'showSampleTasks' => '1',
        ],
        'solr' => [
            'allowSelfSignedCertificates' => '0',
            'useConfigurationFromClosestTemplate' => '0',
            'useConfigurationMonitorTables' => '',
            'useConfigurationTrackRecordsOutsideSiteroot' => '1',
        ],
        'vhs' => [
            'disableAssetHandling' => '0',
        ],
    ],
    'FE' => [
        'debug' => true,
        'loginSecurityLevel' => 'normal',
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2iPasswordHash',
            'options' => [],
        ],
    ],
    'GFX' => [
        'gdlib_png' => true,
        'processor' => 'GraphicsMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'RGB',
        'processor_effects' => false,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    'LOG' => [
        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        5 => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'MAIL' => [
        'transport' => 'sendmail',
        'transport_sendmail_command' => ' -t -i ',
        'transport_smtp_encrypt' => '',
        'transport_smtp_password' => '',
        'transport_smtp_server' => '',
        'transport_smtp_username' => '',
    ],
    'SYS' => [
        'devIPmask' => '*',
        'displayErrors' => 1,
        'encryptionKey' => 'f3fb8f6bf87e53744310bb9280e42b7d2fa4cec17cfacaeeb42552456ecf6cf267f15a11b752f55535ce3e2ab5c303ee',
        'exceptionalErrors' => 12290,
        'features' => [
            'unifiedPageTranslationHandling' => true,
        ],
        'fileCreateMask' => '0644',
        'folderCreateMask' => '0755',
        'phpTimeZone' => 'Europe/Berlin',
        'sitename' => '[Development] [Development] Csabacenter',
        'systemLocale' => 'de_DE.utf8',
        'systemLogLevel' => 0,
        'systemMaintainers' => [
            1,
        ],
    ],
];
