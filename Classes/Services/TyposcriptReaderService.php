<?php
namespace JD\JdUsercentricsConfigurator\Services;

use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;

class TyposcriptReaderService
{
    /**
     * The typoscript settings of all Plugins
     *
     * @var array $plugins
     */
    private static $plugins = [];

    /**
     * Initialize this Class
     *
     * @throws InvalidConfigurationTypeException
     */
    public static function initClass()
    {
        /** @var ConfigurationManager $configurationManager */
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        /** @var TypoScriptService $tsService */
        $tsService = GeneralUtility::makeInstance(TypoScriptService::class);
        self::$plugins = $tsService->convertTypoScriptArrayToPlainArray(
            $configurationManager->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
            )
        )['plugin'];
    }

    /**
     * Extract the plugin configuration if exists.
     *
     * @param string $plugin
     *
     * @return array
     *
     * @throws InvalidConfigurationTypeException
     */
    public static function getPluginTyposcript(string $plugin): array
    {
        if (empty(self::$plugins))
            self::initClass();

        if (isset(self::$plugins[$plugin]) && !empty(self::$plugins[$plugin]))
            return self::$plugins[$plugin];

        return [];
    }

    /**
     * Extract the plugin settings from typoscript.
     *
     * @param string $plugin
     *
     * @return array
     *
     * @throws InvalidConfigurationTypeException
     */
    public static function getPluginSettings(string $plugin): array
    {
        if (empty(self::$plugins))
            self::initClass();

        if (isset(self::$plugins[$plugin]) && !empty(self::$plugins[$plugin]))
            return self::$plugins[$plugin]['settings'];

        return [];

    }
}