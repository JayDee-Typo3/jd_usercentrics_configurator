<?php


namespace JD\JdUsercentricsConfigurator\Hooks;

use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use T3G\AgencyPack\Usercentrics\Hooks\PageRendererPreProcess as T3GPageRendererPreProcess;
use TYPO3\CMS\Core\Http\Request;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageRendererPreProcess extends T3GPageRendererPreProcess
{

    /**
     * @var AssetCollector
     */
    private $assetCollector;

    /**
     * @var Request $request
     */
    private Request $request;

    /**
     * @var array|NULL $ucConfig
     */
    private $ucConfig = NULL;

    public function __construct(AssetCollector $assetCollector = null)
    {
        $this->assetCollector = $assetCollector ?? GeneralUtility::makeInstance(AssetCollector::class);
        $this->request = $GLOBALS['TYPO3_REQUEST'];
        $this->ucConfig = GeneralUtility::makeInstance(ConfigRepository::class)->getActiveConfigurationByRootPageId(
            $this->request->getAttribute('site')->getRootpageId()
        );
    }

    public function addLibrary(): void
    {
        if(!empty($this->ucConfig) && $this->ucConfig['activate']) {
            $config = $this->getTypoScriptConfiguration();
            if ($config === NULL)
                return;

            $this->addUsercentricsCMP2Script();
            $this->addSmartDataProtector();
            $this->addConfiguredJsFiles($config['jsFiles.'] ?? []);
            $this->addConfiguredInlineJavaScript($config['jsInline.'] ?? []);
        }
    }

    protected function addUsercentricsCMP2Script()
    {
        $this->assetCollector->addJavaScript(
            'usercentricsCMP2',
            'https://app.usercentrics.eu/browser-ui/latest/loader.js',
            [
                'type' => 'application/javascript',
                'settings-id' => $this->ucConfig['settingsId'],
                'async' => ''
            ]
        );
    }

    protected function addSmartDataProtector()
    {
        $this->assetCollector->addJavaScript(
            'smartDataProtector',
            'https://privacy-proxy.usercentrics.eu/latest/uc-block.bundle.js',
            ['type' => 'application/javascript']
        );

        if (!empty($this->ucConfig['block_only']))
            $this->assetCollector->addInlineJavaScript(
                'smartDataProtectorBlockOnly',
                'uc.blockOnly([' . $this->ucConfig['block_only'] . ']);',
                [
                    'type' => 'text/javascript'
                ]
            );
    }
}