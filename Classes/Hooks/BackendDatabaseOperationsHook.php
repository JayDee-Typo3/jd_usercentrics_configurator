<?php


namespace JD\JdUsercentricsConfigurator\Hooks;

use JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository;
use JD\JdUsercentricsConfigurator\Services\HTMLParseService;
use JD\JdUsercentricsConfigurator\Services\PageService;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class BackendDatabaseOperationsHook
 *
 * @package JD\JdUsercentricsConfigurator\Hooks
 * @author Johannes Delesky, Developer
 */
class BackendDatabaseOperationsHook
{
    /**
     * Allowed actions to hook.
     *
     * @var array|string[]
     */
    private array $hookOnActions = ['new', 'update'];

    /**
     * Hook the save process of typo3 and change the iframe src attribute for youtube and vimeo.
     *
     * @param $command
     * @param $table
     * @param $id
     * @param $value
     * @param DataHandler $pObj
     */
    public function processDatamap_afterDatabaseOperations($command, $table, $id, $value, DataHandler &$pObj) {
        if ($table === 'tt_content' && in_array($command, $this->hookOnActions) && $pObj->datamap['tt_content'][$id]['CType'] === 'html') {
            $pageId = $command === 'new' ? $value['pid'] : $pObj->checkValue_currentRecord['pid'];
            $usercentricsConfig = GeneralUtility::makeInstance(ConfigRepository::class)
                ->getActiveConfigurationByRootPageId(PageService::getRootPageId($pageId));
            if ($usercentricsConfig['activate'] === 1 && !empty($value['bodytext'])) {
                $data['tt_content'][$id] = [
                    'pid' => $pageId,
                    'bodytext' => HTMLParseService::checkHtmlElementContent($value['bodytext'])
                ];
                $pObj->start($data, [$command]);
                $pObj->process_datamap();
            }
        }
    }
}