<?php
namespace DigitalZombies\Csabacentersite\Hooks;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;


/**
 * Handels the a tag params by external urls
 */
class ExternalUrlLinkHandler
{
	/**
	 * Adds a rel parameter to the a tags.
	 *
	 * @param string $URL
	 * @param string $TYPE
	 * @param ContentObjectRenderer $parent
	 * @return string
	 */
	public function main(string $URL, string $TYPE, ContentObjectRenderer $parent): string
	{
		$aTagParams = '';
		//external url only
		if($TYPE === 'url') {
			$aTagParams = 'rel="noopener noreferrer"';
		}
		return $aTagParams;
	}
}
