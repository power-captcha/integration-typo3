<?php

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('powermail')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'power_captcha',
        'Configuration/TypoScript/Powermail',
        'POWER CAPTCHA - EXT:powermail'
    );
}