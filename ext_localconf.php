<?php
defined('TYPO3') || die();

(static function() {
    $overrideClasses = [
        \T3G\AgencyPack\Usercentrics\Hooks\PageRendererPreProcess::class => \JD\JdUsercentricsConfigurator\Hooks\PageRendererPreProcess::class,
        \TYPO3\CMS\Core\Resource\Rendering\YouTubeRenderer::class => \JD\JdUsercentricsConfigurator\Resource\Rendering\JdYoutubeRenderer::class,
        \TYPO3\CMS\Core\Resource\Rendering\VimeoRenderer::class => \JD\JdUsercentricsConfigurator\Resource\Rendering\JdVimeoRenderer::class,
        \TYPO3\CMS\Core\DataHandling\DataHandler::class => \JD\JdUsercentricsConfigurator\DataHandling\JdDataHandler::class
    ];
    foreach ($overrideClasses as $origin => $target)
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$origin] = [
            'className' => $target
        ];
})();