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
 * Class ImageTest
 */
class ImageAltTest extends AbstractTest
{
    /**
     * @var string
     */
    protected $id = 'image-alt';

    /**
     * @var string
     */
    protected $helpUrl = 'https://dequeuniversity.com/rules/axe/3.4/image-alt';

    /**
     * @var int
     */
    protected $impact = Impact::CRITICAL;

    /**
     * Runs the test
     */
    public function run(string $html, int $fallbackElementUid): Result
    {
        $result = $this->initResultWithMetaDataFromTest();

        $crawler = new Crawler($html);
        $images = $crawler->filter('img');

        /** @var DOMElement $image */
        foreach ($images as $image) {
            $checkResult = SharedUtility::elementHasAlt($image) ||
                SharedUtility::elementHasAriaLabelValue($image) ||
                SharedUtility::elementAriaLabelledByValueExistsAndNotEmpty($image, $crawler) ||
                SharedUtility::elementHasRolePresentation($image) ||
                SharedUtility::elementHasRoleNone($image);

            if (!$checkResult) {
                $node = new Node();
                $node->setHtml($image->ownerDocument->saveHTML($image));
                $node->setUid($this->getElementUid($image, $fallbackElementUid));
                $result->addNode($node);
                $result->setStatus(Status::VIOLATIONS);
            }
        }

        // If all found nodes passed, set status to passes
        if ($images->count() > 0 && $result->getNodes() === []) {
            $result->setStatus(Status::PASSES);
        }

        return $result;
    }
}
