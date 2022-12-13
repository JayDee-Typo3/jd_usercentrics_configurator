<?php


namespace JD\JdUsercentricsConfigurator\ViewHelper\Backend;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class IsServiceSelectedViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('selectedServices', 'string', 'The list of selected Services', TRUE);
        $this->registerArgument('crServiceId', 'string', 'The service to check if selected', TRUE);
    }

    public function render()
    {
        $selectedServiceArray = GeneralUtility::trimExplode(',', $this->arguments['selectedServices']);

        return in_array("'" . $this->arguments['crServiceId'] . "'", $selectedServiceArray);
    }
}