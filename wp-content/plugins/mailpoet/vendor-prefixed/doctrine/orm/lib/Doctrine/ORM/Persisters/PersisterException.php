<?php

namespace MailPoetVendor\Doctrine\ORM\Persisters;

use MailPoetVendor\Doctrine\ORM\ORMException;
class PersisterException extends \MailPoetVendor\Doctrine\ORM\ORMException
{
    /**
     * @return PersisterException
     */
    public static function matchingAssocationFieldRequiresObject($class, $associationName)
    {
        return new self(\sprintf("Cannot match on %s::%s with a non-object value. Matching objects by id is " . "not compatible with matching on an in-memory collection, which compares objects by reference.", $class, $associationName));
    }
}
