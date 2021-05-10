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
namespace MailPoetVendor\Doctrine\Common\Collections\Expr;

/**
 * Walks an expression graph and turns it into a PHP closure.
 *
 * This closure can be used with {@Collection#filter()} and is used internally
 * by {@ArrayCollection#select()}.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @since  2.3
 */
class ClosureExpressionVisitor extends \MailPoetVendor\Doctrine\Common\Collections\Expr\ExpressionVisitor
{
    /**
     * Accesses the field of a given object. This field has to be public
     * directly or indirectly (through an accessor get*, is*, or a magic
     * method, __get, __call).
     *
     * @param object $object
     * @param string $field
     *
     * @return mixed
     */
    public static function getObjectFieldValue($object, $field)
    {
        if (\is_array($object)) {
            return $object[$field];
        }
        $accessors = array('get', 'is');
        foreach ($accessors as $accessor) {
            $accessor .= $field;
            if (!\method_exists($object, $accessor)) {
                continue;
            }
            return $object->{$accessor}();
        }
        // __call should be triggered for get.
        $accessor = $accessors[0] . $field;
        if (\method_exists($object, '__call')) {
            return $object->{$accessor}();
        }
        if ($object instanceof \ArrayAccess) {
            return $object[$field];
        }
        if (isset($object->{$field})) {
            return $object->{$field};
        }
        // camelcase field name to support different variable naming conventions
        $ccField = \preg_replace_callback('/_(.?)/', function ($matches) {
            return \strtoupper($matches[1]);
        }, $field);
        foreach ($accessors as $accessor) {
            $accessor .= $ccField;
            if (!\method_exists($object, $accessor)) {
                continue;
            }
            return $object->{$accessor}();
        }
        return $object->{$field};
    }
    /**
     * Helper for sorting arrays of objects based on multiple fields + orientations.
     *
     * @param string   $name
     * @param int      $orientation
     * @param \Closure $next
     *
     * @return \Closure
     */
    public static function sortByField($name, $orientation = 1, \Closure $next = null)
    {
        if (!$next) {
            $next = function () {
                return 0;
            };
        }
        return function ($a, $b) use($name, $next, $orientation) {
            $aValue = \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($a, $name);
            $bValue = \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($b, $name);
            if ($aValue === $bValue) {
                return $next($a, $b);
            }
            return ($aValue > $bValue ? 1 : -1) * $orientation;
        };
    }
    /**
     * {@inheritDoc}
     */
    public function walkComparison(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison)
    {
        $field = $comparison->getField();
        $value = $comparison->getValue()->getValue();
        // shortcut for walkValue()
        switch ($comparison->getOperator()) {
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::EQ:
                return function ($object) use($field, $value) {
                    return \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field) === $value;
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NEQ:
                return function ($object) use($field, $value) {
                    return \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field) !== $value;
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::LT:
                return function ($object) use($field, $value) {
                    return \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field) < $value;
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::LTE:
                return function ($object) use($field, $value) {
                    return \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field) <= $value;
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::GT:
                return function ($object) use($field, $value) {
                    return \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field) > $value;
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::GTE:
                return function ($object) use($field, $value) {
                    return \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field) >= $value;
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::IN:
                return function ($object) use($field, $value) {
                    return \in_array(\MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field), $value);
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NIN:
                return function ($object) use($field, $value) {
                    return !\in_array(\MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field), $value);
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::CONTAINS:
                return function ($object) use($field, $value) {
                    return \false !== \strpos(\MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field), $value);
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::MEMBER_OF:
                return function ($object) use($field, $value) {
                    $fieldValues = \MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field);
                    if (!\is_array($fieldValues)) {
                        $fieldValues = \iterator_to_array($fieldValues);
                    }
                    return \in_array($value, $fieldValues);
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::STARTS_WITH:
                return function ($object) use($field, $value) {
                    return 0 === \strpos(\MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field), $value);
                };
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::ENDS_WITH:
                return function ($object) use($field, $value) {
                    return $value === \substr(\MailPoetVendor\Doctrine\Common\Collections\Expr\ClosureExpressionVisitor::getObjectFieldValue($object, $field), -\strlen($value));
                };
            default:
                throw new \RuntimeException("Unknown comparison operator: " . $comparison->getOperator());
        }
    }
    /**
     * {@inheritDoc}
     */
    public function walkValue(\MailPoetVendor\Doctrine\Common\Collections\Expr\Value $value)
    {
        return $value->getValue();
    }
    /**
     * {@inheritDoc}
     */
    public function walkCompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression $expr)
    {
        $expressionList = array();
        foreach ($expr->getExpressionList() as $child) {
            $expressionList[] = $this->dispatch($child);
        }
        switch ($expr->getType()) {
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_AND:
                return $this->andExpressions($expressionList);
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_OR:
                return $this->orExpressions($expressionList);
            default:
                throw new \RuntimeException("Unknown composite " . $expr->getType());
        }
    }
    /**
     * @param array $expressions
     *
     * @return callable
     */
    private function andExpressions($expressions)
    {
        return function ($object) use($expressions) {
            foreach ($expressions as $expression) {
                if (!$expression($object)) {
                    return \false;
                }
            }
            return \true;
        };
    }
    /**
     * @param array $expressions
     *
     * @return callable
     */
    private function orExpressions($expressions)
    {
        return function ($object) use($expressions) {
            foreach ($expressions as $expression) {
                if ($expression($object)) {
                    return \true;
                }
            }
            return \false;
        };
    }
}
