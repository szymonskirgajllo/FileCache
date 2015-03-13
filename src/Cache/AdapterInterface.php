<?php

namespace Cache;

/**
 * @author Szymon Skirgajllo <szymon.skirgajllo@gmail.com>
 */
interface AdapterInterface
{
    /**
     * Adds item to cache.
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return boolean
     */
    public function setItem($key, $data, $ttl);

    /**
     * Gets item from cache by given key and returns it.
     *
     * @param $key
     * @return array
     */
    public function getItem($key);

    /**
     * Checks whether given key exists in cache.
     *
     * @param $key
     * @return boolean
     */
    public function itemExist($key);

    /**
     * Removes item from cache by given key.
     *
     * @param $key
     * @return boolean
     */
    public function removeItem($key);
}