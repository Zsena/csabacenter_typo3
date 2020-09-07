<?php

namespace DigitalZombies\Center\ViewHelpers\Data;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;


/**
 * Take ID of tag and
 */
class AppViewHelper extends AbstractViewHelper
{

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    protected $escapeOutput = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        parent::registerArgument('visibility', 'integer', 'Specifies the visibility', true);
		$this->escapeOutput = false;
    }

	/**
	 * @return mixed
	 */
    public function render()
    {
    	$output = [];

		if(isset($this->arguments['visibility'])) {
			switch ((int)$this->arguments['visibility']) {
				case 1: $output['app-view'] = "hide"; break;
				case 2: $output['web-view'] = "hide"; break;
			}
		}

        return $output;
    }
}

