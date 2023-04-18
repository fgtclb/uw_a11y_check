<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
defined('TYPO3_MODE') || die();

/**
 * Plugins
 */
ExtensionUtility::registerPlugin(
    'uw_a11y_check',
    'Pi1',
    'Display content elements for a11y check'
);

/**
 * Remove unused fields
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['uwa11ycheck_pi1'] =
    'layout,recursive,select_key,pages';
