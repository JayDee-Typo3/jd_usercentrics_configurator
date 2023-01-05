<?php


namespace JD\JdUsercentricsConfigurator\Services;


use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

/**
 * Class PageService
 *
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
class PageService
{
    /**
     * RootlineUtility
     *
     * @var RootlineUtility $rootlineUtility
     */
    protected static RootlineUtility $rootlineUtility;

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

    /**
     * Determine the id of the root page.
     *
     * @param int|NULL $pageId
     *
     * @return int
     */
    public static function getRootPageId($pageId = NULL): int
    {
        if (!empty($GLOBALS['TSFE']))
            return $GLOBALS['TSFE']->site->getRootPageId();

        if (empty(self::$rootlineUtility))
            self::initService($pageId !== NULL ? $pageId : GeneralUtility::_GET('id'));

        $rootLines = self::$rootlineUtility->get();

        if (!empty($rootLines))
            foreach ($rootLines as $rootLine)
                if (!empty($rootLine['is_siteroot']) && $rootLine['is_siteroot'])
                    return $rootLine['uid'];

        return 0;
    }

    /**
     * Check if the given id is a root page.
     *
     * @param int $pageId
     *
     * @return bool
     */
    public static function isPageRootPage(int $pageId): bool
    {
        return self::getRootPageId() === $pageId;
    }

    /**
     * Initialize this service
     *
     * @param int $pageId
     */
    private static function initService(int $pageId)
    {
        self::$rootlineUtility = GeneralUtility::makeInstance(RootlineUtility::class, $pageId);
    }
}