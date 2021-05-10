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

use MailPoetVendor\Doctrine\ORM\Cache;
use MailPoetVendor\Doctrine\Common\Util\ClassUtils;
use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister;
use MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException;
/**
 * Provides an API for querying/managing the second level cache regions.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class DefaultCache implements \MailPoetVendor\Doctrine\ORM\Cache
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
     * @var \MailPoetVendor\Doctrine\ORM\Cache\CacheFactory
     */
    private $cacheFactory;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\QueryCache[]
     */
    private $queryCaches = array();
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\QueryCache
     */
    private $defaultQueryCache;
    /**
     * {@inheritdoc}
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->uow = $em->getUnitOfWork();
        $this->cacheFactory = $em->getConfiguration()->getSecondLevelCacheConfiguration()->getCacheFactory();
    }
    /**
     * {@inheritdoc}
     */
    public function getEntityCacheRegion($className)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getEntityPersister($metadata->rootEntityName);
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return null;
        }
        return $persister->getCacheRegion();
    }
    /**
     * {@inheritdoc}
     */
    public function getCollectionCacheRegion($className, $association)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getCollectionPersister($metadata->getAssociationMapping($association));
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return null;
        }
        return $persister->getCacheRegion();
    }
    /**
     * {@inheritdoc}
     */
    public function containsEntity($className, $identifier)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getEntityPersister($metadata->rootEntityName);
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return \false;
        }
        return $persister->getCacheRegion()->contains($this->buildEntityCacheKey($metadata, $identifier));
    }
    /**
     * {@inheritdoc}
     */
    public function evictEntity($className, $identifier)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getEntityPersister($metadata->rootEntityName);
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return;
        }
        $persister->getCacheRegion()->evict($this->buildEntityCacheKey($metadata, $identifier));
    }
    /**
     * {@inheritdoc}
     */
    public function evictEntityRegion($className)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getEntityPersister($metadata->rootEntityName);
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return;
        }
        $persister->getCacheRegion()->evictAll();
    }
    /**
     * {@inheritdoc}
     */
    public function evictEntityRegions()
    {
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($metadatas as $metadata) {
            $persister = $this->uow->getEntityPersister($metadata->rootEntityName);
            if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
                continue;
            }
            $persister->getCacheRegion()->evictAll();
        }
    }
    /**
     * {@inheritdoc}
     */
    public function containsCollection($className, $association, $ownerIdentifier)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getCollectionPersister($metadata->getAssociationMapping($association));
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return \false;
        }
        return $persister->getCacheRegion()->contains($this->buildCollectionCacheKey($metadata, $association, $ownerIdentifier));
    }
    /**
     * {@inheritdoc}
     */
    public function evictCollection($className, $association, $ownerIdentifier)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getCollectionPersister($metadata->getAssociationMapping($association));
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return;
        }
        $persister->getCacheRegion()->evict($this->buildCollectionCacheKey($metadata, $association, $ownerIdentifier));
    }
    /**
     * {@inheritdoc}
     */
    public function evictCollectionRegion($className, $association)
    {
        $metadata = $this->em->getClassMetadata($className);
        $persister = $this->uow->getCollectionPersister($metadata->getAssociationMapping($association));
        if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
            return;
        }
        $persister->getCacheRegion()->evictAll();
    }
    /**
     * {@inheritdoc}
     */
    public function evictCollectionRegions()
    {
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($metadatas as $metadata) {
            foreach ($metadata->associationMappings as $association) {
                if (!$association['type'] & \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::TO_MANY) {
                    continue;
                }
                $persister = $this->uow->getCollectionPersister($association);
                if (!$persister instanceof \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister) {
                    continue;
                }
                $persister->getCacheRegion()->evictAll();
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public function containsQuery($regionName)
    {
        return isset($this->queryCaches[$regionName]);
    }
    /**
     * {@inheritdoc}
     */
    public function evictQueryRegion($regionName = null)
    {
        if ($regionName === null && $this->defaultQueryCache !== null) {
            $this->defaultQueryCache->clear();
            return;
        }
        if (isset($this->queryCaches[$regionName])) {
            $this->queryCaches[$regionName]->clear();
        }
    }
    /**
     * {@inheritdoc}
     */
    public function evictQueryRegions()
    {
        $this->getQueryCache()->clear();
        foreach ($this->queryCaches as $queryCache) {
            $queryCache->clear();
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getQueryCache($regionName = null)
    {
        if ($regionName === null) {
            return $this->defaultQueryCache ?: ($this->defaultQueryCache = $this->cacheFactory->buildQueryCache($this->em));
        }
        if (!isset($this->queryCaches[$regionName])) {
            $this->queryCaches[$regionName] = $this->cacheFactory->buildQueryCache($this->em, $regionName);
        }
        return $this->queryCaches[$regionName];
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata   The entity metadata.
     * @param mixed                               $identifier The entity identifier.
     *
     * @return \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey
     */
    private function buildEntityCacheKey(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata, $identifier)
    {
        if (!\is_array($identifier)) {
            $identifier = $this->toIdentifierArray($metadata, $identifier);
        }
        return new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($metadata->rootEntityName, $identifier);
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata        The entity metadata.
     * @param string                              $association     The field name that represents the association.
     * @param mixed                               $ownerIdentifier The identifier of the owning entity.
     *
     * @return \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey
     */
    private function buildCollectionCacheKey(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata, $association, $ownerIdentifier)
    {
        if (!\is_array($ownerIdentifier)) {
            $ownerIdentifier = $this->toIdentifierArray($metadata, $ownerIdentifier);
        }
        return new \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey($metadata->rootEntityName, $association, $ownerIdentifier);
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata   The entity metadata.
     * @param mixed                               $identifier The entity identifier.
     *
     * @return array
     */
    private function toIdentifierArray(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata, $identifier)
    {
        if (\is_object($identifier) && $this->em->getMetadataFactory()->hasMetadataFor(\MailPoetVendor\Doctrine\Common\Util\ClassUtils::getClass($identifier))) {
            $identifier = $this->uow->getSingleIdentifierValue($identifier);
            if ($identifier === null) {
                throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidIdentifierBindingEntity();
            }
        }
        return array($metadata->identifier[0] => $identifier);
    }
}
