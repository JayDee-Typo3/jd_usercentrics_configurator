<?php


namespace JD\JdUsercentricsConfigurator\Services;


use JD\JdUsercentricsConfigurator\Domain\Model\Config;
use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UsercentricsConfigurationService
{

    public static function addConfiguration(Config $config, array $data, int $rootPageId): Config
    {
        if (empty($data))
            return $config;

        if(empty($config->getPid()))
            $config->setPid($rootPageId);

        if ($data['blockOnly'] && is_array($data['blockOnly']))
            $config->setBlockOnly("'" . implode("','", $data['blockOnly']) . "'");

        return $config;
    }

    public static function getUsercentricsConfigForRootPage(int $rootPageId): array
    {
        /** @var ConfigRepository $repository */
        $repository = GeneralUtility::makeInstance(ConfigRepository::class);

        return $repository->getActiveConfigurationByRootPageId($rootPageId);
    }
}