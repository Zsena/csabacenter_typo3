<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Records\ContentTeaser;
use DigitalZombies\Center\Domain\Repository\Records\BlogRepository;
use DigitalZombies\Center\Configuration\ScopeConfiguration;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 András Ottó <andras.otto@digital-zombies.com>, Digital Zombies
 *
 */

/**
 * Class BlogController
 * @package DigitalZombies\Center\Controller
 */
class BlogController extends MetaTagBaseController
{

    /**
     * @var \DigitalZombies\Center\Domain\Repository\Records\BlogRepository
     */
    protected $blogRepository;
    
    /**
     * @param \DigitalZombies\Center\Domain\Repository\Records\BlogRepository $repository
     *
     * @return void
     */
    public function injectBlogRepository(BlogRepository $repository)
    {
        $this->blogRepository = $repository;
    }
    
    /**
     * Renders a detail page for News
     *
     * @return string
     */
    public function getBlogEntriesAction()
    {
        $response['blogPages'] = [];
        if (ScopeConfiguration::hasCenter() &&
            isset($this->settings['listPages']['blogEntries'])) {
            $blogEntryPageIds = explode(',', $this->settings['listPages']['blogEntries']);

            $contentBlogPages = $this->blogRepository->listAllContentBlogForCenter(
                $blogEntryPageIds);

            /** @var ContentTeaser $blogPage */
            foreach ($contentBlogPages as $blogPage) {
                $detailLink = $this->uriBuilder
                    ->reset()
                    ->setTargetPageUid($blogPage->getUid())
                    ->setCreateAbsoluteUri(true)
                    ->buildFrontendUri();
                $blogPageArray = [
                    'uid' => $blogPage->getUid(),
                    'starttime' => $blogPage->getStarttime(),
                    'endtime' => $blogPage->getEndtime(),
                    'detail' => [
                        'link' => $detailLink,
                    ],
                    'teaser' => [
                        'title' => $blogPage->getTitle(),
                        'abstract' => $blogPage->getTeaserAbstract(),
                        'image' => $this->processImageAndGetUrl($blogPage->getTeaserImage()),
                    ]
                ];
                $response['blogPages'][] = $blogPageArray;
            }
        }

        return json_encode($response);
    }
}
