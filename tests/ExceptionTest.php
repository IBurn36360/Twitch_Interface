<?php

use \IBurn36360\TwitchInterface\Exception as TIException;
use \PHPUnit\Framework\TestCase;

/**
 * Test runner for the interface exceptions
 *
 * @package Modules
 */
class ExceptionTest extends TestCase {
    private $exceptionClasses = [];

    private $exceptionNamespace = 'IBurn36360\\TwitchInterface\\Exception\\';

    /**
     * Sets up the testing environment
     */
    public function setUp():void {
        // Resolves all exceptions which are not the container
        foreach (glob(($fileDirPath = realpath(__DIR__ . '/../') . '/src/Exception/') . '*') as $filename) {
            if (($filename = str_replace([$fileDirPath, '.php'], '', $filename)) !== 'Exception') {
                $this->exceptionClasses[] = $filename;
            }
        }
    }

    /**
     * Tests namespace autoloading for all exceptions that are not the container (Which autoloads as a result of the child exceptions)
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function namespaceAutoload():void {
        foreach ($this->exceptionClasses as $className) {
            $className = "{$this->exceptionNamespace}$className";
            new $className();
        }

        $this->assertTrue(true);
    }

    /**
     * Tests that all exceptions are an instance of the container
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function exceptionContainerInheritance():void {
        foreach ($this->exceptionClasses as $className) {
            $className = "IBurn36360\\TwitchInterface\\Exception\\$className";

            $this->assertInstanceOf(
                TIException\Exception::class,
                new $className()
            );
        }
    }

    /**
     * Tests that all exceptions are an eventual instance of the root exception (Will need to be throwable some day)
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function exceptionContainerIsException():void {
        $this->assertInstanceOf(
            \Exception::class,
            new TIException\Exception()
        );
    }
}
