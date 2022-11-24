<?php


namespace JD\JdUsercentricsConfigurator\Hooks;

use T3G\AgencyPack\Usercentrics\Hooks\PageRendererPreProcess as T3GPageRendererPreProcess;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageRendererPreProcess extends T3GPageRendererPreProcess
{

    /**
     * @var \TYPO3\CMS\Core\Page\AssetCollector
     */
    private $assetCollector;

    public function __construct(AssetCollector $assetCollector = null)
    {
        $this->assetCollector = $assetCollector ?? GeneralUtility::makeInstance(AssetCollector::class);
    }

    public function addLibrary(): void
    {

    }
}