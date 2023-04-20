<?php

namespace UniWue\UwA11yCheck\Property\TypeConverter;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;
use UniWue\UwA11yCheck\Check\Preset;
use UniWue\UwA11yCheck\Service\PresetService;

/**
 * Class PresetTypeConverter
 */
class PresetTypeConverter extends AbstractTypeConverter
{
    protected PresetService $presetService;


    /**
     * @var array
     */
    protected $sourceTypes = ['string'];

    /**
     * @var string
     */
    protected $targetType = Preset::class;

    /**
     * @var int
     */
    protected $priority = 1;

    public function injectConfigurationService(PresetService $presetService): void
    {
        $this->presetService = $presetService;
    }

    /**
     * @param mixed $source
     * @param PropertyMappingConfigurationInterface|null $configuration
     * @return mixed|object|Error|Preset
     */
    public function convertFrom(
        $source,
        string $targetType,
        array $convertedChildProperties = [],
        PropertyMappingConfigurationInterface $configuration = null
    ): Error|Preset {
        $preset = $this->presetService->getPresetById($source);

        if (!$preset instanceof Preset) {
            return GeneralUtility::makeInstance(Error::class, 'Preset not found', 1573053017102);
        }

        return $preset;
    }
}
