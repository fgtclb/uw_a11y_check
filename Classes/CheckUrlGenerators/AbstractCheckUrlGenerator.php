<?php

namespace UniWue\UwA11yCheck\CheckUrlGenerators;

use UniWue\UwA11yCheck\Utility\Exception\MissingConfigurationException;

/**
 * Class AbstractCheckUrlGenerator
 */
abstract class AbstractCheckUrlGenerator
{
    /**
     * @var array
     */
    protected $requiredConfiguration = [];

    protected string $tableName = '';

    protected string $editRecordTable = '';

    /**
     * AbstractCheckUrlGenerator constructor.
     */
    public function __construct(array $configuration)
    {
        $this->checkRequiredConfiguration($configuration);
    }

    public function getCheckUrl(int $pageUid): string
    {
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getEditRecordTable(): string
    {
        return $this->editRecordTable;
    }

    /**
     * Checks, if all required configuration settings are available and if not, throws an exception
     */
    protected function checkRequiredConfiguration(array $configuration)
    {
        foreach ($this->requiredConfiguration as $configurationKey) {
            if (!isset($configuration[$configurationKey])) {
                throw new MissingConfigurationException(
                    'Missing configuration key "' . $configurationKey . '" in ' . self::class,
                    1_573_565_583_355
                );
            }
        }
    }
}
