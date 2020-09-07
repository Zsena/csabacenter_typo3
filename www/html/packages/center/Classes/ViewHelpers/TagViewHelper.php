<?php

namespace DigitalZombies\Center\ViewHelpers;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use DigitalZombies\Center\Domain\Repository\Misc\TagRepository;
use DigitalZombies\Center\Domain\Model\Misc\Tag;


/**
 * Take ID of tag and
 */
class TagViewHelper extends AbstractViewHelper
{

    use CompileWithRenderStatic;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;


    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        parent::registerArgument('tagId', 'integer', 'Specifies the Tag object for the icon rendering', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $templateVariableContainer = $renderingContext->getVariableProvider();
        $tag = self::getTag($arguments['tagId']);
        $templateVariableContainer->add('tag', $tag);
        $output = $renderChildrenClosure();
        $templateVariableContainer->remove('tag');
        return $output;
    }

    /**
     * Returns TypoSript settings array
     *
     * @param int $tagId Name of the extension
     * @return Tag $tag
     */
    public static function getTag($tagId)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var TagRepository $tagRepository */
        $tagRepository = $objectManager->get(TagRepository::class);

        /** @var Tag $tag */
        $tag = $tagRepository->findByUid($tagId);

        return $tag;

    }
}

