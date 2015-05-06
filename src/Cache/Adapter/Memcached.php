<?php

namespace Cache\Adapter;

use Cache\AdapterInterface;

/**
 * @author Szymon Skirgajllo <szymon.skirgajllo@gmail.com>
 */
class Memcached implements AdapterInterface
{
    private $memcached = null;

    public function __construct(array $servers = [])
    {
        // TODO: Use default server 127.0.0.1 11211 if array with servers is empty

        $this->memcached = new \Memcached();
        $this->memcached->addServers($servers);
    }

    /**
     * Adds item to cache.
     *
     * @param string $key
     * @param array $data
     * @param int $ttl
     * @return bool
     */
    public function setItem($key = '', array $data = [], $ttl = 0)
    {
        return $this->memcached->set($key, serialize($data), $ttl);
    }

    /**
     * Gets item from cache by given key and returns it.
     *
     * @param $key
     * @throws \Exception when the key variable is empty
     * @return array
     */
    public function getItem($key = '')
    {
        if ($key === '') {
            throw new \Exception('Key should not be empty');
        }

        return unserialize($this->memcached->get($key));
    }

    /**
     * Checks whether given key exists in cache.
     *
     * @param $key
     * @throws \Exception when the key variable is empty
     * @return bool
     */
    public function hasItem($key = '')
    {
        if ($key === '') {
            throw new \Exception('Key should not be empty');
        }

        return (bool)$this->memcached->get($key);
    }

    /**
     * Removes item from cache by given key.
     *
     * @param $key
     * @throws \Exception when the key variable is empty
     * @return bool
     */
    public function removeItem($key = '')
    {
        if ($key === '') {
            throw new \Exception('Key should not be empty');
        }

        return $this->memcached->delete($key);
    }

    /**
     * Removes all items from cache based on given namespace.
     *
     * @param string $namespace
     * @return bool
     */
    public function dropItems($namespace = '')
    {
        // TODO: Implement dropItems() method.
        // TODO: Use strpos, foreach and $this->memcached->getAllKeys() http://stackoverflow.com/a/25167954
    }

    /**
     * Clears all the cache.
     * @return bool
     */
    public function clear()
    {
        return $this->memcached->flush();
    }
}
