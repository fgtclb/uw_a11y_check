<?php

namespace UniWue\UwA11yCheck\Check;

/**
 * Class A11yCheck
 */
class A11yCheck
{
    /**
     * A11yCheck constructor.
     */
    public function __construct(protected Preset $preset)
    {
    }

    /**
     * Executes the check and returns the result as objectStorage
     *
     * @return ResultSet[]
     */
    public function executeCheck(int $id, int $levels = 0): array
    {
        return $this->preset->executeTestSuiteByPageUid($id, $levels);
    }
}
