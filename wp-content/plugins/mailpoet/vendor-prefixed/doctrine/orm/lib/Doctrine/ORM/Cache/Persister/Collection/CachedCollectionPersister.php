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

use MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister;
use MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister;
use MailPoetVendor\Doctrine\ORM\PersistentCollection;
/**
 * Interface for second level cache collection persisters.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 * @since 2.5
 */
interface CachedCollectionPersister extends \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister, \MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister
{
    /**
     * @return \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getSourceEntityMetadata();
    /**
     * @return \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getTargetEntityMetadata();
    /**
     * Loads a collection from cache
     *
     * @param \MailPoetVendor\Doctrine\ORM\PersistentCollection     $collection
     * @param \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key
     *
     * @return \MailPoetVendor\Doctrine\ORM\PersistentCollection|null
     */
    public function loadCollectionCache(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key);
    /**
     * Stores a collection into cache
     *
     * @param \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey        $key
     * @param array|\Doctrine\Common\Collections\Collection $elements
     *
     * @return void
     */
    public function storeCollectionCache(\MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key, $elements);
}
