<?php

namespace DigitalZombies\Center\ViewHelpers;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;


/**
 *  check url parameters 
 */
class UrlCheckViewHelper extends AbstractViewHelper
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
		parent::registerArgument( 'url', 'string', 'Specifies the url', true );
		parent::registerArgument( 'parameters', 'string', 'Specifies the parameters', true );
		$this->escapeOutput = false;
	}

	/**
	 * @return mixed
	 */
	public function render()
	{
		$output = \UrlCheckUtilityHelper::check( $this->arguments['url'], $this->arguments['parameters'] );
		return $output;
	}
}

