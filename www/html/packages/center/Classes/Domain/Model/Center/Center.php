<?php

namespace DigitalZombies\Center\Domain\Model\Center;

use DigitalZombies\Center\Domain\Model\OpeningHours\Holiday;
use DigitalZombies\Center\Domain\Model\OpeningHours\SpecialClosingDay;
use DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule;
use DigitalZombies\Center\Utility\HeadlinesHelper;
use DigitalZombies\Center\Utility\OpeningHoursHelper;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use \TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use \TYPO3\CMS\Extbase\Domain\Model\FileReference;
use \DigitalZombies\Center\Domain\Model\Misc\Country;
use \DigitalZombies\Center\Domain\Model\Misc\Timezone;
use \DigitalZombies\Center\Domain\Model\Misc\ContactpersonDp;
use \DigitalZombies\Center\Domain\Model\Misc\Subsidiary;

/*
 *
 * This file is part of the "center" Extension for TYPO3 CMS.

 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>, Plan.Net Pulse
 *
 */


/**
 * Center
 */
class Center extends AbstractEntity
{
    /**
     * name
     *
     * @var string
     */
    protected $centerName = '';

    /**
     * $shortName
     *
     * @var string
     */
    protected $shortName = '';

    /**
     * $region
     *
     * @var int
     */
    protected $region = 0;

    /**
     * $facebookPixel
     *
     * @var string
     */
    protected $facebookPixel = '';

    /**
     * $gaCenter
     *
     * @var string
     */
    protected $gaCenter = '';

    /**
     * $gaEceAccount
     *
     * @var string
     */
    protected $gaEceAccount = '';

    /**
     * $gtmEceAccount
     *
     * @var string
     */
    protected $gtmEceAccount = '';

    /**
     * $UseGtmEceAccount
     *
     * @var int
     */
    protected $useGtmEceAccount = '';

    /**
     * $pageId
     *
     * @var int
     */
    protected $pageId = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\CenterLevel>
     * @lazy
     */
    protected $levels = null;

    /**
     * $wayfinderActivated
     *
     * @var bool
     */
    protected $wayfinderActivated = '';

    /**
     * $wayfinderUrl
     *
     * @var string
     */
    protected $wayfinderUrl = '';

    /**
     * @var string
     */
    protected $company = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     */
    protected $phone = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $lat = '';

    /**
     * @var string
     */
    protected $lng = '';

    /**
     * @var int
     */
    protected $mapZoom = 0;

    /**
     * @var string
     */
    protected $titlePostfix = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\AppStoreLink>
     * @lazy
     */
    protected $appStoreLinks = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\SocialChannel>
     * @lazy
     */
    protected $socialChannels = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\Payment>
     * @lazy
     */
    protected $payment = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\PaymentOnlineShop>
     * @lazy
     */
    protected $paymentOnlineShop = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\Shipping>
     * @lazy
     */
    protected $shipping = null;

    /**
     * @var int
     */
    protected $overrideCoordinates = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    protected $logo = null;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $logoEmail = null;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $logoProducts = null;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    protected $logoAlt = null;

    /**
     * weekly schedule
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours>
     * @lazy
     */
    protected $weeklySchedule = null;

    /**
     * weekly schedule
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule>
     * @lazy
     */
    protected $yearlySchedule = null;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * Country
     *
     * @var \DigitalZombies\Center\Domain\Model\Misc\Country
     * @lazy
     */
    protected $country = null;

    /**
     * Timezone
     *
     * @var \DigitalZombies\Center\Domain\Model\Misc\Timezone
     * @lazy
     */
    protected $timezone = null;

    /**
     * @var array
     */
    protected $headlines = null;

    /**
     * @var int
     */
    protected $showFooterRegistration = '';

    /**
     * $darksiteTitle
     *
     * @var string
     */
    protected $darksiteTitle = '';

    /**
     * $darksiteText
     *
     * @var string
     */
    protected $darksiteText = '';

    /**
     * $loginActivated
     *
     * @var bool
     */
    protected $loginActivated = '';

    /**
     * $disablelogininweb
     *
     * @var int
     */

    protected $disableLoginInWeb = '';

    /**
     * $showSocialLogin
     *
     * @var bool
     */

    protected $showSocialLogin = '';

    /**
     * $loginActivatedChanged
     *
     * @var int
     */
    protected $loginActivatedChanged = '';

    /**
     * @var \DigitalZombies\Center\Domain\Model\Interest\InterestList
     * @lazy
     */
    protected $interestList = null;

    /**
     * $showDarksite
     *
     * @var int
     */
    protected $showDarksite = 0;

    /**
     * $hideOpenings / set in Tab Darksite, if set "closed" is shown instead of openings
     *
     * @var int
     */
    protected $hideOpenings = 0;

    /**
     * $hideAllOpenings / set in center record, if set openings are hidden
     *
     * @var int
     */
    protected $hideAllOpenings = 0;

    /**
     * $subsidiary
     *
     * @var \DigitalZombies\Center\Domain\Model\Misc\Subsidiary
     * @lazy
     */
    protected $subsidiary;

    /**
     * $contactpersonDp
     *
     * @var \DigitalZombies\Center\Domain\Model\Misc\ContactpersonDp
     * @lazy
     */
    protected $contactpersonDp;

    /**
     * @var string
     */
    protected $pushServerIosTopic = '';

    /**
     * @var string
     */
    protected $pushServerIosAuthorizationKey = '';

    /**
     * @var string
     */
    protected $pushServerAndroidTopic = '';

    /**
     * @var string
     */
    protected $pushServerAndroidAuthorizationKey = '';

    /**
     * @var int
     */
    protected $headerVariant = 0;

    /**
     *
     * @var int
     */
    protected $couponNoLogin = "";

    public function __construct()
    {
        $this->levels = new ObjectStorage();
        $this->appStoreLinks = new ObjectStorage();
        $this->socialChannels = new ObjectStorage();
        $this->weeklySchedule = new ObjectStorage();
        $this->yearlySchedule = new ObjectStorage();
        $this->payment = new ObjectStorage();
        $this->shipping = new ObjectStorage();
        $this->paymentOnlineShop = new ObjectStorage();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getAppStoreLinks()
    {
        return $this->appStoreLinks;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $appStoreLinks
     */
    public function setAppStoreLinks($appStoreLinks)
    {
        $this->appStoreLinks = $appStoreLinks;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getSocialChannels()
    {
        return $this->socialChannels;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $socialChannels
     */
    public function setSocialChannels($socialChannels)
    {
        $this->socialChannels = $socialChannels;
    }

    /**
     * @return string
     */
    public function getCenterName()
    {
        return $this->centerName;
    }

    /**
     * @param string $centerName
     */
    public function setCenterName($centerName)
    {
        $this->centerName = $centerName;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * @return int
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param int $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getGaCenter()
    {
        return $this->gaCenter;
    }

    /**
     * @param string $gaCenter
     */
    public function setGaCenter($gaCenter)
    {
        $this->gaCenter = $gaCenter;
    }

    /**
     * @return string
     */
    public function getGaEceAccount()
    {
        return $this->gaEceAccount;
    }

    /**
     * @param string $gaEceAccount
     */
    public function setGaEceAccount($gaEceAccount)
    {
        $this->gaEceAccount = $gaEceAccount;
    }

    /**
     * @return int
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @param int $pageId
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $levels
     */
    public function setLevels($levels)
    {
        $this->levels = $levels;
    }

    /**
     * @return bool
     */
    public function isWayfinderActivated()
    {
        return $this->wayfinderActivated;
    }

    /**
     * @param bool $wayfinderActivated
     */
    public function setWayfinderActivated($wayfinderActivated)
    {
        $this->wayfinderActivated = $wayfinderActivated;
    }

    /**
     * @return string
     */
    public function getWayfinderUrl()
    {
        return $this->wayfinderUrl;
    }

    /**
     * @param string $wayfinderUrl
     */
    public function setWayfinderUrl($wayfinderUrl)
    {
        $this->wayfinderUrl = $wayfinderUrl;
    }



    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param string $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return int
     */
    public function getMapZoom()
    {
        return $this->mapZoom;
    }

    /**
     * @param int $mapZoom
     */
    public function setMapZoom($mapZoom)
    {
        $this->mapZoom = $mapZoom;
    }

    /**
     * @return string
     */
    public function getTitlePostfix()
    {
        return $this->titlePostfix;
    }

    /**
     * @param string $titlePostfix
     */
    public function setTitlePostfix($titlePostfix)
    {
        $this->titlePostfix = $titlePostfix;
    }

    /**
     * @return int
     */
    public function getOverrideCoordinates()
    {
        return $this->overrideCoordinates;
    }

    /**
     * @param int $overrideCoordinates
     */
    public function setOverrideCoordinates($overrideCoordinates)
    {
        $this->overrideCoordinates = $overrideCoordinates;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getLogo()
    {
        if ($this->logo instanceof LazyLoadingProxy) {
            $this->logo->_loadRealInstance();
        }
        return $this->logo;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     */
    public function setLogo(FileReference $logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getLogoAlt()
    {
        if ($this->logoAlt instanceof LazyLoadingProxy) {
            $this->logoAlt->_loadRealInstance();
        }
        return $this->logoAlt;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logoAlt
     */
    public function setLogoAlt(FileReference $logoAlt)
    {
        $this->logo = $logoAlt;
    }

    /**
     * @return int
     */
    public function getShowFooterRegistration()
    {
        return $this->showFooterRegistration;
    }

    /**
     * @param int $showFooterRegistration
     */
    public function setShowFooterRegistration($showFooterRegistration)
    {
        $this->showFooterRegistration = $showFooterRegistration;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getWeeklySchedule()
    {
        return $this->weeklySchedule;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $weeklySchedule
     */
    public function setWeeklySchedule(ObjectStorage $weeklySchedule)
    {
        $this->weeklySchedule = $weeklySchedule;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getYearlySchedule()
    {
        return $this->yearlySchedule;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $yearlySchedule
     */
    public function setYearlySchedule(ObjectStorage $yearlySchedule)
    {
        $this->yearlySchedule = $yearlySchedule;
    }

    /**
     * @return \DigitalZombies\Center\Domain\Model\Misc\Country
     */
    public function getCountry(): Country
    {
        if ($this->country instanceof LazyLoadingProxy) {
            $this->country->_loadRealInstance();
        }
        return $this->country;
    }

    /**
     * @param \DigitalZombies\Center\Domain\Model\Misc\Country $country
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;
    }

    /**
     * @return \DigitalZombies\Center\Domain\Model\Misc\Timezone
     */
    public function getTimezone(): Timezone
    {
        if ($this->timezone instanceof LazyLoadingProxy) {
            $this->timezone->_loadRealInstance();
        }
        return $this->timezone;
    }

    /**
     * @param \DigitalZombies\Center\Domain\Model\Misc\Timezone $timezone
     */
    public function setTimezone(Timezone $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * Returns an array with opening hours
     *
     * @return array
     */
    public function getOpeningHours()
    {
        return OpeningHoursHelper::createOpeningHoursForCenter('');
    }

    /**
     * Returns the headlines, if there any for the given center
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getHeadlines()
    {
        if (is_null($this->headlines)) {
            $this->headlines = HeadlinesHelper::getHeadlines($this);
        }
        return $this->headlines;
    }

    /**
     * @return string
     */
    public function getDarksiteTitle()
    {
        return $this->darksiteTitle;
    }

    /**
     * @param string $darksiteTitle
     */
    public function setDarksiteTitle($darksiteTitle)
    {
        $this->darksiteTitle = $darksiteTitle;
    }

    /**
     * @return string
     */
    public function getDarksiteText()
    {
        return $this->darksiteText;
    }

    /**
     * @param string $darksiteText
     */
    public function setDarksiteText($darksiteText)
    {
        $this->darksiteText = $darksiteText;
    }

    /**
     * @return string
     */
    public function getShowDarksite()
    {
        return $this->showDarksite;
    }

    /**
     * @param string $showDarksite
     */
    public function setShowDarksite($showDarksite)
    {
        $this->darksiteText = $showDarksite;
    }

    /**
     * @return int
     */
    public function getHideOpenings()
    {
        return $this->hideOpenings;
    }

    /**
     * @param int $hideOpenings
     */
    public function setHideOpenings(int $hideOpenings)
    {
        $this->hideOpenings = $hideOpenings;
    }

    /**
     * @return int
     */
    public function getHideAllOpenings()
    {
        return $this->hideAllOpenings;
    }

    /**
     * @param int $hideAllOpenings
     */
    public function setHideAllOpenings(int $hideAllOpenings)
    {
        $this->hideAllOpenings = $hideAllOpenings;
    }


    /**
     * @return bool
     */
    public function isLoginActivated(): bool
    {
        return $this->loginActivated;
    }

    /**
     * @param bool $loginActivated
     */
    public function setLoginActivated(bool $loginActivated)
    {
        $this->loginActivated = $loginActivated;
    }

    /**
     * @return int
     */
    public function getLoginActivatedChanged(): int
    {
        return $this->loginActivatedChanged;
    }

    /**
     * @param int $loginActivatedChanged
     */
    public function setLoginActivatedChanged(int $loginActivatedChanged)
    {
        $this->loginActivatedChanged = $loginActivatedChanged;
    }

    /**
     * @return \DigitalZombies\Center\Domain\Model\Interest\InterestList
     */
    public function getInterestList()
    {
        if ($this->interestList instanceof LazyLoadingProxy) {
            $this->interestList->_loadRealInstance();
        }
        return $this->interestList;
    }

    /**
     * @param |DigitalZombies\Center\Domain\Model\Interest\InterestList $interestList
     */
    public function setInterestList($interestList)
    {
        $this->interestList = $interestList;
    }

    /**
     * Returns the alternative and darker logo for teasers if available, otherwise returns the primary center logo
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
     */
    public function getThumbnail()
    {
        return ($this->getLogoAlt())
            ? $this->getLogoAlt()
            : $this->getLogo();
    }

    /**
     * @param int $days
     * @return array
     */
    public function getUpcomingSpecialClosingDays($days = 7)
    {
        $comingSpecialClosingDays = [];

        /** @var YearlySchedule $yearlySchedule */
        foreach ($this->getYearlySchedule() as $yearlySchedule) {
            /** @var SpecialClosingDay $specialClosingDay */
            foreach ($yearlySchedule->getSpecialClosingDays() as $specialClosingDay) {
                if ($specialClosingDay->getClosingDay()
                    && $specialClosingDay->getClosingDay() < time() + ($days * 86400)
                    && $specialClosingDay->getClosingDay() > time() - 86400) {
                    $comingSpecialClosingDays[$specialClosingDay->getClosingDay() . '-' . $specialClosingDay->getUid()]
                        = $specialClosingDay;
                }
            }
        }
        ksort($comingSpecialClosingDays);
        return $comingSpecialClosingDays;
    }


    /**
     * @param int $days
     * @return array
     */
    public function getUpcomingHolidays($days = 366)
    {
        $upcomingHolidays = [];

        /** @var YearlySchedule $yearlySchedule */
        foreach ($this->getYearlySchedule() as $yearlySchedule) {
            /** @var Holiday $holiday */
            foreach ($yearlySchedule->getHolidays() as $holiday) {
                if ($holiday->getClosingDay()
                    && $holiday->getClosingDay() < time() + ($days * 86400)
                    && $holiday->getClosingDay() > time() - 86400) {
                    $upcomingHolidays[$holiday->getClosingDay() . '-' . $holiday->getUid()]
                        = $holiday;
                }
            }
        }
        ksort($upcomingHolidays);
        return $upcomingHolidays;
    }

    /**
     * @return array
     */
    public function getNextHolidayOrSpecialClosingDay()
    {
        $minimumDate = 10000000000;
        $selectedObject = [];

        /** @var YearlySchedule $yearlySchedule */
        foreach ($this->getYearlySchedule() as $yearlySchedule) {
            /** @var Holiday $holiday */
            foreach ($yearlySchedule->getHolidays() as $holiday) {
                if ($holiday->getClosingDay()
                    && $holiday->getClosingDay() > time() - 86400
                    && $holiday->getClosingDay() <= $minimumDate) {
                    $minimumDate = $holiday->getClosingDay();
                    $selectedObject = [
                        'name' => $holiday->getName(),
                        'date' => $minimumDate,
                        'isOpen' => false,
                    ];
                }
            }
            /** @var SpecialClosingDay $specialClosingDay */
            foreach ($yearlySchedule->getSpecialClosingDays() as $specialClosingDay) {
                if ($specialClosingDay->getClosingDay()
                    && $specialClosingDay->getClosingDay() > time() - 86400
                    && $specialClosingDay->getClosingDay() <= $minimumDate) {
                    $minimumDate = $specialClosingDay->getClosingDay();
                    $selectedObject = [
                        'name' => $specialClosingDay->getName(),
                        'date' => $minimumDate,
                        'isOpen' => $specialClosingDay->hasHoursSet(),
                        'from' => $specialClosingDay->getFrom(),
                        'till' => $specialClosingDay->getTill()
                    ];
                }
            }
        }

        return $selectedObject;
    }

    /**
     * @return FileReference
     */
    public function getLogoEmail()
    {
        return $this->logoEmail;
    }

    /**
     * @param FileReference $logoEmail
     */
    public function setLogoEmail(FileReference $logoEmail)
    {
        $this->logoEmail = $logoEmail;
    }

    /**
     * @return bool
     */
    public function isShowSocialLogin()
    {
        return $this->showSocialLogin;
    }

    /**
     * @param bool $showSocialLogin
     */
    public function setShowSocialLogin(bool $showSocialLogin)
    {
        $this->showSocialLogin = $showSocialLogin;
    }

    /**
     * @return int
     */
    public function getDisableLoginInWeb()
    {
        return $this->disableLoginInWeb;
    }

    /**
     * @param int $disableLoginInWeb
     */
    public function setDisableLoginInWeb(int $disableLoginInWeb)
    {
        $this->disableLoginInWeb = $disableLoginInWeb;
    }

    /**
     * @return \DigitalZombies\Center\Domain\Model\Misc\Subsidiary
     */
    public function getSubsidiary()
    {
        if ($this->subsidiary instanceof LazyLoadingProxy) {
            $this->subsidiary->_loadRealInstance();
        }
        return $this->subsidiary;
    }

    /**
     * @param \DigitalZombies\Center\Domain\Model\Misc\Subsidiary $subsidiary
     */
    public function setSubsidiary(Subsidiary $subsidiary)
    {
        $this->subsidiary = $subsidiary;
    }

    /**
     * @return \DigitalZombies\Center\Domain\Model\Misc\ContactpersonDp
     */
    public function getContactpersonDp()
    {
        if ($this->contactpersonDp instanceof LazyLoadingProxy) {
            $this->contactpersonDp->_loadRealInstance();
        }
        return $this->contactpersonDp;
    }

    /**
     * @param \DigitalZombies\Center\Domain\Model\Misc\ContactpersonDp $contactpersonDp
     */
    public function setContactpersonDp(ContactpersonDp $contactpersonDp)
    {
        $this->contactpersonDp = $contactpersonDp;
    }

    /**
     * @return string
     */
    public function getGtmEceAccount()
    {
        return $this->gtmEceAccount;
    }

    /**
     * @param string $gtmEceAccount
     */
    public function setGtmEceAccount($gtmEceAccount)
    {
        $this->gtmEceAccount = $gtmEceAccount;
    }

    /**
     * @return int
     */
    public function getUseGtmEceAccount()
    {
        return $this->useGtmEceAccount;
    }

    /**
     * @param int $useGtmEceAccount
     */
    public function setUseGtmEceAccount($useGtmEceAccount)
    {
        $this->useGtmEceAccount = $useGtmEceAccount;
    }

    /**
     * @return int
     */
    public function getCouponNoLogin()
    {
        return $this->couponNoLogin;
    }

    /**
     * @param int $couponNoLogin
     */
    public function setCouponNoLogin($couponNoLogin)
    {
        $this->couponNoLogin = $couponNoLogin;
    }

    /**
     * @return string
     */
    public function getFacebookPixel()
    {
        return $this->facebookPixel;
    }

    /**
     * @param string $facebookPixel
     */
    public function setFacebookPixel($facebookPixel)
    {
        $this->facebookPixel = $facebookPixel;
    }

    /**
     * @return string
     */
    public function getPushServerIosTopic()
    {
        return $this->pushServerIosTopic;
    }

    /**
     * @param string $pushServerIosTopic
     */
    public function setPushServerIosTopic($pushServerIosTopic)
    {
        $this->pushServerIosTopic = $pushServerIosTopic;
    }

    /**
     * @return string
     */
    public function getPushServerIosAuthorizationKey()
    {
        return $this->pushServerIosAuthorizationKey;
    }

    /**
     * @param string $pushServerIosAuthorizationKey
     */
    public function setPushServerIosAuthorizationKey($pushServerIosAuthorizationKey)
    {
        $this->pushServerIosAuthorizationKey = $pushServerIosAuthorizationKey;
    }

    /**
     * @return string
     */
    public function getPushServerAndroidTopic()
    {
        return $this->pushServerAndroidTopic;
    }

    /**
     * @param string $pushServerAndroidTopic
     */
    public function setPushServerAndroidTopic($pushServerAndroidTopic)
    {
        $this->pushServerAndroidTopic = $pushServerAndroidTopic;
    }

    /**
     * @return string
     */
    public function getPushServerAndroidAuthorizationKey()
    {
        return $this->pushServerAndroidAuthorizationKey;
    }

    /**
     * @param string $pushServerAndroidAuthorizationKey
     */
    public function setPushServerAndroidAuthorizationKey($pushServerAndroidAuthorizationKey)
    {
        $this->pushServerAndroidAuthorizationKey = $pushServerAndroidAuthorizationKey;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getPaymentOnlineShop()
    {
        return $this->paymentOnlineShop;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $paymentOnlineShop
     */
    public function setPaymentOnlineShop($paymentOnlineShop)
    {
        $this->paymentOnlineShop = $paymentOnlineShop;
    }

    /**
     * @return FileReference
     */
    public function getLogoProducts()
    {
        return $this->logoProducts;
    }

    /**
     * @param FileReference $logoProducts
     */
    public function setLogoProducts(FileReference $logoProducts)
    {
        $this->logoProducts = $logoProducts;
    }


    /**
     * @return int
     */
    public function getHeaderVariant(): int
    {
        return $this->headerVariant;
    }

    /**
     * @param int $headerVariant
     */
    public function setHeaderVariant(int $headerVariant)
    {
        $this->headerVariant = $headerVariant;
    }
}
