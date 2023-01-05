<?php


namespace JD\JdUsercentricsConfigurator\Services;


use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class ErrorService
 *
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
class ErrorService
{

    /**
     * Returns an error array with a headline and body text.
     *
     * @return array
     */
    public static function addNotARootpageError(): array
    {
        return [
            'headline' => LocalizationUtility::translate('be.error.not.a.rootpage.headline', 'JdUsercentricsConfigurator'),
            'bodytext' => LocalizationUtility::translate('be.error.not.a.rootpage.headline', 'JdUsercentricsConfigurator')
        ];
    }
}