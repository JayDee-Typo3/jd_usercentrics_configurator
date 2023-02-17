<?php

declare(strict_types=1);

namespace JD\JdUsercentricsConfigurator\Controller;


use JD\JdUsercentricsConfigurator\Domain\Model\Config;
use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use JD\JdUsercentricsConfigurator\Services\DeAndEncodeService;
use JD\JdUsercentricsConfigurator\Services\ErrorService;
use JD\JdUsercentricsConfigurator\Services\FileService;
use JD\JdUsercentricsConfigurator\Services\PageService;
use JD\JdUsercentricsConfigurator\Services\TyposcriptReaderService;
use JD\JdUsercentricsConfigurator\Services\UsercentricsConfigurationService;
use JD\JdUsercentricsConfigurator\Services\ViewService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * This file is part of the "Usercentrics Configurator" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */

/**
 * Class ConfigController
 *
 * @package JD\JdUsercentricsConfigurator\Controller
 * @author Johannes Delesky, Developer
 */
class ConfigController extends ActionController
{

    /**
     * configRepository
     *
     * @var ConfigRepository
     */
    protected $configRepository = null;

    /**
     * @param ConfigRepository $configRepository
     */
    public function injectConfigRepository(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Initialize the backend view.
     *
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);
        ViewService::extendViewByBackendPaths($view);
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        if (!$this->request->getAttribute('site') instanceof Site)
            $this->view->assign('error', ErrorService::addNotARootpageError());
        else if (!PageService::isSelectedPageRootPage($this->request->getAttribute('site'), $this->request->getQueryParams()))
            $this->view->assign('error', ErrorService::addNotARootpageError());

        $configs = $this->configRepository->findAll();
        $this->view->assignMultiple([
            'configs' => $configs
        ]);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param Config $config
     * @return ResponseInterface
     */
    public function showAction(Config $config): ResponseInterface
    {
        $this->view->assign('config', $config);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return ResponseInterface
     */
    public function newAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'rootPageId' => $this->request->getAttribute('site')->getRootpageId(),
            'ucServiceList' => DeAndEncodeService::decodeJsonString(
                FileService::getFileContent(
                    TyposcriptReaderService::getModuleSettings('tx_usercentrics_configurator')['serviceDataJson']
                )
            )
        ]);
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param Config $newConfig
     */
    public function createAction(Config $newConfig)
    {
        $this->configRepository->add(
            UsercentricsConfigurationService::addConfiguration(
                $newConfig,
                GeneralUtility::_POST(),
                $this->request->getAttribute('site')->getRootpageId()
            )
        );
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param Config $config
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("config")
     * @return ResponseInterface
     */
    public function editAction(Config $config): ResponseInterface
    {
        $this->view->assignMultiple([
            'config' => $config,
            'ucServiceList' => DeAndEncodeService::decodeJsonString(
                FileService::getFileContent(
                    TyposcriptReaderService::getModuleSettings('tx_usercentrics_configurator')['serviceDataJson']
                )
            )
        ]);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param Config $config
     */
    public function updateAction(Config $config)
    {
        if(GeneralUtility::_GET('activate'))
            $config->setActivate((bool)!$config->getActivate());

        if (GeneralUtility::_GET('footerLink'))
            $config->setUseFooterLink((bool)!$config->getUseFooterLink());

        if (GeneralUtility::_GET('useGtm'))
            $config->setUseGtm((bool)!$config->getUseGtm());

        $this->configRepository->update(
            UsercentricsConfigurationService::addConfiguration(
                $config,
                GeneralUtility::_POST(),
                $this->request->getAttribute('site')->getRootpageId()
            )
        );
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param Config $config
     */
    public function deleteAction(Config $config)
    {
        $this->configRepository->remove($config);
        $this->redirect('list');
    }
}
