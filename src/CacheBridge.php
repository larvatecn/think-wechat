<?php
declare (strict_types=1);

namespace larva\wechat;

use Psr\SimpleCache\CacheInterface;
use think\Cache;

class CacheBridge implements CacheInterface
{
    /**
     * @var Cache
     */
    protected Cache $cache;

    /**
     * CacheBridge constructor.
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->cache->get($key, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = null): bool
    {
        return $this->cache->set($key, $value, $ttl);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key): bool
    {
        return $this->cache->rm($key);
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        return $this->cache->clear();
    }

    /**
     * @param iterable $keys
     * @param null $default
     * @return iterable|void|null
     */
    public function getMultiple($keys, $default = null)
    {
        return null;
    }

    /**
     * @param iterable $values
     * @param null $ttl
     * @return bool
     */
    public function setMultiple($values, $ttl = null): bool
    {
        return false;
    }

    /**
     * @param iterable $keys
     * @return false
     */
    public function deleteMultiple($keys): bool
    {
        return false;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key): bool
    {
        return $this->cache->has($key);
    }
}