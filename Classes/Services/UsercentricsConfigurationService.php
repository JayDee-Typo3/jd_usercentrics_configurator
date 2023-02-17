<?php


namespace JD\JdUsercentricsConfigurator\Services;


use JD\JdUsercentricsConfigurator\Domain\Model\Config;
use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class UsercentricsConfigurationService
 *
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
class UsercentricsConfigurationService
{
    /**
     * @param Config $config
     * @param array $data
     * @param int $rootPageId
     * @return Config
     */
    public static function addConfiguration(Config $config, array $data, int $rootPageId): Config
    {
        if (empty($data))
            return $config;

        if(empty($config->getPid()))
            $config->setPid($rootPageId);

        if ($data['blockOnly'] && is_array($data['blockOnly']))
            $config->setBlockOnly("'" . implode("','", $data['blockOnly']) . "'");

        if (empty($data['blockOnly']))
            $config->setBlockOnly('');

        return $config;
    }

    /**
     * @param int $rootPageId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public static function getUsercentricsConfigForRootPage(int $rootPageId): array
    {
        /** @var ConfigRepository $repository */
        $repository = GeneralUtility::makeInstance(ConfigRepository::class);

        return $repository->getActiveConfigurationByRootPageId($rootPageId);
    }
}