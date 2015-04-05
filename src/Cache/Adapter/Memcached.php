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
        // TODO: Throw exception when $servers is empty

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
        // TODO: Check $this->memcached->getResultMessage() or $this->memcached->getResultCode()
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
        // TODO: Check $this->memcached->getResultMessage() or $this->memcached->getResultCode()
        if ($key === '') {
            throw new \Exception('Key should not be empty');
        }

        return unserialize($this->memcached->get($key));
    }

    /**
     * Checks whether given key exists in cache.
     *
     * @param $key
     * @return bool
     */
    public function hasItem($key = '')
    {
        // TODO: Check $this->memcached->getResultMessage() or $this->memcached->getResultCode()
        // TODO: Implement hasItem() method.
    }

    /**
     * Removes item from cache by given key.
     *
     * @param $key
     * @return bool
     */
    public function removeItem($key = '')
    {
        // TODO: Check $this->memcached->getResultMessage() or $this->memcached->getResultCode()
        // TODO: Implement removeItem() method.
    }

    /**
     * Removes all items from cache based on given namespace.
     *
     * @param string $namespace
     * @return bool
     */
    public function dropItems($namespace = '')
    {
        // TODO: Check $this->memcached->getResultMessage() or $this->memcached->getResultCode()
        // TODO: Implement dropItems() method.
    }

}
