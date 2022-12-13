<?php

declare(strict_types=1);

namespace JD\JdUsercentricsConfigurator\Domain\Repository;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Exception;
use PDO;
use JD\JdUsercentricsConfigurator\Services\Typo3DbQueryParseService;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * This file is part of the "Usercentrics Configurator" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */

/**
 * Class ConfigRepository
 * @package JD\JdUsercentricsConfigurator\Domain\Repository
 * @author Johannes Delesky, Developer
 */
class ConfigRepository extends Repository
{
    /**
     * @param int $rootPageId
     *
     * @return array|false
     *
     * @throws DBALException
     * @throws Exception
     */
    public function getActiveConfigurationByRootPageId(int $rootPageId)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->andWhere(
            $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($rootPageId, PDO::PARAM_INT))
        );

        return $queryBuilder->execute()->fetchAssociative();
    }

    /**
     * Converts the QueryInterface to a QueryBuilder and returns it.
     *
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return Typo3DbQueryParseService::parseTypo3DbQueryToDoctrine(
            $this->overwriteTypo3QuerySettings($this->createQuery(), TRUE, FALSE)
        );
    }

    /**
     * Override the query settings of the QueryInterface.
     *
     * @param QueryInterface $query
     * @param bool $ignoreEnableFields
     * @param bool $respectStoragePage
     *
     * @return QueryInterface
     */
    private function overwriteTypo3QuerySettings(QueryInterface $query, bool $ignoreEnableFields, bool $respectStoragePage): QueryInterface
    {
        $settings = $query->getQuerySettings();
        $settings->setIgnoreEnableFields($ignoreEnableFields);
        $settings->setRespectStoragePage($respectStoragePage);
        $query->getQuerySettings($settings);

        return $query;
    }
}
