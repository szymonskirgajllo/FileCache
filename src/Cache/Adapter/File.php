<?php

namespace Cache\Adapter;

use Cache\AdapterInterface;

/**
 * @author Szymon Skirgajllo <szymon.skirgajllo@gmail.com>
 */
class File implements AdapterInterface
{
    private $cacheDir = './data/cache/';

    /**
     * @param string $key
     * @param array $data
     * @param int $ttl
     * @return bool
     */
    public function setItem($key = '', array $data = [], $ttl = 0)
    {
        $filenameKey = $this->cacheDir . $key;

        if (!file_exists($this->getDirectoryFromNamespace($filenameKey))) {
            mkdir($this->getDirectoryFromNamespace($filenameKey), 0777, true);
        }

        $filenameKey = $this->cacheDir . $this->keyToFilename($key);

        $value = $this->prepareContent($data, $ttl);

        return (bool)file_put_contents($filenameKey, $value);
    }

    public function getItem($key)
    {
        $filenameKey = $this->cacheDir . $this->keyToFilename($key);

        if ($key === '') {
            throw new \Exception();
        }

        if (!file_exists($filenameKey)) {
            return false;
        }

        $item = unserialize(file_get_contents($filenameKey));

        return $item['value'];
    }

    public function hasItem($key)
    {
        // TODO: check whether received item has actual ttl... if not -> remove, if yes -> return

        return (bool) $this->getItem($key);
    }

    public function removeItem($key)
    {
        $filenameKey = $this->cacheDir . $this->keyToFilename($key);

        if (file_exists($filenameKey)) {
            unlink($filenameKey);

            return true;
        }

        return false;
    }

    /**
     * Drops all cache based on given namespace.
     *
     * @param string $namespace
     * @return bool
     * @throws \Exception when namespace is empty
     */
    public function dropItems($namespace = '')
    {
        if ($namespace === '') {
            throw new \Exception('Namespace can not be empty!');
        }

        $oldNamespace = $namespace;

        $namespace = $this->cacheDir . $this->getDirectoryFromNamespace($namespace);

        if (!file_exists($namespace)) {
            return false;
        }

        $files = array_diff(scandir($namespace), ['.', '..']);

        foreach ($files as $file) {
            if (is_dir($namespace . '/' . $file)) {
                if (count(scandir($namespace . '/' . $file)) === 2) {
                    // directory is empty -> remove it
                    rmdir($namespace . '/' . $file);
                } else {
                    // directory is not empty -> remove all files
                    $this->dropItems($namespace . '/' . $file);
                }
            } else {
                unlink($namespace . '/' . $file);
            }
        }

        rmdir($namespace);

        $oldNamespace = substr($oldNamespace, 0, strrpos($oldNamespace, '_'));

        if ($oldNamespace !== '') {
            $this->dropItems($oldNamespace);
        }

        return true;
    }

    /**
     * Prepares and returns serialized array with the necessary values.
     *
     * @param array $data
     * @param int $ttl
     * @return string
     */
    private function prepareContent(array $data = [], $ttl = 0)
    {
        return serialize([
            'value' => $data,
            'timestamp' => time(),
            'ttl' => $ttl
        ]);
    }

    /**
     * Converts given namespace to directories separated by slash.
     *
     * @param string $namespace
     * @return string
     */
    private function getDirectoryFromNamespace($namespace)
    {
        $names = explode(':', $namespace);

        $dir = array_shift($names);
        $dir = str_replace('_', '/', $dir);

        return $dir;
    }

    /**
     * Converts given key to hashed filename.
     *
     * @param string $key
     * @return string
     */
    private function keyToFilename($key)
    {
        $names = explode(':', $key);

        $filename = array_pop($names);

        $key = str_replace('_', '/', array_pop($names));
        $key = $key . '/';

        return $key . md5($filename);
    }
}
