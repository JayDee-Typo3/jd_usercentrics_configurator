<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'JdUsercentricsConfigurator',
        'system',
        'ucconf',
        '',
        [
            \JD\JdUsercentricsConfigurator\Controller\ConfigController::class => 'list, show, new, create, edit, update, delete',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:jd_usercentrics_configurator/Resources/Public/Icons/usercentrics.png',
            'labels' => 'LLL:EXT:jd_usercentrics_configurator/Resources/Private/Language/locallang_ucconf.xlf',
            'navigationComponentId' => 'TYPO3/CMS/Backend/PageTree/PageTreeElement',
            'inheritNavigationComponentFromMainModule' => FALSE,
        ]
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_jdusercentricsconfigurator_domain_model_config', 'EXT:jd_usercentrics_configurator/Resources/Private/Language/locallang_csh_tx_jdusercentricsconfigurator_domain_model_config.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_jdusercentricsconfigurator_domain_model_config');

    $GLOBALS['TBE_STYLES']['skins']['jd_usercentrics_configurator']['stylesheetDirectories'] = ['EXT:jd_usercentrics_configurator/Resources/Public/Backend/StyleSheet/'];
})();
