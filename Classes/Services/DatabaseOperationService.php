<?php


namespace JD\JdUsercentricsConfigurator\Services;


use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class DatabaseOperationService
 *
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
class DatabaseOperationService
{
    /**
     * QueryBuilder
     *
     * @var QueryBuilder $queryBuilder
     */
    protected static QueryBuilder $queryBuilder;

    /**
     * Select data from given table.
     *
     * @param string $table
     * @param array $andWhere
     * @param array|string[] $fields
     *
     * @return array
     *
     * @throws DBALException
     *
     * @throws Exception
     */
    public static function getDataset(string $table, array $andWhere = [], array $fields = ['*']): array
    {
        if (empty(self::$queryBuilder))
            self::initService($table);

        self::$queryBuilder->select(...$fields)->from($table);

        if(!empty($andWhere)) {
            $where = [];
            foreach ($andWhere as $field => $data) {
                $func = $data['func'];
                $where[] = self::$queryBuilder->expr()->$func(
                    $field,
                    self::$queryBuilder->createNamedParameter($data['value'])
                );
            }
            self::$queryBuilder->andWhere(...$where);
        }


        return self::$queryBuilder->execute()->fetchAssociative();
    }

    /**
     * Initialize this service class.
     *
     * @param string $table
     *
     * @return void
     */
    private static function initService(string $table): void
    {
        self::$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
    }
}