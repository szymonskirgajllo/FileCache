<?php

namespace Cache;

/**
 * @package Cache
 * @author Szymon Skirgajllo <szymon.skirgajllo@gmail.com>
 */
class Cache
{
    /** @var AdapterInterface $adapter */
    private $adapter = null;
    private $namespace = '';

    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param string $namespace
     * @return Cache
     * @throws \UnexpectedValueException when namespace is empty
     */
    public function setNamespace($namespace = '')
    {
        if ($namespace === '') {
            throw new \UnexpectedValueException('namespace can not be empty');
        }

        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Returns namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Adds item to cache.
     *
     * @param string $key
     * @param array $data
     * @param int $ttl
     * @return bool
     */
    public function addItem($key = '', array $data = [], $ttl = 0)
    {
        return $this->adapter->setItem($key, $data, $ttl);
    }

    /**
     * Gets and returns item from cache based on given key.
     * @param $key
     * @return mixed
     */
    public function getItem($key)
    {
        return $this->adapter->getItem($key);
    }
}
