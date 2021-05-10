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
namespace MailPoetVendor\Doctrine\Common\Persistence\Event;

use MailPoetVendor\Doctrine\Common\EventArgs;
use MailPoetVendor\Doctrine\Common\Persistence\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\Common\Persistence\ObjectManager;
/**
 * Class that holds event arguments for a loadMetadata event.
 *
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @since  2.2
 */
class LoadClassMetadataEventArgs extends \MailPoetVendor\Doctrine\Common\EventArgs
{
    /**
     * @var ClassMetadata
     */
    private $classMetadata;
    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * Constructor.
     *
     * @param ClassMetadata $classMetadata
     * @param ObjectManager $objectManager
     */
    public function __construct(\MailPoetVendor\Doctrine\Common\Persistence\Mapping\ClassMetadata $classMetadata, \MailPoetVendor\Doctrine\Common\Persistence\ObjectManager $objectManager)
    {
        $this->classMetadata = $classMetadata;
        $this->objectManager = $objectManager;
    }
    /**
     * Retrieves the associated ClassMetadata.
     *
     * @return ClassMetadata
     */
    public function getClassMetadata()
    {
        return $this->classMetadata;
    }
    /**
     * Retrieves the associated ObjectManager.
     *
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }
}
