<?php


namespace JD\JdUsercentricsConfigurator\Traits;


use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Trait BackendViewTrait
 * @package JD\JdUsercentricsConfigurator\Traits
 * @author Johannes Delesky, Developer
 */
trait BackendViewTrait
{

    /**
     * @var string[][]
     */
    public static $backViewPaths = [
        'layoutRootPaths' => [
            'EXT:jd_usercentrics_configurator/Resources/Private/Backend/Layouts'
        ],
        'templateRootPaths' => [
            'EXT:jd_usercentrics_configurator/Resources/Private/Backend/Templates'
        ],
        'partialRootPaths' => [
            'EXT:jd_usercentrics_configurator/Resources/Private/Backend/Partials'
        ]
    ];

    /**
     * @param string $target
     * @param string $path
     */
    public static function prependPath(string $target, string $path)
    {
        self::resolveConfiguredPaths($target);
        array_unshift(self::$backViewPaths[$target], $path);
    }

    /**
     * @param string $target
     */
    private static function resolveConfiguredPaths(string $target)
    {
        foreach (self::$backViewPaths[$target] as &$path)
            $path = GeneralUtility::getFileAbsFileName($path);

    }
}