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
namespace MailPoetVendor\Doctrine\Common\Collections;

use MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison;
use MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression;
use MailPoetVendor\Doctrine\Common\Collections\Expr\Value;
/**
 * Builder for Expressions in the {@link Selectable} interface.
 *
 * Important Notice for interoperable code: You have to use scalar
 * values only for comparisons, otherwise the behavior of the comparison
 * may be different between implementations (Array vs ORM vs ODM).
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @since  2.3
 */
class ExpressionBuilder
{
    /**
     * @param mixed $x
     *
     * @return CompositeExpression
     */
    public function andX($x = null)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_AND, \func_get_args());
    }
    /**
     * @param mixed $x
     *
     * @return CompositeExpression
     */
    public function orX($x = null)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_OR, \func_get_args());
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function eq($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::EQ, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function gt($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::GT, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function lt($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::LT, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function gte($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::GTE, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function lte($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::LTE, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function neq($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NEQ, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     *
     * @return Comparison
     */
    public function isNull($field)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::EQ, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value(null));
    }
    /**
     * @param string $field
     * @param mixed  $values
     *
     * @return Comparison
     */
    public function in($field, array $values)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::IN, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($values));
    }
    /**
     * @param string $field
     * @param mixed  $values
     *
     * @return Comparison
     */
    public function notIn($field, array $values)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NIN, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($values));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function contains($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::CONTAINS, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function memberOf($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::MEMBER_OF, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function startsWith($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::STARTS_WITH, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return Comparison
     */
    public function endsWith($field, $value)
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison($field, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::ENDS_WITH, new \MailPoetVendor\Doctrine\Common\Collections\Expr\Value($value));
    }
}
