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
namespace MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection;

use MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister;
use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
use MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey;
use MailPoetVendor\Doctrine\ORM\Cache\ConcurrentRegion;
use MailPoetVendor\Doctrine\ORM\PersistentCollection;
/**
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 * @since 2.5
 */
class ReadWriteCachedCollectionPersister extends \MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\AbstractCollectionPersister
{
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister $persister   The collection persister that will be cached.
     * @param \MailPoetVendor\Doctrine\ORM\Cache\ConcurrentRegion                    $region      The collection region.
     * @param \MailPoetVendor\Doctrine\ORM\EntityManagerInterface                    $em          The entity manager.
     * @param array                                                   $association The association mapping.
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister $persister, \MailPoetVendor\Doctrine\ORM\Cache\ConcurrentRegion $region, \MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, array $association)
    {
        parent::__construct($persister, $region, $em, $association);
    }
    /**
     * {@inheritdoc}
     */
    public function afterTransactionComplete()
    {
        if (isset($this->queuedCache['update'])) {
            foreach ($this->queuedCache['update'] as $item) {
                $this->region->evict($item['key']);
            }
        }
        if (isset($this->queuedCache['delete'])) {
            foreach ($this->queuedCache['delete'] as $item) {
                $this->region->evict($item['key']);
            }
        }
        $this->queuedCache = array();
    }
    /**
     * {@inheritdoc}
     */
    public function afterTransactionRolledBack()
    {
        if (isset($this->queuedCache['update'])) {
            foreach ($this->queuedCache['update'] as $item) {
                $this->region->evict($item['key']);
            }
        }
        if (isset($this->queuedCache['delete'])) {
            foreach ($this->queuedCache['delete'] as $item) {
                $this->region->evict($item['key']);
            }
        }
        $this->queuedCache = array();
    }
    /**
     * {@inheritdoc}
     */
    public function delete(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        $ownerId = $this->uow->getEntityIdentifier($collection->getOwner());
        $key = new \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey($this->sourceEntity->rootEntityName, $this->association['fieldName'], $ownerId);
        $lock = $this->region->lock($key);
        $this->persister->delete($collection);
        if ($lock === null) {
            return;
        }
        $this->queuedCache['delete'][\spl_object_hash($collection)] = array('key' => $key, 'lock' => $lock);
    }
    /**
     * {@inheritdoc}
     */
    public function update(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        $isInitialized = $collection->isInitialized();
        $isDirty = $collection->isDirty();
        if (!$isInitialized && !$isDirty) {
            return;
        }
        $this->persister->update($collection);
        $ownerId = $this->uow->getEntityIdentifier($collection->getOwner());
        $key = new \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey($this->sourceEntity->rootEntityName, $this->association['fieldName'], $ownerId);
        $lock = $this->region->lock($key);
        if ($lock === null) {
            return;
        }
        $this->queuedCache['update'][\spl_object_hash($collection)] = array('key' => $key, 'lock' => $lock);
    }
}
