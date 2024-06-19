<?php

declare(strict_types=1);

namespace PowerCaptcha\Typo3;

use phpDocumentor\Reflection\Types\Integer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Site\Entity\NullSite;
use TYPO3\CMS\Core\Site\Entity\Site;

class Configuration
{
    public const TOKEN_FIELD_NAME = 'pc-token';

    private const DEFAULT_ENDPOINT_BASE_URL = 'https://api.power-captcha.com';
    private const DEFAULT_JAVASCRIPT_BASE_URL = 'https://cdn.power-captcha.com';
    
    private const API_VERSION = 'v1';
    private const JS_VERSION = '1.2.2';

    protected string $apiKey = '';
    protected string $secretKey = '';
    protected string $checkMode = '';
    protected string $endpointBaseUrl = '';
    protected string $javascriptBaseUrl = '';
    protected string $debugMode = 'false';

    public function __construct(Site $site = null) {
        if ($site === null) {
            $site = $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
        }
        if ($site === null || $site instanceof NullSite) {
            return;
        }

        $siteConfiguration = $site->getConfiguration();
        $this->apiKey = trim($siteConfiguration['power_captcha_api_key'] ?? '');
        $this->secretKey = trim($siteConfiguration['power_captcha_secret_key'] ?? '');
        $this->checkMode = $siteConfiguration['power_captcha_check_mode'] ?? '';
        $this->endpointBaseUrl = trim($siteConfiguration['power_captcha_endpoint_base_url'] ?? '');
        $this->javascriptBaseUrl = trim($siteConfiguration['power_captcha_javascript_base_url'] ?? '');
        $this->debugMode = ($siteConfiguration['power_captcha_debug_mode'] ?? false) ? 'true' : 'false';
    }

    public function getClientUid() {
        return hash('sha256', GeneralUtility::getIndpEnv('REMOTE_ADDR'));
    }

    public function isEnabled() : bool {
        return $this->isConfigured();
    }

    public function isConfigured() : bool {
        return $this->apiKey !== '' && $this->secretKey !== '';
    }

    public function getApiKey() : string {
        return $this->apiKey;
    }

    public function getSecretKey() : string {
        return $this->secretKey;
    }

    public function getCheckMode() : string {
        return in_array($this->checkMode, ['auto', 'hidden', 'manu']) ? $this->checkMode : 'auto';
    }

    private function getEndpointBaseUrl() : string {
        if(empty($this->endpointBaseUrl)) {
            return self::DEFAULT_ENDPOINT_BASE_URL;
        }
        // TODO: untrainling last slash from custom url
        return $this->endpointBaseUrl;
    }

    public function getTokenRequestUrl() : string {
        return $this->getEndpointBaseUrl() . '/pc/'. self::API_VERSION;
    }

    public function getTokenVerificationUrl() : string {
        return $this->getEndpointBaseUrl() . '/pcu/' . self::API_VERSION . '/verify'; 
    }

    private function getJavascriptBaseUrl() : string {
        if(empty($this->javascriptBaseUrl)) {
            return self::DEFAULT_JAVASCRIPT_BASE_URL;
        }
        // TODO: untrainling last slash from custom url
        return $this->javascriptBaseUrl;
    }

    public function getJavascriptUrl() : string {
        return $this->getJavascriptBaseUrl() . '/' . self::API_VERSION . '/power-captcha-' . self::JS_VERSION . '.min.js';
    }

    public function getDebugMode() : string {
        return $this->debugMode;
    }
}