<?php

call_user_func(
    static function () {
        $lll = 'LLL:EXT:power_captcha/Resources/Private/Language/locallang.xlf:';

        // API Key
        $GLOBALS['SiteConfiguration']['site']['columns']['power_captcha_api_key'] = [
            'label' => $lll . 'site.configuration.api_key',
            'description' => $lll . 'site.configuration.api_key.description',
            'config' => [
                'type' => 'input',
                'placeholder' => '',
            ],
        ];

        // Secret Key
        $GLOBALS['SiteConfiguration']['site']['columns']['power_captcha_secret_key'] = [
            'label' => $lll . 'site.configuration.secret_key',
            'description' => $lll . 'site.configuration.secret_key.description',
            'config' => [
                'type' => 'input',
                'placeholder' => '',
            ],
        ];

        // Endpoint base URL
        $GLOBALS['SiteConfiguration']['site']['columns']['power_captcha_endpoint_base_url'] = [
            'label' => $lll . 'site.configuration.endpoint_base_url',
            'description' => $lll . 'site.configuration.endpoint_base_url.description',
            'config' => [
                'type' => 'input',
                'placeholder' => '',
                'eval' => 'trim'
            ],
        ];
        
        // JavaScript base URL
        $GLOBALS['SiteConfiguration']['site']['columns']['power_captcha_javascript_base_url'] = [
            'label' => $lll . 'site.configuration.javascript_base_url',
            'description' => $lll . 'site.configuration.javascript_base_url.description',
            'config' => [
                'type' => 'input',
                'placeholder' => '',
                'eval' => 'trim'
            ],
        ];

        // add all to showitem
        $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= 
            ',--div--;' 
            . $lll . 'site.configuration.tab,' 
            . 'power_captcha_api_key,'
            . 'power_captcha_secret_key,'
            . 'power_captcha_endpoint_base_url,'
            . 'power_captcha_javascript_base_url,'
        ;

    }
);