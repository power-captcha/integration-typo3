<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'POWER CAPTCHA TYPO3 Integration',
    'description' => 'POWER CAPTCHA protects your TYPO3 forms (EXT:form and EXT:powermail) against bots and unauthorized persons. GDPR compliant!',
    'category' => 'plugin',
    'author' => 'POWER CAPTCHA',
    'version' => '0.1',
    'state' => 'beta',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'PowerCaptcha\\Typo3\\' => 'Classes/',
        ],
    ],
];
