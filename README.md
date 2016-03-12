# Optimus

Data transformation as a service

## Usage

### Transformers

Every transformation service class should:

- Live in a `Transformer` sub-namespace of your application/package
- Be named in the following fashion, without dispensable repeats: `{SourceType}To{TargetType}Transformer` (e.g. `CustomerEntityToViewModelTransformer`)
- Implement the `TransformerInterface`:

```php
<?php

namespace MyApp\Transformer;

use Aecf\Optimus\TransformerInterface;

class CustomerEntityToViewModelTransformer implements TransformerInterface
{
    /**
     * Checks whether the given data source
     * is compatible with this transformer.
     *
     * @param mixed $source
     *
     * @return bool
     */
    public function supports($source)
    {
        // ...
    }

    /**
     * Performs the actual transformation.
     *
     * @param mixed $source
     *
     * @return mixed
     */
    public function transform($source)
    {
        // ...
    }
}
```

### Runner

As we have just seen, when using a transformation service class, you must first use its `supports` method to check whether it can handle the data you want to feed it with, and then use its `transform` method to perform the actual processing. Though it is easy, it is a bit cumbersome, which is why the package also provides a `TransformerRunner` class:

```php
$transformer = new CustomerEntityToViewModelTransformer();
$runner = new Aecf\Optimus\TransformerRunner();

$result = $runner->run($transformer, 'I am a supported value! Yay!');
$result = $runner->run($transformer, 'I am an unsupported value'); // throws Aecf\Optimus\UnsupportedTransformationException
```

### Collection transformer

There also is a convenient way to apply a transformation service to a whole collection (array, iterator, etc.):

```php
$transformer = new CustomerEntityToViewModelTransformer();
$collectionTransformer = new Aecf\Optimus\CollectionTransformer($transformer);

$collectionTransformer->supports(array(1, 2, 3)); // will check every value with the inner transformer's "supports" method
$results = $collectionTransformer->transform(array(1, 2, 3)); // will return an array with transformed values
```

As you may have noticed, `CollectionTransformer` also implements `TransformerInterface`, so it can be fed to `TransformerRunner` seamlessly.

## Unit tests

Simply run `phpunit` at the package's root.

## Credits

Written by [Tom Panier](http://neemzy.org) with &hearts; for AECF.
