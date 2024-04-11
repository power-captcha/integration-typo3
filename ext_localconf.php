<?php 
// Registriert das Icon
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'power-captcha-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:power_captcha/Resources/Public/Icons/power-captcha-icon.svg']
);

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
# Einstellungen für das Frontend
plugin.tx_form.settings.yamlConfigurations {
    1712745318785 = EXT:power_captcha/Configuration/Yaml/FormSetup.yaml
}
# Einstellungen für das Backend
module.tx_form.settings.yamlConfigurations {
    1712745318785 = EXT:power_captcha/Configuration/Yaml/FormSetup.yaml
}
');
}


// TODO logging