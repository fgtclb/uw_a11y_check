<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use UniWue\UwA11yCheck\Controller\A11yCheckController;
defined('TYPO3_MODE') || die();

call_user_func(function (): void {
    if (TYPO3_MODE === 'BE') {
        /**
         * Register Administration Module
         */
        ExtensionUtility::registerModule(
            'UwA11yCheck',
            'web',
            'tx_uwa11ycheck_m1',
            '',
            [
                A11yCheckController::class => 'index,check,results,acknowledgeResult',
            ],
            [
                'access' => 'user,group',
                'icon' => 'EXT:uw_a11y_check/Resources/Public/Icons/Extension.svg',
                'labels' => 'LLL:EXT:uw_a11y_check/Resources/Private/Language/locallang_modm1.xlf',
            ]
        );
    }
});
