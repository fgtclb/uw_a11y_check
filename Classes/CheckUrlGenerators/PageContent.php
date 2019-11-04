<?php
namespace UniWue\UwA11yCheck\CheckUrlGenerators;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use UniWue\UwA11yCheck\Utility\ContentElementUtility;

/**
 * Generates an URL for to configured targetPid.
 * The targetPid must include the pi1 plugin of this extension
 */
class PageContent extends AbstractCheckUrlGenerator
{
    /**
     * @var int
     */
    protected $targetPid = 0;

    /**
     * PageContent constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        parent::__construct($configuration);

        $this->targetPid = $configuration['targetPid'];
    }

    /**
     * Returns the check URL
     *
     * @param string $baseUrl
     * @param int $pageUid
     * @return string|void
     */
    public function getCheckUrl(string $baseUrl, int $pageUid)
    {
        $contentElementUids = ContentElementUtility::getContentElementsUidsByPage($pageUid);
        $contentElementUidList = implode(',', $contentElementUids);
        $hmac = GeneralUtility::hmac($contentElementUidList, 'tt_content_uid_list');

        return $this->uriBuilder
            ->setTargetPageUid($this->targetPid)
            ->setArguments([
                'tx_uwa11ycheck_pi1[action]' => 'show',
                'tx_uwa11ycheck_pi1[controller]' => 'ContentElements',
                'tx_uwa11ycheck_pi1[uidList]' => $contentElementUidList,
                'tx_uwa11ycheck_pi1[hmac]' => $hmac
            ])
            ->buildFrontendUri();
    }
}
