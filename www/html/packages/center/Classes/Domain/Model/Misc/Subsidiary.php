<?php
/**
 * Created by PhpStorm.
 * User: miltzd
 * Date: 20.06.2018
 * Time: 08:53
 */

namespace DigitalZombies\Center\Domain\Model\Misc;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Subsidiary extends AbstractEntity
{
    /**
     * $dataProtectionLgCompany
     *
     * @var string
     */
    protected $dataProtectionLgCompany = '';

    /**
     * $dataProtectionLgStreet
     *
     * @var string
     */
    protected $dataProtectionLgStreet = '';

    /**
     * $dataProtectionLgCity
     *
     * @var string
     */
    protected $dataProtectionLgCity = '';

    /**
     * $dataProtectionLgPhone
     *
     * @var string
     */
    protected $dataProtectionLgPhone = '';

    /**
     * $dataProtectionLgFax
     *
     * @var string
     */
    protected $dataProtectionLgFax = '';

    /**
     * $dataProtectionLgEmail
     *
     * @var string
     */
    protected $dataProtectionLgEmail = '';

    /**
     * @return string
     */
    public function getDataProtectionLgCompany()
    {
        return $this->dataProtectionLgCompany;
    }

    /**
     * @param string $dataProtectionLgCompany
     */
    public function setDataProtectionLgCompany(string $dataProtectionLgCompany)
    {
        $this->dataProtectionLgCompany = $dataProtectionLgCompany;
    }

    /**
     * @return string
     */
    public function getDataProtectionLgStreet()
    {
        return $this->dataProtectionLgStreet;
    }

    /**
     * @param string $dataProtectionLgStreet
     */
    public function setDataProtectionLgStreet(string $dataProtectionLgStreet)
    {
        $this->dataProtectionLgStreet = $dataProtectionLgStreet;
    }

    /**
     * @return string
     */
    public function getDataProtectionLgCity()
    {
        return $this->dataProtectionLgCity;
    }

    /**
     * @param string $dataProtectionLgCity
     */
    public function setDataProtectionLgCity(string $dataProtectionLgCity)
    {
        $this->dataProtectionLgCity = $dataProtectionLgCity;
    }

    /**
     * @return string
     */
    public function getDataProtectionLgPhone()
    {
        return $this->dataProtectionLgPhone;
    }

    /**
     * @param string $dataProtectionLgPhone
     */
    public function setDataProtectionLgPhone(string $dataProtectionLgPhone)
    {
        $this->dataProtectionLgPhone = $dataProtectionLgPhone;
    }

    /**
     * @return string
     */
    public function getDataProtectionLgFax()
    {
        return $this->dataProtectionLgFax;
    }

    /**
     * @param string $dataProtectionLgFax
     */
    public function setDataProtectionLgFax(string $dataProtectionLgFax)
    {
        $this->dataProtectionLgFax = $dataProtectionLgFax;
    }

    /**
     * @return string
     */
    public function getDataProtectionLgEmail()
    {
        return $this->dataProtectionLgEmail;
    }

    /**
     * @param string $dataProtectionLgEmail
     */
    public function setDataProtectionLgEmail(string $dataProtectionLgEmail)
    {
        $this->dataProtectionLgEmail = $dataProtectionLgEmail;
    }
}





