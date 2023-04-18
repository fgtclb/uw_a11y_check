<?php

namespace UniWue\UwA11yCheck\Check;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use UniWue\UwA11yCheck\Check\Result\Node;

/**
 * Class Result
 */
class Result
{
    protected ?int $status = null;

    protected string $description = '';

    protected string $help = '';

    protected string $helpUrl = '';

    protected ?int $impact = null;

    /**
     * @var array
     */
    protected $nodes = [];

    protected string $testId = '';

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getHelp(): string
    {
        return $this->help;
    }

    public function setHelp(string $help): void
    {
        $this->help = $help;
    }

    public function getHelpUrl(): string
    {
        return $this->helpUrl;
    }

    public function setHelpUrl(string $helpUrl): void
    {
        $this->helpUrl = $helpUrl;
    }

    public function getImpact(): ?int
    {
        return $this->impact;
    }

    public function setImpact(?int $impact): void
    {
        $this->impact = $impact;
    }

    /**
     * @return mixed[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    public function addNode(Node $node): void
    {
        $this->nodes[] = $node;
    }

    /**
     * @param mixed[] $nodes
     */
    public function setNodes(array $nodes): void
    {
        $this->nodes = $nodes;
    }

    public function getTestId(): string
    {
        return $this->testId;
    }

    public function setTestId(string $testId): void
    {
        $this->testId = $testId;
    }

    public function getHasErrors(): bool
    {
        return $this->nodes !== [];
    }

    /**
     * Returns the state of the result used in Fluid
     */
    public function getState(): int
    {
        return match ($this->status) {
            0 => 0,
            1 => $this->getImpact() >= 3 ? 2 : 1,
            2 => -1,
            default => 1,
        };
    }

    /**
     * Returns the title for the check used in Fluid
     */
    public function getTitle(): ?string
    {
        $status = $this->status ?? 1;
        return LocalizationUtility::translate(
            'LLL:EXT:uw_a11y_check/Resources/Private/Language/locallang.xlf:result.title.' . $status
        );
    }
}
