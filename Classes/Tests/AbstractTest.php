<?php

namespace UniWue\UwA11yCheck\Tests;

use UniWue\UwA11yCheck\Check\Result\Status;
use DOMElement;
use TYPO3\CMS\Core\Localization\LanguageService;
use UniWue\UwA11yCheck\Check\Result;
use UniWue\UwA11yCheck\Utility\Tests\ElementUtility;

/**
 * Class AbstractTest
 */
abstract class AbstractTest implements TestInterface
{
    protected $id = '';

    protected $description = '';

    protected $help = '';

    protected $helpUrl = '';

    protected $impact = 0;

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return htmlspecialchars($this->description);
    }

    public function getHelp(): string
    {
        return $this->help;
    }

    public function getHelpUrl(): string
    {
        return $this->helpUrl;
    }

    public function getImpact(): int
    {
        return $this->impact;
    }

    /**
     * AbstractTest constructor.
     *
     * @param mixed[] $configuration
     */
    public function __construct(protected array $configuration = [])
    {
        if ($this->description === '') {
            $this->description = $this->translateLabel($this->id . '.description');
        }
        if ($this->help === '') {
            $this->help = $this->translateLabel($this->id . '.help');
        }
    }

    public function initResultWithMetaDataFromTest(): Result
    {
        $result = new Result();
        $result->setTestId($this->getId());
        $result->setDescription($this->getDescription());
        $result->setHelp($this->help);
        $result->setHelpUrl($this->helpUrl);
        $result->setImpact($this->impact);
        $result->setStatus(Status::INAPPLICABLE);

        return $result;
    }

    /**
     * Returns the element UID in the node. If no UID could be determined, the fallbackElementUid is returned
     */
    public function getElementUid(DOMElement $node, int $fallbackElementUid): int
    {
        $elementUid = ElementUtility::determineElementUid($node);
        if ($elementUid === 0) {
            $elementUid = $fallbackElementUid;
        }
        return $elementUid;
    }

    protected function translateLabel(string $label): string
    {
        $langId = 'LLL:EXT:uw_a11y_check/Resources/Private/Language/locallang.xlf:';
        return $this->getLanguageService()->sL($langId . $label);
    }

    /**
     * Returns LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
