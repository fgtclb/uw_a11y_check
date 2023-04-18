<?php

namespace UniWue\UwA11yCheck\Tests\Internal;

use UniWue\UwA11yCheck\Check\Result\Impact;
use DOMElement;
use UniWue\UwA11yCheck\Check\Result\Node;
use UniWue\UwA11yCheck\Check\Result\Status;
use Symfony\Component\DomCrawler\Crawler;
use UniWue\UwA11yCheck\Check\Result;
use UniWue\UwA11yCheck\Tests\AbstractTest;
use UniWue\UwA11yCheck\Utility\Tests\SharedUtility;

/**
 * Class RedundantTitleTest
 */
class RedundantTitleTest extends AbstractTest
{
    /**
     * @var string
     */
    protected $id = 'redundant-title';

    /**
     * @var int
     */
    protected $impact = Impact::MINOR;

    /**
     * Runs the test
     */
    public function run(string $html, int $fallbackElementUid): Result
    {
        $result = $this->initResultWithMetaDataFromTest();

        $crawler = new Crawler($html);
        $elements = $crawler->filter('a, img');

        /** @var DOMElement $element */
        foreach ($elements as $element) {
            $checkResult = SharedUtility::elementTitleNotRedundant($element);

            if (!$checkResult) {
                $node = new Node();
                $node->setHtml($element->ownerDocument->saveHTML($element));
                $node->setUid($this->getElementUid($element, $fallbackElementUid));
                $result->addNode($node);
                $result->setStatus(Status::VIOLATIONS);
            }
        }

        // If all found nodes passed, set status to passes
        if ($elements->count() > 0 && $result->getNodes() === []) {
            $result->setStatus(Status::PASSES);
        }

        return $result;
    }
}
