<?php

declare(strict_types=1);

namespace JD\JdUsercentricsConfigurator\Domain\Model;


use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * This file is part of the "Usercentrics Configurator" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */

/**
 * Class Config
 * @package JD\JdUsercentricsConfigurator\Domain\Model
 * @author Johannes Delesky, Developer
 */
class Config extends AbstractEntity
{

    /**
     * settingsId
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $settingsId = '';

    /**
     * activate
     *
     * @var bool
     */
    protected $activate = FALSE;

    /**
     * useFooterLink
     *
     * @var bool
     */
    protected $useFooterLink = FALSE;

    /**
     * useGtm
     *
     * @var bool
     */
    protected $useGtm = FALSE;

    /**
     * @var string $gtmId
     */
    protected $gtmId = '';

    /**
     * blockOnly
     *
     * @var string
     */
    protected $blockOnly = '';

    /**
     * blockElements
     *
     * @var string
     */
    protected $blockElements = '';

    /**
     * Returns the settingsId
     *
     * @return string
     */
    public function getSettingsId()
    {
        return $this->settingsId;
    }

    /**
     * Sets the settingsId
     *
     * @param string $settingsId
     * @return void
     */
    public function setSettingsId(string $settingsId)
    {
        $this->settingsId = $settingsId;
    }

    /**
     * Returns the activate
     *
     * @return bool
     */
    public function getActivate()
    {
        return $this->activate;
    }

    /**
     * Sets the activate
     *
     * @param bool $activate
     * @return void
     */
    public function setActivate(bool $activate)
    {
        $this->activate = $activate;
    }

    /**
     * Returns the boolean state of activate
     *
     * @return bool
     */
    public function isActivate()
    {
        return $this->activate;
    }

    /**
     * Returns the useFooterLink
     *
     * @return bool
     */
    public function getUseFooterLink()
    {
        return $this->useFooterLink;
    }

    /**
     * Sets the useFooterLink
     *
     * @param bool $useFooterLink
     * @return void
     */
    public function setUseFooterLink(bool $useFooterLink)
    {
        $this->useFooterLink = $useFooterLink;
    }

    /**
     * Returns the boolean state of useFooterLink
     *
     * @return bool
     */
    public function isUseFooterLink()
    {
        return $this->useFooterLink;
    }

    /**
     * Returns the useGtm
     *
     * @return bool
     */
    public function getUseGtm()
    {
        return $this->useGtm;
    }

    /**
     * @return string
     */
    public function getGtmId(): string
    {
        return $this->gtmId;
    }

    /**
     * @param string $gtmId
     */
    public function setGtmId(string $gtmId): void
    {
        $this->gtmId = $gtmId;
    }

    /**
     * Sets the useGtm
     *
     * @param bool $useGtm
     * @return void
     */
    public function setUseGtm(bool $useGtm)
    {
        $this->useGtm = $useGtm;
    }

    /**
     * Returns the boolean state of useGtm
     *
     * @return bool
     */
    public function isUseGtm()
    {
        return $this->useGtm;
    }

    /**
     * Returns the blockOnly
     *
     * @return string
     */
    public function getBlockOnly()
    {
        return $this->blockOnly;
    }

    /**
     * Sets the blockOnly
     *
     * @param string $blockOnly
     * @return void
     */
    public function setBlockOnly(string $blockOnly)
    {
        $this->blockOnly = $blockOnly;
    }

    /**
     * Returns the blockElements
     *
     * @return string
     */
    public function getBlockElements()
    {
        return $this->blockElements;
    }

    /**
     * Sets the blockElements
     *
     * @param string $blockElements
     * @return void
     */
    public function setBlockElements(string $blockElements)
    {
        $this->blockElements = $blockElements;
    }
}
