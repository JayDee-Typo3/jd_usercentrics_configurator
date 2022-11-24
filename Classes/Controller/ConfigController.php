<?php

declare(strict_types=1);

namespace JD\JdUsercentricsConfigurator\Controller;


/**
 * This file is part of the "Usercentrics Configurator" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */

/**
 * ConfigController
 */
class ConfigController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * configRepository
     *
     * @var \JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository
     */
    protected $configRepository = null;

    /**
     * @param \JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository $configRepository
     */
    public function injectConfigRepository(\JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $configs = $this->configRepository->findAll();
        $this->view->assign('configs', $configs);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \JD\JdUsercentricsConfigurator\Domain\Model\Config $config
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\JD\JdUsercentricsConfigurator\Domain\Model\Config $config): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('config', $config);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \JD\JdUsercentricsConfigurator\Domain\Model\Config $newConfig
     */
    public function createAction(\JD\JdUsercentricsConfigurator\Domain\Model\Config $newConfig)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->configRepository->add($newConfig);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \JD\JdUsercentricsConfigurator\Domain\Model\Config $config
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("config")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\JD\JdUsercentricsConfigurator\Domain\Model\Config $config): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('config', $config);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \JD\JdUsercentricsConfigurator\Domain\Model\Config $config
     */
    public function updateAction(\JD\JdUsercentricsConfigurator\Domain\Model\Config $config)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->configRepository->update($config);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \JD\JdUsercentricsConfigurator\Domain\Model\Config $config
     */
    public function deleteAction(\JD\JdUsercentricsConfigurator\Domain\Model\Config $config)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->configRepository->remove($config);
        $this->redirect('list');
    }
}
