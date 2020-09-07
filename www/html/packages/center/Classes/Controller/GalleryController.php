<?php
namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Gallery;
use DigitalZombies\Center\Domain\Repository\Misc\GalleryRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

/**
 * Class GalleryController
 * @package DigitalZombies\Center\Controller
 */
class GalleryController extends ActionController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\GalleryRepository
	 */
	protected $galleryRepository;


	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Misc\GalleryRepository $repository
	 *
	 * @return void
	 */
	public function injectGalleryRepository(GalleryRepository $repository){
		$this->galleryRepository = $repository;
	}

	/**
	 * Renders the data of the gallery images as a json for photoswipe
	 *
	 * @param Gallery $gallery
	 * @return string
	 */
	public function renderGalleryDataAsJsonAction(Gallery $gallery){
		return 	trim($this->view->assign('gallery', $gallery)->render());
	}

	/**
	 * Renders the basic structure for the gallery
	 *
	 */
	public function showAction() {
		if(isset($this->settings['gallery']['gallery'])) {
			$gallery = $this->galleryRepository->findByUid((int)$this->settings['gallery']['gallery']);
			$this->view->assign('gallery', $gallery);
		}
	}

	/**
	 * Renders the template for photoswipe
	 *
	 */
	public function showPhotoswipeTemplateAction() {
	}
}