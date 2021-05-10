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
namespace MailPoetVendor\Doctrine\ORM\Cache;

use MailPoetVendor\Doctrine\Common\Collections\ArrayCollection;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister;
use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
use MailPoetVendor\Doctrine\ORM\Query\ResultSetMapping;
use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\ORM\PersistentCollection;
use MailPoetVendor\Doctrine\Common\Proxy\Proxy;
use MailPoetVendor\Doctrine\ORM\Cache;
use MailPoetVendor\Doctrine\ORM\Query;
/**
 * Default query cache implementation.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class DefaultQueryCache implements \MailPoetVendor\Doctrine\ORM\Cache\QueryCache
{
    /**
     * @var \MailPoetVendor\Doctrine\ORM\EntityManagerInterface
     */
    private $em;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\UnitOfWork
     */
    private $uow;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\Region
     */
    private $region;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\QueryCacheValidator
     */
    private $validator;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\Logging\CacheLogger
     */
    protected $cacheLogger;
    /**
     * @var array
     */
    private static $hints = array(\MailPoetVendor\Doctrine\ORM\Query::HINT_CACHE_ENABLED => \true);
    /**
     * @param \MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em     The entity manager.
     * @param \MailPoetVendor\Doctrine\ORM\Cache\Region           $region The query region.
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, \MailPoetVendor\Doctrine\ORM\Cache\Region $region)
    {
        $cacheConfig = $em->getConfiguration()->getSecondLevelCacheConfiguration();
        $this->em = $em;
        $this->region = $region;
        $this->uow = $em->getUnitOfWork();
        $this->cacheLogger = $cacheConfig->getCacheLogger();
        $this->validator = $cacheConfig->getQueryValidator();
    }
    /**
     * {@inheritdoc}
     */
    public function get(\MailPoetVendor\Doctrine\ORM\Cache\QueryCacheKey $key, \MailPoetVendor\Doctrine\ORM\Query\ResultSetMapping $rsm, array $hints = array())
    {
        if (!($key->cacheMode & \MailPoetVendor\Doctrine\ORM\Cache::MODE_GET)) {
            return null;
        }
        $entry = $this->region->get($key);
        if (!$entry instanceof \MailPoetVendor\Doctrine\ORM\Cache\QueryCacheEntry) {
            return null;
        }
        if (!$this->validator->isValid($key, $entry)) {
            $this->region->evict($key);
            return null;
        }
        $result = array();
        $entityName = \reset($rsm->aliasMap);
        $hasRelation = !empty($rsm->relationMap);
        $persister = $this->uow->getEntityPersister($entityName);
        $region = $persister->getCacheRegion();
        $regionName = $region->getName();
        // @TODO - move to cache hydration component
        foreach ($entry->result as $index => $entry) {
            if (($entityEntry = $region->get($entityKey = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($entityName, $entry['identifier']))) === null) {
                if ($this->cacheLogger !== null) {
                    $this->cacheLogger->entityCacheMiss($regionName, $entityKey);
                }
                return null;
            }
            if ($this->cacheLogger !== null) {
                $this->cacheLogger->entityCacheHit($regionName, $entityKey);
            }
            if (!$hasRelation) {
                $result[$index] = $this->uow->createEntity($entityEntry->class, $entityEntry->resolveAssociationEntries($this->em), self::$hints);
                continue;
            }
            $data = $entityEntry->data;
            foreach ($entry['associations'] as $name => $assoc) {
                $assocPersister = $this->uow->getEntityPersister($assoc['targetEntity']);
                $assocRegion = $assocPersister->getCacheRegion();
                if ($assoc['type'] & \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::TO_ONE) {
                    if (($assocEntry = $assocRegion->get($assocKey = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($assoc['targetEntity'], $assoc['identifier']))) === null) {
                        if ($this->cacheLogger !== null) {
                            $this->cacheLogger->entityCacheMiss($assocRegion->getName(), $assocKey);
                        }
                        $this->uow->hydrationComplete();
                        return null;
                    }
                    $data[$name] = $this->uow->createEntity($assocEntry->class, $assocEntry->resolveAssociationEntries($this->em), self::$hints);
                    if ($this->cacheLogger !== null) {
                        $this->cacheLogger->entityCacheHit($assocRegion->getName(), $assocKey);
                    }
                    continue;
                }
                if (!isset($assoc['list']) || empty($assoc['list'])) {
                    continue;
                }
                $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);
                $collection = new \MailPoetVendor\Doctrine\ORM\PersistentCollection($this->em, $targetClass, new \MailPoetVendor\Doctrine\Common\Collections\ArrayCollection());
                foreach ($assoc['list'] as $assocIndex => $assocId) {
                    if (($assocEntry = $assocRegion->get($assocKey = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($assoc['targetEntity'], $assocId))) === null) {
                        if ($this->cacheLogger !== null) {
                            $this->cacheLogger->entityCacheMiss($assocRegion->getName(), $assocKey);
                        }
                        $this->uow->hydrationComplete();
                        return null;
                    }
                    $element = $this->uow->createEntity($assocEntry->class, $assocEntry->resolveAssociationEntries($this->em), self::$hints);
                    $collection->hydrateSet($assocIndex, $element);
                    if ($this->cacheLogger !== null) {
                        $this->cacheLogger->entityCacheHit($assocRegion->getName(), $assocKey);
                    }
                }
                $data[$name] = $collection;
                $collection->setInitialized(\true);
            }
            $result[$index] = $this->uow->createEntity($entityEntry->class, $data, self::$hints);
        }
        $this->uow->hydrationComplete();
        return $result;
    }
    /**
     * {@inheritdoc}
     */
    public function put(\MailPoetVendor\Doctrine\ORM\Cache\QueryCacheKey $key, \MailPoetVendor\Doctrine\ORM\Query\ResultSetMapping $rsm, $result, array $hints = array())
    {
        if ($rsm->scalarMappings) {
            throw new \MailPoetVendor\Doctrine\ORM\Cache\CacheException("Second level cache does not support scalar results.");
        }
        if (\count($rsm->entityMappings) > 1) {
            throw new \MailPoetVendor\Doctrine\ORM\Cache\CacheException("Second level cache does not support multiple root entities.");
        }
        if (!$rsm->isSelect) {
            throw new \MailPoetVendor\Doctrine\ORM\Cache\CacheException("Second-level cache query supports only select statements.");
        }
        if (isset($hints[\MailPoetVendor\Doctrine\ORM\Query::HINT_FORCE_PARTIAL_LOAD]) && $hints[\MailPoetVendor\Doctrine\ORM\Query::HINT_FORCE_PARTIAL_LOAD]) {
            throw new \MailPoetVendor\Doctrine\ORM\Cache\CacheException("Second level cache does not support partial entities.");
        }
        if (!($key->cacheMode & \MailPoetVendor\Doctrine\ORM\Cache::MODE_PUT)) {
            return \false;
        }
        $data = array();
        $entityName = \reset($rsm->aliasMap);
        $hasRelation = !empty($rsm->relationMap);
        $metadata = $this->em->getClassMetadata($entityName);
        $persister = $this->uow->getEntityPersister($entityName);
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            throw \MailPoetVendor\Doctrine\ORM\Cache\CacheException::nonCacheableEntity($entityName);
        }
        $region = $persister->getCacheRegion();
        foreach ($result as $index => $entity) {
            $identifier = $this->uow->getEntityIdentifier($entity);
            $data[$index]['identifier'] = $identifier;
            $data[$index]['associations'] = array();
            if ($key->cacheMode & \MailPoetVendor\Doctrine\ORM\Cache::MODE_REFRESH || !$region->contains($entityKey = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($entityName, $identifier))) {
                // Cancel put result if entity put fail
                if (!$persister->storeEntityCache($entity, $entityKey)) {
                    return \false;
                }
            }
            if (!$hasRelation) {
                continue;
            }
            // @TODO - move to cache hydration components
            foreach ($rsm->relationMap as $name) {
                $assoc = $metadata->associationMappings[$name];
                if (($assocValue = $metadata->getFieldValue($entity, $name)) === null || $assocValue instanceof \MailPoetVendor\Doctrine\Common\Proxy\Proxy) {
                    continue;
                }
                if (!isset($assoc['cache'])) {
                    throw \MailPoetVendor\Doctrine\ORM\Cache\CacheException::nonCacheableEntityAssociation($entityName, $name);
                }
                $assocPersister = $this->uow->getEntityPersister($assoc['targetEntity']);
                $assocRegion = $assocPersister->getCacheRegion();
                $assocMetadata = $assocPersister->getClassMetadata();
                // Handle *-to-one associations
                if ($assoc['type'] & \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::TO_ONE) {
                    $assocIdentifier = $this->uow->getEntityIdentifier($assocValue);
                    if ($key->cacheMode & \MailPoetVendor\Doctrine\ORM\Cache::MODE_REFRESH || !$assocRegion->contains($entityKey = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($assocMetadata->rootEntityName, $assocIdentifier))) {
                        // Cancel put result if association entity put fail
                        if (!$assocPersister->storeEntityCache($assocValue, $entityKey)) {
                            return \false;
                        }
                    }
                    $data[$index]['associations'][$name] = array('targetEntity' => $assocMetadata->rootEntityName, 'identifier' => $assocIdentifier, 'type' => $assoc['type']);
                    continue;
                }
                // Handle *-to-many associations
                $list = array();
                foreach ($assocValue as $assocItemIndex => $assocItem) {
                    $assocIdentifier = $this->uow->getEntityIdentifier($assocItem);
                    if ($key->cacheMode & \MailPoetVendor\Doctrine\ORM\Cache::MODE_REFRESH || !$assocRegion->contains($entityKey = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($assocMetadata->rootEntityName, $assocIdentifier))) {
                        // Cancel put result if entity put fail
                        if (!$assocPersister->storeEntityCache($assocItem, $entityKey)) {
                            return \false;
                        }
                    }
                    $list[$assocItemIndex] = $assocIdentifier;
                }
                $data[$index]['associations'][$name] = array('targetEntity' => $assocMetadata->rootEntityName, 'type' => $assoc['type'], 'list' => $list);
            }
        }
        return $this->region->put($key, new \MailPoetVendor\Doctrine\ORM\Cache\QueryCacheEntry($data));
    }
    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this->region->evictAll();
    }
    /**
     * {@inheritdoc}
     */
    public function getRegion()
    {
        return $this->region;
    }
}
