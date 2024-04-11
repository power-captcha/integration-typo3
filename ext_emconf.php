<?php

$EM_CONF[$_EXTKEY] = [
    // 'title' => 'power_captcha',
    'title' => 'POWER CAPTCHA for TYPO3', // todo which title?
    'description' => 'POWER CAPTCHA protects your TYPO3 website against bots and unauthorized persons. GDPR compliant!',
    // 'category' => 'plugin', // TODO not needed?
    // 'author' => 'David Bascom', // TODO not needed?
    // 'author_email' => 'deine@email.de', // TODO not needed?
    // 'state' => 'stable', // TODO not needed?
    // 'internal' => '', // TODO not needed?
    // 'uploadfolder' => '1', // TODO not needed?
    // 'createDirs' => '', // TODO not needed?
    // 'clearCacheOnLoad' => 0, // TODO not needed?
    // 'version' => '0.1', // TODO not needed?
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
        ],
        // 'conflicts' => [], // TODO not needed?
        // 'suggests' => [], // TODO not needed?
    ],
    'autoload' => [
        'psr-4' => [
            'PowerCaptcha\\Typo3\\' => 'Classes/',
        ],
    ],
];
