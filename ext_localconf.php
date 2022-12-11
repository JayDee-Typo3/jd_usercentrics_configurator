<?php
defined('TYPO3') || die();

(static function() {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\T3G\AgencyPack\Usercentrics\Hooks\PageRendererPreProcess::class] = [
        'className' => \JD\JdUsercentricsConfigurator\Hooks\PageRendererPreProcess::class
    ];
})();