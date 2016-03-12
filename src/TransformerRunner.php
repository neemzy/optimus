<?php

namespace Aecf\Optimus;

/**
 * Transformation service runner, handling the workflow.
 *
 * @author Tom Panier <tpanier@auchan.net>
 */
class TransformerRunner
{
    /**
     * @param TransformerInterface $transformer
     * @param mixed                $source
     *
     * @return mixed
     */
    public function run(TransformerInterface $transformer, $source)
    {
        if (!$transformer->supports($source)) {
            throw new UnsupportedTransformationException();
        }

        return $transformer->transform($source);
    }
}
