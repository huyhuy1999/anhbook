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
namespace MailPoetVendor\Doctrine\ORM\Persisters\Collection;

use MailPoetVendor\Doctrine\Common\Collections\Criteria;
use MailPoetVendor\Doctrine\Common\Proxy\Proxy;
use MailPoetVendor\Doctrine\ORM\PersistentCollection;
/**
 * Persister for one-to-many collections.
 *
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Alexander <iam.asm89@gmail.com>
 * @since   2.0
 */
class OneToManyPersister extends \MailPoetVendor\Doctrine\ORM\Persisters\Collection\AbstractCollectionPersister
{
    /**
     * {@inheritdoc}
     */
    public function delete(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        // This can never happen. One to many can only be inverse side.
        // For owning side one to many, it is required to have a join table,
        // then classifying it as a ManyToManyPersister.
        return;
    }
    /**
     * {@inheritdoc}
     */
    public function update(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        // This can never happen. One to many can only be inverse side.
        // For owning side one to many, it is required to have a join table,
        // then classifying it as a ManyToManyPersister.
        return;
    }
    /**
     * {@inheritdoc}
     */
    public function get(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $index)
    {
        $mapping = $collection->getMapping();
        if (!isset($mapping['indexBy'])) {
            throw new \BadMethodCallException("Selecting a collection by index is only supported on indexed collections.");
        }
        $persister = $this->uow->getEntityPersister($mapping['targetEntity']);
        return $persister->load(array($mapping['mappedBy'] => $collection->getOwner(), $mapping['indexBy'] => $index), null, $mapping, array(), null, 1);
    }
    /**
     * {@inheritdoc}
     */
    public function count(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        $mapping = $collection->getMapping();
        $persister = $this->uow->getEntityPersister($mapping['targetEntity']);
        // only works with single id identifier entities. Will throw an
        // exception in Entity Persisters if that is not the case for the
        // 'mappedBy' field.
        $criteria = new \MailPoetVendor\Doctrine\Common\Collections\Criteria(\MailPoetVendor\Doctrine\Common\Collections\Criteria::expr()->eq($mapping['mappedBy'], $collection->getOwner()));
        return $persister->count($criteria);
    }
    /**
     * {@inheritdoc}
     */
    public function slice(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $offset, $length = null)
    {
        $mapping = $collection->getMapping();
        $persister = $this->uow->getEntityPersister($mapping['targetEntity']);
        return $persister->getOneToManyCollection($mapping, $collection->getOwner(), $offset, $length);
    }
    /**
     * {@inheritdoc}
     */
    public function containsKey(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $key)
    {
        $mapping = $collection->getMapping();
        if (!isset($mapping['indexBy'])) {
            throw new \BadMethodCallException("Selecting a collection by index is only supported on indexed collections.");
        }
        $persister = $this->uow->getEntityPersister($mapping['targetEntity']);
        // only works with single id identifier entities. Will throw an
        // exception in Entity Persisters if that is not the case for the
        // 'mappedBy' field.
        $criteria = new \MailPoetVendor\Doctrine\Common\Collections\Criteria();
        $criteria->andWhere(\MailPoetVendor\Doctrine\Common\Collections\Criteria::expr()->eq($mapping['mappedBy'], $collection->getOwner()));
        $criteria->andWhere(\MailPoetVendor\Doctrine\Common\Collections\Criteria::expr()->eq($mapping['indexBy'], $key));
        return (bool) $persister->count($criteria);
    }
    /**
     * {@inheritdoc}
     */
    public function contains(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element)
    {
        if (!$this->isValidEntityState($element)) {
            return \false;
        }
        $mapping = $collection->getMapping();
        $persister = $this->uow->getEntityPersister($mapping['targetEntity']);
        // only works with single id identifier entities. Will throw an
        // exception in Entity Persisters if that is not the case for the
        // 'mappedBy' field.
        $criteria = new \MailPoetVendor\Doctrine\Common\Collections\Criteria(\MailPoetVendor\Doctrine\Common\Collections\Criteria::expr()->eq($mapping['mappedBy'], $collection->getOwner()));
        return $persister->exists($element, $criteria);
    }
    /**
     * {@inheritdoc}
     */
    public function removeElement(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element)
    {
        $mapping = $collection->getMapping();
        if (!$mapping['orphanRemoval']) {
            // no-op: this is not the owning side, therefore no operations should be applied
            return \false;
        }
        if (!$this->isValidEntityState($element)) {
            return \false;
        }
        return $this->uow->getEntityPersister($mapping['targetEntity'])->delete($element);
    }
    /**
     * {@inheritdoc}
     */
    public function loadCriteria(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, \MailPoetVendor\Doctrine\Common\Collections\Criteria $criteria)
    {
        throw new \BadMethodCallException("Filtering a collection by Criteria is not supported by this CollectionPersister.");
    }
}
