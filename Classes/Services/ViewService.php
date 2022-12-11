<?php


namespace JD\JdUsercentricsConfigurator\Services;


use JD\JdUsercentricsConfigurator\Traits\BackendViewTrait;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

class ViewService
{
    use BackendViewTrait;

    public static function extendViewByBackendPaths(ViewInterface &$view)
    {
        self::prependPath('layoutRootPaths', $view->getTemplatePaths()->getLayoutRootPaths()[0]);
        self::prependPath('templateRootPaths', $view->getTemplatePaths()->getTemplateRootPaths()[0]);
        self::prependPath('partialRootPaths', $view->getTemplatePaths()->getPartialRootPaths()[0]);
        $view->setLayoutRootPaths(self::$backViewPaths['layoutRootPaths']);
        $view->setTemplateRootPaths(self::$backViewPaths['templateRootPaths']);
        $view->setPartialRootPaths(self::$backViewPaths['partialRootPaths']);
    }
}