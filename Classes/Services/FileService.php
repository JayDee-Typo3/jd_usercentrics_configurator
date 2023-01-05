<?php
namespace JD\JdUsercentricsConfigurator\Services;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FileService
 *
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
class FileService
{

    /**
     * Get the file content.
     *
     * @param string $filePath
     *
     * @return string
     */
    public static function getFileContent(string $filePath): string
    {
        $absolutePath = GeneralUtility::getFileAbsFileName($filePath);
        if (file_exists($absolutePath))
            return file_get_contents($absolutePath);

        return '';
    }
}