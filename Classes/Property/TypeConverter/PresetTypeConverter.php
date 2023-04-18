<?php

namespace UniWue\UwA11yCheck\Property\TypeConverter;

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
    /**
     * @var PresetService
     */
    protected $presetService;

    public function injectConfigurationService(PresetService $presetService): void
    {
        $this->presetService = $presetService;
    }

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

    /**
     * @param mixed $source
     * @param string $targetType
     * @param PropertyMappingConfigurationInterface|null $configuration
     * @return mixed|object|Error|Preset
     */
    public function convertFrom(
        $source,
        $targetType,
        array $convertedChildProperties = [],
        PropertyMappingConfigurationInterface $configuration = null
    ): Error|Preset {
        $preset = $this->presetService->getPresetById($source);

        if (!$preset instanceof Preset) {
            return $this->objectManager->get(Error::class, 'Preset not found', 1_573_053_017_102);
        }

        return $preset;
    }
}
