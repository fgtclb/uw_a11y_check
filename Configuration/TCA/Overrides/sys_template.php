<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
defined('TYPO3') || die();

/**
 * Default TypoScript
 */
ExtensionManagementUtility::addStaticFile(
    'uw_a11y_check',
    'Configuration/TypoScript',
    'TYPO3 Accessibility Check'
);
