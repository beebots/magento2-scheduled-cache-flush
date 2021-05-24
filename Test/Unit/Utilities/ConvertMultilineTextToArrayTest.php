<?php


namespace BeeBots\ScheduledCacheFlush\Test\Unit\Utilities;

use BeeBots\ScheduledCacheFlush\Utilities\ConvertMultilineTextToArray;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ConvertMultilineTextToArrayTest extends MockeryTestCase
{
    /** @var ConvertMultilineTextToArrayTest */
    private $convertMultilineTextToArray;

    public function setUp(): void
    {
        $this->convertMultilineTextToArray = new ConvertMultilineTextToArray();
    }

    public function testNullStringReturnsEmptyArray()
    {
        $result = $this->convertMultilineTextToArray->execute(null);
        $this->assertIsArray($result, "Is not array");
        $this->assertEmpty($result, "The array is not empty");
    }

    public function testEmptyStringReturnsEmptyArray()
    {
        $result = $this->convertMultilineTextToArray->execute('');
        $this->assertIsArray($result, "Failed to return an array");
        $this->assertEmpty($result, "The array is not empty");
    }

    public function testNormalUseCase()
    {
        $stringToConvert = 'one' . PHP_EOL
            . 'two' . PHP_EOL
            . 'three' . PHP_EOL;
        $result = $this->convertMultilineTextToArray->execute($stringToConvert);
        $this->assertEquals(
            [ 'one', 'two', 'three'],
            $result,
            "Unexpected Result"
        );
    }

    public function testLineWithWhitespaceGetsRemoved()
    {
        $stringToConvert = ' one' . PHP_EOL
            . 'two ' . PHP_EOL
            . 'three ' . PHP_EOL;
        $result = $this->convertMultilineTextToArray->execute($stringToConvert);
        $this->assertEquals(
            [ 'one', 'two', 'three'],
            $result,
            "Unexpected Result"
        );
    }

    public function testEmptyLineGetsRemoved()
    {
        $stringToConvert = 'one' . PHP_EOL
            . 'two' . PHP_EOL
            . PHP_EOL
            . 'three' . PHP_EOL;
        $result = $this->convertMultilineTextToArray->execute($stringToConvert);
        $this->assertEquals(
            [ 'one', 'two', 'three'],
            $result,
            "Unexpected Result"
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
