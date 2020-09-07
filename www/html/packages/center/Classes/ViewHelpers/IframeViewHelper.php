<?php

namespace DigitalZombies\Center\ViewHelpers;

use AndrasOtto\Csp\Utility\IframeUtility;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentValueException;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Renders an Iframe tag
 *
 * Class IframeViewHelper
 * @package DigitalZombies\Center\ViewHelpers
 */
class IframeViewHelper extends AbstractViewHelper
{
	/**
	 * @param string $src
	 * @param string $class
	 * @param string $name
	 * @param int $width
	 * @param int $height
	 * @param string $sandbox
	 * @param bool $allowFullScreen
	 * @param bool $allowPaymentRequest
	 * @param array $dataAttributes
	 * @return string
	 */
	public function render($src, $class = '', $name = '', $width = 0, $height = 0, $sandbox = '',
	                       $allowFullScreen = false, $allowPaymentRequest = false, $dataAttributes = [])
	{
		$attributes = [];

		($src) ? $attributes['src'] = $src : '';
		($class) ? $attributes['class'] = $class : '';
		($name) ? $attributes['name'] = $name : '';
		($width) ? $attributes['width'] = $width : '';
		($height) ? $attributes['height'] = $height : '';
		($sandbox) ? $attributes['sandbox'] = implode(" ", $sandbox) : '';
		($allowFullScreen) ? $attributes['allowfullscreen'] = 'allowfullscreen' : '';
		($allowPaymentRequest) ? $attributes['allowpaymentrequest'] = 'allowpaymentrequest' : '';

		if (count($dataAttributes) > 0) {
			/** @var DataAttribute $dataAttribute */
			foreach ($dataAttributes as $key => $value) {
				$attributes[$key] = $value;
			}
		}

		$iframe = '<iframe ';

		foreach ($attributes as $attributeName => $value) {
			if ($value) {
				$iframe .= sprintf('%s="%s" ', $attributeName, $value);
			} else {
				$iframe .= $attributeName;
			}

		}

		return rtrim($iframe) . '></iframe>';
	}
}
