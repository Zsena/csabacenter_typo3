<?php

/**
 * Created by PhpStorm.
 * User: miltzd
 * Date: 20.06.2018
 * Time: 08:53
 */

namespace DigitalZombies\Center\Domain\Model\Misc;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class ContactpersonDp extends AbstractEntity
{
    /**
     * $dataProtectionDbName
     *
     * @var string
     */
    protected $dataProtectionDbName = '';

    /**
     * $dataProtectionDbCompany
     *
     * @var string
     */
    protected $dataProtectionDbCompany = '';

    /**
     * $dataProtectionDbStreet
     *
     * @var string
     */
    protected $dataProtectionDbStreet = '';

    /**
     * $dataProtectionDbCity
     *
     * @var string
     */
    protected $dataProtectionDbCity = '';

    /**
     * $dataProtectionDbPhone
     *
     * @var string
     */
    protected $dataProtectionDbPhone = '';

    /**
     * $dataProtectionDbEmail
     *
     * @var string
     */
    protected $dataProtectionDbEmail = '';

    /**
     * @return string
     */
    public function getDataProtectionDbName()
    {
        return $this->dataProtectionDbName;
    }

    /**
     * @param string $dataProtectionDbName
     */
    public function setDataProtectionDbName(string $dataProtectionDbName)
    {
        $this->dataProtectionDbName = $dataProtectionDbName;
    }

    /**
     * @return string
     */
    public function getDataProtectionDbCompany()
    {
        return $this->dataProtectionDbCompany;
    }

    /**
     * @param string $dataProtectionDbCompany
     */
    public function setDataProtectionDbCompany(string $dataProtectionDbCompany)
    {
        $this->dataProtectionDbCompany = $dataProtectionDbCompany;
    }

    /**
     * @return string
     */
    public function getDataProtectionDbStreet()
    {
        return $this->dataProtectionDbStreet;
    }

    /**
     * @param string $dataProtectionDbStreet
     */
    public function setDataProtectionDbStreet(string $dataProtectionDbStreet)
    {
        $this->dataProtectionDbStreet = $dataProtectionDbStreet;
    }

    /**
     * @return string
     */
    public function getDataProtectionDbCity()
    {
        return $this->dataProtectionDbCity;
    }

    /**
     * @param string $dataProtectionDbCity
     */
    public function setDataProtectionDbCity(string $dataProtectionDbCity)
    {
        $this->dataProtectionDbCity = $dataProtectionDbCity;
    }

    /**
     * @return string
     */
    public function getDataProtectionDbPhone()
    {
        return $this->dataProtectionDbPhone;
    }

    /**
     * @param string $dataProtectionDbPhone
     */
    public function setDataProtectionDbPhone(string $dataProtectionDbPhone)
    {
        $this->dataProtectionDbPhone = $dataProtectionDbPhone;
    }

    /**
     * @return string
     */
    public function getDataProtectionDbEmail()
    {
        return $this->dataProtectionDbEmail;
    }

    /**
     * @param string $dataProtectionDbEmail
     */
    public function setDataProtectionDbEmail(string $dataProtectionDbEmail)
    {
        $this->dataProtectionDbEmail = $dataProtectionDbEmail;
    }
}





