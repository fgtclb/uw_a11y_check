<?php

declare(strict_types = 1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->import(__DIR__ . '/../../rector/rector.php');

    $rectorBasePath = __DIR__;

    // Optional non-php file functionalities:
    // @see https://github.com/sabbelasichon/typo3-rector/blob/main/docs/beyond_php_file_processors.md

    // Rewrite your extbase persistence class mapping from typoscript into php according to official docs.
    // This processor will create a summarized file with all the typoscript rewrites combined into a single file.

};
