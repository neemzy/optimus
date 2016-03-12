<?php

namespace Aecf\Optimus\Tests;

use Aecf\Optimus\CollectionTransformer;
use Aecf\Optimus\TransformerRunner;

/**
 * Collection transformation workflow unit tests.
 *
 * @author Tom Panier <tpanier@auchan.net>
 */
class CollectionTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransformerRunner */
    private $runner;

    public function setUp()
    {
        $this->runner = new TransformerRunner();
    }

    /**
     * @return CollectionTransformer
     */
    private function getTransformer()
    {
        $transformer = $this->getMock('Aecf\Optimus\TransformerInterface');

        $transformer
            ->expects($this->exactly(4))
            ->method('supports')
            ->will($this->returnCallback('is_int'));

        return $transformer;
    }

    /**
     * @expectedException Aecf\Optimus\UnsupportedTransformationException
     */
    public function testTransformCollectionWithUnsupportedValue()
    {
        $transformer = $this->getTransformer();

        $this->runner->run(
            new CollectionTransformer($transformer),
            array(1, 2, 3, 'whatever')
        );
    }

    public function testTransformAllValidCollection()
    {
        $result = array(2, 4, 6, 8);
        $transformer = $this->getTransformer();

        $transformer
            ->expects($this->exactly(4))
            ->method('transform')
            ->will($this->returnCallback(
                function($value) {
                    return $value * 2;
                }
            ));

        $this->assertSame(
            $result,
            $this->runner->run(
                new CollectionTransformer($transformer),
                array(1, 2, 3, 4)
            )
        );
    }
}
