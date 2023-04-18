<?php

namespace UniWue\UwA11yCheck\Check;

use UniWue\UwA11yCheck\Tests\TestInterface;

/**
 * Class TestSuite
 */
class TestSuite
{
    /**
     * @var array
     */
    protected $tests = [];

    public function addTest(TestInterface $test): void
    {
        $this->tests[] = $test;
    }

    /**
     * @return mixed[]
     */
    public function getTests(): array
    {
        return $this->tests;
    }

    /**
     * @param mixed[] $tests
     */
    public function setTests(array $tests): void
    {
        $this->tests = $tests;
    }
}
