<?php

namespace Aecf\Optimus;

/**
 * Transformation service decorator for handling iterables.
 *
 * @author Tom Panier <tpanier@auchan.net>
 */
class CollectionTransformer implements TransformerInterface
{
    /** @var TransformerInterface */
    private $transformer;

    /**
     * @param TransformerInterface $transformer
     */
    public function __construct(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($source)
    {
        foreach ($source as $item) {
            if (!$this->transformer->supports($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($source)
    {
        $results = array();

        foreach ($source as $item) {
            $results[] = $this->transformer->transform($item);
        }

        return $results;
    }
}