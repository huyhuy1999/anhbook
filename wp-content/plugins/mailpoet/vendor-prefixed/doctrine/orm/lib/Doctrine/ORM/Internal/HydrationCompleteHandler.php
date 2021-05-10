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
namespace MailPoetVendor\Doctrine\ORM\Internal;

use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
use MailPoetVendor\Doctrine\ORM\Event\LifecycleEventArgs;
use MailPoetVendor\Doctrine\ORM\Event\ListenersInvoker;
use MailPoetVendor\Doctrine\ORM\Events;
use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
/**
 * Class, which can handle completion of hydration cycle and produce some of tasks.
 * In current implementation triggers deferred postLoad event.
 *
 * @author Artur Eshenbrener <strate@yandex.ru>
 * @since 2.5
 */
final class HydrationCompleteHandler
{
    /**
     * @var ListenersInvoker
     */
    private $listenersInvoker;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var array[]
     */
    private $deferredPostLoadInvocations = array();
    /**
     * Constructor for this object
     *
     * @param ListenersInvoker $listenersInvoker
     * @param EntityManagerInterface $em
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\Event\ListenersInvoker $listenersInvoker, \MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->listenersInvoker = $listenersInvoker;
        $this->em = $em;
    }
    /**
     * Method schedules invoking of postLoad entity to the very end of current hydration cycle.
     *
     * @param ClassMetadata $class
     * @param object        $entity
     */
    public function deferPostLoadInvoking(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, $entity)
    {
        $invoke = $this->listenersInvoker->getSubscribedSystems($class, \MailPoetVendor\Doctrine\ORM\Events::postLoad);
        if ($invoke === \MailPoetVendor\Doctrine\ORM\Event\ListenersInvoker::INVOKE_NONE) {
            return;
        }
        $this->deferredPostLoadInvocations[] = array($class, $invoke, $entity);
    }
    /**
     * This method should me called after any hydration cycle completed.
     *
     * Method fires all deferred invocations of postLoad events
     */
    public function hydrationComplete()
    {
        $toInvoke = $this->deferredPostLoadInvocations;
        $this->deferredPostLoadInvocations = array();
        foreach ($toInvoke as $classAndEntity) {
            list($class, $invoke, $entity) = $classAndEntity;
            $this->listenersInvoker->invoke($class, \MailPoetVendor\Doctrine\ORM\Events::postLoad, $entity, new \MailPoetVendor\Doctrine\ORM\Event\LifecycleEventArgs($entity, $this->em), $invoke);
        }
    }
}
