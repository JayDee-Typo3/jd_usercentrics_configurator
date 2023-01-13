<?php

namespace JD\JdUsercentricsConfigurator\DataHandling;

use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use JD\JdUsercentricsConfigurator\Services\DatabaseOperationService;
use JD\JdUsercentricsConfigurator\Services\HTMLParseService;
use JD\JdUsercentricsConfigurator\Services\PageService;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class JdDataHandler
 *
 * This class override the TYPO3 DataHandler and checks the content of the HTML content element
 * to change the bodytext to get a usercentrics conform vimeo and youtube integration.
 *
 * @package JD\JdUsercentricsConfigurator\DataHandling
 * @author Johannes Delesky, Developer
 */
class JdDataHandler extends DataHandler
{

    /**
     * {@inheritDoc}
     */
    public function insertDB($table, $id, $fieldArray, $newVersion = false, $suggestedUid = 0, $dontSetNewIdIndex = false)
    {
        $this->changeHtmlBodyText($fieldArray, $fieldArray['CType'], $fieldArray['pid']);

        parent::insertDB($table, $id, $fieldArray, $newVersion, $suggestedUid, $dontSetNewIdIndex);
    }

    /**
     * {@inheritDoc}
     */
    public function updateDB($table, $id, $fieldArray)
    {
        $contentElement = DatabaseOperationService::getDataset(
            'tt_content',
            ['uid' => ['func' => 'eq', 'value' => $id]]
        );

        $this->changeHtmlBodyText($fieldArray, $contentElement['CType'], $contentElement['pid']);

        parent::updateDB($table, $id, $fieldArray);
    }

    /**
     * @param array $fieldArray
     *
     * @return void
     */
    private function changeHtmlBodyText(array &$fieldArray, string $ctype, int $pid): void
    {
        if ($ctype === 'html' && !empty($fieldArray['bodytext'])) {
            $usercentricsConfig = GeneralUtility::makeInstance(ConfigRepository::class)
                ->getActiveConfigurationByRootPageId(PageService::getRootPageId($pid));
            if ($usercentricsConfig['activate'] === 1)
                $fieldArray['bodytext'] = HTMLParseService::checkHtmlElementContent($fieldArray['bodytext']);

        }
    }
}