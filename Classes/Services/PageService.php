<?php


namespace JD\JdUsercentricsConfigurator\Services;


use TYPO3\CMS\Core\Site\Entity\Site;

class PageService
{

    /**
     * checks if the selected page is a root page.
     *
     * @param Site $site
     * @param array $queryParameter
     *
     * @return bool
     */
    public static function isSelectedPageRootPage(Site $site, array $queryParameter): bool
    {
        return $site->getRootPageId() === intval($queryParameter['id']);
    }
}