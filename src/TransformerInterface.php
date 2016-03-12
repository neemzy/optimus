<?php

namespace Aecf\Optimus;

/**
 * Interface describing a transformation service class.
 *
 * @author Tom Panier <tpanier@auchan.net>
 */
interface TransformerInterface
{
    /**
     * Checks whether the given data source
     * is compatible with this transformer.
     *
     * @param mixed $source
     *
     * @return bool
     */
    public function supports($source);

    /**
     * Performs the actual transformation.
     *
     * @param mixed $source
     *
     * @return mixed
     */
    public function transform($source);
}
