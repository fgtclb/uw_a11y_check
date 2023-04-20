<?php

namespace UniWue\UwA11yCheck\Tests\Internal;

use UniWue\UwA11yCheck\Check\Result\Impact;
use UniWue\UwA11yCheck\Check\Result\Node;
use UniWue\UwA11yCheck\Check\Result\Status;
use DOMElement;
use Symfony\Component\DomCrawler\Crawler;
use UniWue\UwA11yCheck\Check\Result;
use UniWue\UwA11yCheck\Tests\AbstractTest;
use UniWue\UwA11yCheck\Utility\Tests\LinkUtility;
use UniWue\UwA11yCheck\Utility\Tests\SharedUtility;

/**
 * Class RedundantLinkTest
 */
class RedundantLinkTest extends AbstractTest
{
    /**
     * @var string
     */
    protected $id = 'redundant-link';

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
        $elements = $crawler->filter('a');

        $redundantLinks = $this->getRedundantLinks($elements);

        if ($redundantLinks !== []) {
            foreach ($redundantLinks as $element) {
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

    /**
     * Returns an array of all redundant links for the given object of elements
     *
     * @param Crawler $elements
     * @return mixed[]
     */
    protected function getRedundantLinks(Crawler $elements): array
    {
        $result = [];
        $groupedLinks = $this->groupLinksByHref($elements);

        foreach ($groupedLinks as $elementArray) {
            $redundantLinkNames = LinkUtility::getRedundantLinkNames($elementArray);
            if ((is_countable($elementArray) ? count($elementArray) : 0) > 1 && count($redundantLinkNames) >= 1) {
                $result = array_merge($result, $redundantLinkNames);
            }
        }

        return $result;
    }

    /**
     * Returns an array of links grouped by its href
     *
     * @param Crawler $element
     * @return array<string, DOMElement[]>
     */
    protected function groupLinksByHref(Crawler $elements): array
    {
        $allLinks = [];

        /** @var DOMElement $element */
        foreach ($elements as $element) {
            if (!$element->hasAttribute('href') ||
                SharedUtility::elementHasRolePresentation($element) ||
                SharedUtility::elementHasRoleNone($element)
            ) {
                continue;
            }

            $href = $element->getAttribute('href');
            if (!isset($allLinks[$href])) {
                $allLinks[$href] = [];
                $allLinks[$href][] = $element;
            } else {
                $allLinks[$href][] = $element;
            }
        }

        return $allLinks;
    }
}
