<?php

namespace JD\JdUsercentricsConfigurator\ViewHelper\Backend;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class IsServiceSelectedViewHelper
 *
 * This ViewHelper is used to check if a Service is selected in the backend Module.
 *
 * @package JD\JdUsercentricsConfigurator\ViewHelper\Backend
 * @author Johannes Delesky, Developer
 */
class IsServiceSelectedViewHelper extends AbstractViewHelper
{
    /**
     * {@inheritDoc}
     */
    public function initializeArguments()
    {
        $this->registerArgument('selectedServices', 'string', 'The list of selected Services', TRUE);
        $this->registerArgument('crServiceId', 'string', 'The service to check if selected', TRUE);
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $selectedServiceArray = GeneralUtility::trimExplode(',', $this->arguments['selectedServices']);

        return in_array("'" . $this->arguments['crServiceId'] . "'", $selectedServiceArray);
    }
}