<?php

namespace DigitalZombies\Center\Utility;

use DigitalZombies\Center\Exception\InvalidPreviewRequestException;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class AuthenticationHelper
{
    const CONFIGURATION_USER_PROVIDER_KEY = 'previewUser';
    const CONFIGURATION_PASSWORD_PROVIDER_KEY = 'previewPassword';
    const SERVER_USER_PROVIDER_KEY = 'PHP_AUTH_USER';
    const SERVER_PASSWORD_PROVIDER_KEY = 'PHP_AUTH_PW';

    /**
     * @var array
     */
    private $userPasswordMapping = [];

    /**
     * AuthenticationHelper constructor.
     * @throws InvalidPreviewRequestException
     */
    public function __construct()
    {
        $extensionConfiguration = $this->getExtensionConfiguration();
        if (!(isset($extensionConfiguration[self::CONFIGURATION_USER_PROVIDER_KEY])
            && is_string($extensionConfiguration[self::CONFIGURATION_USER_PROVIDER_KEY])
            && isset($extensionConfiguration[self::CONFIGURATION_PASSWORD_PROVIDER_KEY])
            && is_string($extensionConfiguration[self::CONFIGURATION_PASSWORD_PROVIDER_KEY]))
        ) {
            throw new InvalidPreviewRequestException("Unusable Password Configuration");
        }

        $this->userPasswordMapping[$extensionConfiguration[self::CONFIGURATION_USER_PROVIDER_KEY]] = $extensionConfiguration[self::CONFIGURATION_PASSWORD_PROVIDER_KEY];
    }

    /**
     * Checks if the session is authenticated
     * @return bool
     */
    public function isAuthenticated()
    {
        return (
            isset($_SERVER[self::SERVER_USER_PROVIDER_KEY])
            && isset($_SERVER[self::SERVER_USER_PROVIDER_KEY])
            && isset($_SERVER[self::SERVER_PASSWORD_PROVIDER_KEY])
            && isset($this->userPasswordMapping[$_SERVER[self::SERVER_USER_PROVIDER_KEY]])
            && $this->userPasswordMapping[$_SERVER[self::SERVER_USER_PROVIDER_KEY]] === $_SERVER[self::SERVER_PASSWORD_PROVIDER_KEY]
        );
    }

    /**
     * Sets the required Header and dies
     */
    public function provideAuthentication()
    {
        header('WWW-Authenticate: Basic realm="' . $this->getDomainName() . ' Preview"');
        header('HTTP/1.0 401 Unauthorized');
        die("Authentication required.");
    }

    /**
     * Returns the extension configuration array
     * @return array
     */
    private function getExtensionConfiguration()
    {
        $configuration = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['center'];
        if ($configuration && is_string($configuration)) {
            $configuration = @unserialize($configuration);
            if (is_array($configuration)) {
                return $configuration;
            }
        }
        return [];
    }

    /**
     * @return string
     */
    private function getDomainName()
    {
        return $_SERVER['HTTP_HOST'];
    }
}
