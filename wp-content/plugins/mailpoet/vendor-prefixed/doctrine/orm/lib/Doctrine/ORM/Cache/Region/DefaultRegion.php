<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */
namespace MailPoetVendor\Doctrine\ORM\Cache\Region;

use MailPoetVendor\Doctrine\Common\Cache\Cache as CacheAdapter;
use MailPoetVendor\Doctrine\Common\Cache\ClearableCache;
use MailPoetVendor\Doctrine\ORM\Cache\CacheEntry;
use MailPoetVendor\Doctrine\ORM\Cache\CacheKey;
use MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheEntry;
use MailPoetVendor\Doctrine\ORM\Cache\Lock;
use MailPoetVendor\Doctrine\ORM\Cache\Region;
/**
 * The simplest cache region compatible with all doctrine-cache drivers.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class DefaultRegion implements \MailPoetVendor\Doctrine\ORM\Cache\Region
{
    const REGION_KEY_SEPARATOR = '_';
    /**
     * @var CacheAdapter
     */
    protected $cache;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var integer
     */
    protected $lifetime = 0;
    /**
     * @param string       $name
     * @param CacheAdapter $cache
     * @param integer      $lifetime
     */
    public function __construct($name, \MailPoetVendor\Doctrine\Common\Cache\Cache $cache, $lifetime = 0)
    {
        $this->cache = $cache;
        $this->name = (string) $name;
        $this->lifetime = (int) $lifetime;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return \MailPoetVendor\Doctrine\Common\Cache\CacheProvider
     */
    public function getCache()
    {
        return $this->cache;
    }
    /**
     * {@inheritdoc}
     */
    public function contains(\MailPoetVendor\Doctrine\ORM\Cache\CacheKey $key)
    {
        return $this->cache->contains($this->getCacheEntryKey($key));
    }
    /**
     * {@inheritdoc}
     */
    public function get(\MailPoetVendor\Doctrine\ORM\Cache\CacheKey $key)
    {
        return $this->cache->fetch($this->getCacheEntryKey($key)) ?: null;
    }
    /**
     * {@inheritdoc}
     */
    public function getMultiple(\MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheEntry $collection)
    {
        $result = array();
        foreach ($collection->identifiers as $key) {
            $entryKey = $this->getCacheEntryKey($key);
            $entryValue = $this->cache->fetch($entryKey);
            if ($entryValue === \false) {
                return null;
            }
            $result[] = $entryValue;
        }
        return $result;
    }
    /**
     * @param CacheKey $key
     * @return string
     */
    protected function getCacheEntryKey(\MailPoetVendor\Doctrine\ORM\Cache\CacheKey $key)
    {
        return $this->name . self::REGION_KEY_SEPARATOR . $key->hash;
    }
    /**
     * {@inheritdoc}
     */
    public function put(\MailPoetVendor\Doctrine\ORM\Cache\CacheKey $key, \MailPoetVendor\Doctrine\ORM\Cache\CacheEntry $entry, \MailPoetVendor\Doctrine\ORM\Cache\Lock $lock = null)
    {
        return $this->cache->save($this->getCacheEntryKey($key), $entry, $this->lifetime);
    }
    /**
     * {@inheritdoc}
     */
    public function evict(\MailPoetVendor\Doctrine\ORM\Cache\CacheKey $key)
    {
        return $this->cache->delete($this->getCacheEntryKey($key));
    }
    /**
     * {@inheritdoc}
     */
    public function evictAll()
    {
        if (!$this->cache instanceof \MailPoetVendor\Doctrine\Common\Cache\ClearableCache) {
            throw new \BadMethodCallException(\sprintf('Clearing all cache entries is not supported by the supplied cache adapter of type %s', \get_class($this->cache)));
        }
        return $this->cache->deleteAll();
    }
}
