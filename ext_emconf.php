<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'a11y check',
    'description' => 'Configurable a11y check for tt_content and extension records',
    'category' => 'fe',
    'author' => 'Torben Hansen on behalf of Universität Würzburg',
    'author_email' => 'torben@derhansen.com',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '3.1.2',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'php' => '8.0.0-8.2.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
