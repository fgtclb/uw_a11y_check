<?php

namespace UniWue\UwA11yCheck\Tests\Internal;

use UniWue\UwA11yCheck\Check\Result\Impact;
use DOMElement;
use UniWue\UwA11yCheck\Check\Result\Node;
use UniWue\UwA11yCheck\Check\Result\Status;
use Symfony\Component\DomCrawler\Crawler;
use UniWue\UwA11yCheck\Check\Result;
use UniWue\UwA11yCheck\Tests\AbstractTest;
use UniWue\UwA11yCheck\Utility\Tests\ElementUtility;
use UniWue\UwA11yCheck\Utility\Tests\HeaderUtility;

/**
 * Class HeadingOrderTest
 */
class HeadingOrderTest extends AbstractTest
{
    /**
     * @var string
     */
    protected $id = 'heading-order';

    /**
     * @var string
     */
    protected $helpUrl = 'https://dequeuniversity.com/rules/axe/3.4/heading-order';

    /**
     * @var int
     */
    protected $impact = Impact::MODERATE;

    /**
     * If set, the test only checks elements in the given array of colPos ids
     *
     * @var array
     */
    protected $limitToColPos = [];

    /**
     * HeadingOrderTest constructor.
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        parent::__construct($configuration);

        $this->limitToColPos = $configuration['limitToColPos'] ?? [];
    }

    /**
     * Runs the test
     */
    public function run(string $html, int $fallbackElementUid): Result
    {
        $result = $this->initResultWithMetaDataFromTest();

        $crawler = new Crawler($html);
        $headers = $crawler->filter('h1,h2,h3,h4,h5,h6');

        $previousHeader = null;

        /** @var DOMElement $header */
        foreach ($headers as $header) {
            // Always skip the first header
            if ($previousHeader === null) {
                $previousHeader = $header;
                continue;
            }

            $colPos = ElementUtility::determineElementColPos($header);
            $colPosExcluded = false;
            if (!empty($this->limitToColPos) && $colPos && !in_array($colPos, $this->limitToColPos)) {
                $colPosExcluded = true;
            }

            if (!$colPosExcluded && !HeaderUtility::headersSequentiallyDescending($previousHeader, $header)) {
                $node = new Node();
                $node->setHtml($header->ownerDocument->saveHTML($header));
                $node->setUid($this->getElementUid($header, $fallbackElementUid));
                $result->addNode($node);
                $result->setStatus(Status::VIOLATIONS);
            }

            $previousHeader = $header;
        }

        // If all found nodes passed, set status to passes
        if ($headers->count() > 0 && $result->getNodes() === []) {
            $result->setStatus(Status::PASSES);
        }

        return $result;
    }
}
