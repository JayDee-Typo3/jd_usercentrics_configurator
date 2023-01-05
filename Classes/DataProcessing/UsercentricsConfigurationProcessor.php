<?php

namespace JD\JdUsercentricsConfigurator\DataProcessing;

use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use JD\JdUsercentricsConfigurator\Services\PageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Class UsercentricsConfigurationProcessor
 *
 * @package JD\JdUsercentricsConfigurator\DataProcessing
 * @author Johannes Delesky, Developer
 */
class UsercentricsConfigurationProcessor implements DataProcessorInterface
{
    /**
     * ConfigRepository
     *
     * @var ConfigRepository $configRepository
     */
    protected ConfigRepository $configRepository;

    /**
     * UsercentricsConfigurationProcessor constructor.
     */
    public function __construct()
    {
        $this->configRepository = GeneralUtility::makeInstance(ConfigRepository::class);
    }

    /**
     * {@inheritDoc}
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        $as = $cObj->stdWrapValue('as', $processorConfiguration, 'usercentrics');
        $rootPageId = $cObj->stdWrapValue('rootPageId', $processorConfiguration, 1);

        if (PageService::isPageRootPage($rootPageId)) {
            $processedData[$as] = $this->configRepository->getActiveConfigurationByRootPageId($rootPageId);
        }

        return $processedData;
    }
}