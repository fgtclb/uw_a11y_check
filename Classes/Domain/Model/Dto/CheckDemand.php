<?php

namespace UniWue\UwA11yCheck\Domain\Model\Dto;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use UniWue\UwA11yCheck\Check\Preset;

/**
 * Class CheckDemand
 */
class CheckDemand extends AbstractEntity
{
    protected string $analyze = '';

    protected ?Preset $preset = null;

    protected int $level = 0;

    public function getAnalyze(): string
    {
        return $this->analyze;
    }

    public function setAnalyze(string $analyze): void
    {
        $this->analyze = $analyze;
    }

    public function getPreset(): ?Preset
    {
        return $this->preset;
    }

    public function setPreset(?Preset $preset): void
    {
        $this->preset = $preset;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return array{analyze: string, preset: string, level: int}
     */
    public function toArray(): array
    {
        return [
            'analyze' => $this->getAnalyze(),
            'preset' => $this->preset->getId() ?? '',
            'level' => $this->getLevel(),
        ];
    }
}
