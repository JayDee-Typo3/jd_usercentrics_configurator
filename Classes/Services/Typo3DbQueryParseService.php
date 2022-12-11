<?php

namespace JD\JdUsercentricsConfigurator\Services;

use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class Typo3DbQueryParseService
{
    /**
     * Converts given query into a doctrine queryBuilder
     *
     * @param QueryInterface $query
     * @return QueryBuilder
     */
    public static function parseTypo3DbQueryToDoctrine(QueryInterface $query): QueryBuilder
    {
        return GeneralUtility::makeInstance(Typo3DbQueryParser::class)
            ->convertQueryToDoctrineQueryBuilder($query);
    }
}