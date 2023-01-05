<?php


namespace JD\JdUsercentricsConfigurator\Hooks;

use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use T3G\AgencyPack\Usercentrics\Hooks\PageRendererPreProcess as T3GPageRendererPreProcess;
use TYPO3\CMS\Core\Http\Request;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PageRendererPreProcess
 *
 * @package JD\JdUsercentricsConfigurator\Hooks
 * @author Johannes Delesky, Developer
 */
class PageRendererPreProcess extends T3GPageRendererPreProcess
{

    /**
     * @var AssetCollector
     */
    private AssetCollector $assetCollector;

    /**
     * @var Request $request
     */
    private Request $request;

    /**
     * @var array|NULL $ucConfig
     */
    private $ucConfig = NULL;

    /**
     * PageRendererPreProcess constructor.
     * @param AssetCollector|null $assetCollector
     */
    public function __construct(AssetCollector $assetCollector = null)
    {
        $this->assetCollector = $assetCollector ?? GeneralUtility::makeInstance(AssetCollector::class);
        $this->request = $GLOBALS['TYPO3_REQUEST'];
        $this->ucConfig = GeneralUtility::makeInstance(ConfigRepository::class)->getActiveConfigurationByRootPageId(
            $this->request->getAttribute('site')->getRootpageId()
        );
    }

    /**
     * Add JavaScript and Library to page.
     *
     * @return void
     */
    public function addLibrary(): void
    {
        if(!empty($this->ucConfig) && $this->ucConfig['activate']) {
            $config = $this->getTypoScriptConfiguration();
            if ($config === NULL)
                return;

            $this->addUsercentricsCMP2Script();
            $this->addSmartDataProtector();
            if ($this->ucConfig['use_gtm'] && $this->ucConfig['gtm_id'])
                $this->addGoogleTagManagerScript();

            $this->addConfiguredJsFiles($config['jsFiles.'] ?? []);
            $this->addConfiguredInlineJavaScript($config['jsInline.'] ?? []);
        }
    }

    /**
     * Add Usercentrics Library
     *
     * @return void
     */
    protected function addUsercentricsCMP2Script(): void
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

    /**
     * Add Smart DataProtector
     *
     * @return void
     */
    protected function addSmartDataProtector(): void
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

    /**
     * Add Google Tag Manager
     *
     * @return void
     */
    protected function addGoogleTagManagerScript(): void
    {
        $this->assetCollector->addInlineJavaScript(
            'gtmIntegration',
            "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                    })(window,document,'script','dataLayer','" . $this->ucConfig['gtmId'] . "');",
            [
                'type' => 'text/plain',
                'data-usercentrics' => 'Google Tag Manager'
            ]
        );
    }
}