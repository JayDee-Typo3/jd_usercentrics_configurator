<?php


namespace JD\JdUsercentricsConfigurator\Services;


use TYPO3\CMS\Core\Site\Entity\Site;

/**
 * Class PageService
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
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