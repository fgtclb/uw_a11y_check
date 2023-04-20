<?php

namespace UniWue\UwA11yCheck\Check;

use UniWue\UwA11yCheck\Analyzers\AbstractAnalyzer;
use UniWue\UwA11yCheck\CheckUrlGenerators\AbstractCheckUrlGenerator;

/**
 * Class Preset
 */
class Preset
{
    protected string $description = '';

    /**
     * Preset constructor.
     */
    public function __construct(protected string $id, protected string $name, protected AbstractAnalyzer $analyzer, protected AbstractCheckUrlGenerator $checkUrlGenerator, protected TestSuite $testSuite, array $configuration)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCheckTableName(): string
    {
        return $this->checkUrlGenerator->getTableName();
    }

    public function getEditRecordTableName(): string
    {
        return $this->checkUrlGenerator->getEditRecordTable();
    }

    /**
     * Returns the check URL
     */
    public function getCheckUrl(int $id): string
    {
        return $this->checkUrlGenerator->getCheckUrl($id);
    }

    public function getTestSuite(): TestSuite
    {
        return $this->testSuite;
    }

    /**
     * Executes the testSuite configured in the preset by the given page UID and recursive levels
     *
     * @return ResultSet[]
     */
    public function executeTestSuiteByPageUid(int $pageUid, int $levels): array
    {
        $result = [];
        $this->analyzer->initializePageUids($pageUid, $levels);

        foreach ($this->analyzer->getCheckRecordUids($this) as $recordUid) {
            $result[] = $this->analyzer->runTests($this, $recordUid);
        }

        return $result;
    }

    /**
     * Executes the testSuite configured in the preset by the given array of record UIDs
     *
     * @return ResultSet[]
     */
    public function executeTestSuiteByRecordUids(array $recordUids): array
    {
        $result = [];

        foreach ($recordUids as $recordUid) {
            $result[] = $this->analyzer->runTests($this, $recordUid);
        }

        return $result;
    }
}
