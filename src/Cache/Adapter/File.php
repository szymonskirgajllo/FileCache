<?php

namespace Cache\Adapter;

use Cache\AdapterInterface;

/**
 * @author Szymon Skirgajllo <szymon.skirgajllo@gmail.com>
 */
class File implements AdapterInterface
{
    public function setItem($key, $item, $ttl)
    {
        // TODO: Implement setItem() method.
    }

    public function getItem($key)
    {
        return [
            'some data',
            'some other data'
        ];
    }

    public function itemExist($key)
    {
        // TODO: Implement itemExists() method.
    }

    public function removeItem($key)
    {
        // TODO: Implement removeItem() method.
    }

}