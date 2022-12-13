<?php
namespace JD\JdUsercentricsConfigurator\Services;

use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;

/**
 * Class TyposcriptReaderService
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
class TyposcriptReaderService
{
    /**
     * The typoscript settings of all Plugins
     *
     * @var array $plugins
     */
    private static $plugins = [];

    /**
     * The typoscript settings of all modules
     *
     * @var array
     */
    private static $module = [];

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
        $typoscript = $tsService->convertTypoScriptArrayToPlainArray(
            $configurationManager->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
            )
        );
        self::$plugins = $typoscript['plugin'];
        self::$module = $typoscript['module'];
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

    public static function getModuleTyposcript(string $module): array
    {
        if (empty(self::$module))
            self::initClass();

        if (isset(self::$module[$module]) && !empty(self::$module[$module]))
            return self::$module[$module];

        return [];
    }

    public static function getModuleSettings(string $module): array
    {
        if (empty(self::$module))
            self::initClass();

        if ($tsModule = self::getModuleTyposcript($module))
            return $tsModule['settings'];

        return [];
    }
}