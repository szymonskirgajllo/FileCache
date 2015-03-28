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
     * @param string $key
     * @param array $data
     * @param int $ttl
     * @return bool
     */
    public function setItem($key = '', array $data = [], $ttl = 0);

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
     * @return bool
     */
    public function hasItem($key);

    /**
     * Removes item from cache by given key.
     *
     * @param $key
     * @return bool
     */
    public function removeItem($key);
}