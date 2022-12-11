<?php


namespace JD\JdUsercentricsConfigurator\Traits;


use TYPO3\CMS\Core\Utility\GeneralUtility;

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

    public static function prependPath(string $target, string $path)
    {
        self::resolveConfiguredPaths($target);
        array_unshift(self::$backViewPaths[$target], $path);
    }

    private static function resolveConfiguredPaths(string $target)
    {
        foreach (self::$backViewPaths[$target] as &$path)
            $path = GeneralUtility::getFileAbsFileName($path);

    }
}