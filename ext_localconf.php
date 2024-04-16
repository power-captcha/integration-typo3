<?php 
// Register icon
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'power-captcha-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:power_captcha/Resources/Public/Icons/power-captcha-icon.svg']
);

// EXT:form integration
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
# Frontend    
plugin.tx_form.settings.yamlConfigurations {
    1712745318785 = EXT:power_captcha/Configuration/Yaml/FormSetup.yaml
}
# Backend
module.tx_form.settings.yamlConfigurations {
    1712745318785 = EXT:power_captcha/Configuration/Yaml/FormSetup.yaml
}
');
}

// EXT:powermail integration
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('powermail')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '@import "EXT:power_captcha/Configuration/TypoScript/Powermail/setup.typoscript"'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:power_captcha/Configuration/PageTsConfig/powermail.typoscript"'
    );
}



// TODO logging (see https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Logging/Configuration/Index.html)