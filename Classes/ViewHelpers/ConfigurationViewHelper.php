<?php

declare(strict_types=1);

namespace PowerCaptcha\Typo3\ViewHelpers;

use PowerCaptcha\Typo3\Configuration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class ConfigurationViewHelper extends AbstractViewHelper {
	use CompileWithRenderStatic;

	public static function renderStatic(
        array $arguments, 
        \Closure $renderChildrenClosure, 
        RenderingContextInterface $renderingContext
    ) {
		$configuration = new Configuration();

		// pass configuration variables to view
		return [
            'enabled' => $configuration->isEnabled(),
            'clientUid' => $configuration->getClientUid(),
            'lang' => self::getLang(),
			'apiKey' => $configuration->getApiKey(),
            'endpointUrl' => $configuration->getTokenRequestUrl(),
			'javascriptUrl' => $configuration->getJavascriptUrl(),
			'debugMode' => $configuration->getDebugMode(),
		];
    }

    protected static function getLang() : string {
        $language = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
        if(!$language) {
            return '';
        }
        if ((new Typo3Version())->getMajorVersion() >= 12) {
            return $language->getLocale()->getLanguageCode();
        }
        return $language->getTwoLetterIsoCode();
    }
}