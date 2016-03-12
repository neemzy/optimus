<?php

namespace Aecf\Optimus\Tests;

use Aecf\Optimus\TransformerRunner;

/**
 * Transformation service workflow unit tests.
 *
 * @author Tom Panier <tpanier@auchan.net>
 */
class TransformerRunnerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransformerRunner */
    private $runner;

    public function setUp()
    {
        $this->runner = new TransformerRunner();
    }

    /**
     * @expectedException Aecf\Optimus\UnsupportedTransformationException
     */
    public function testTransformUnsupportedValue()
    {
        $transformer = $this->getMock('Aecf\Optimus\TransformerInterface');

        $transformer
            ->expects($this->once())
            ->method('supports')
            ->willReturn(false);

        $this->runner->run($transformer, 'whatever');
    }

    public function testTransformSupportedValue()
    {
        $result = 'Optimus Prime';
        $transformer = $this->getMock('Aecf\Optimus\TransformerInterface');

        $transformer
            ->expects($this->once())
            ->method('supports')
            ->willReturn(true);

        $transformer
            ->expects($this->once())
            ->method('transform')
            ->willReturn($result);

        $this->assertSame(
            $result,
            $this->runner->run($transformer, 'whatever')
        );
    }
}
