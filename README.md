# FileCache

## Installation
1) composer install

## Configuration
...

## Execute phpspec
Just execute bin/phpspec run





Namespaces:

    FileAdapter:
    "_" is a namespace separator, so when you give namespace like this:
        some_namespace:key

        you get /some/namespace/key, where key is a file with content

        then you can drop cache by namespace:
        when you give "some_namespace" to drop method then some/namespace/ directory will be removed
        when you give "some" to drop method then some/ directory will be removed
