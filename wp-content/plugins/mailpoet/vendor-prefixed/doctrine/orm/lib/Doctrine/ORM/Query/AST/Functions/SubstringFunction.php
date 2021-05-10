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
namespace MailPoetVendor\Doctrine\ORM\Query\AST\Functions;

use MailPoetVendor\Doctrine\ORM\Query\Lexer;
/**
 * "SUBSTRING" "(" StringPrimary "," SimpleArithmeticExpression "," SimpleArithmeticExpression ")"
 *
 * 
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 */
class SubstringFunction extends \MailPoetVendor\Doctrine\ORM\Query\AST\Functions\FunctionNode
{
    public $stringPrimary;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Query\AST\SimpleArithmeticExpression
     */
    public $firstSimpleArithmeticExpression;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Query\AST\SimpleArithmeticExpression|null
     */
    public $secondSimpleArithmeticExpression = null;
    /**
     * @override
     */
    public function getSql(\MailPoetVendor\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $optionalSecondSimpleArithmeticExpression = null;
        if ($this->secondSimpleArithmeticExpression !== null) {
            $optionalSecondSimpleArithmeticExpression = $sqlWalker->walkSimpleArithmeticExpression($this->secondSimpleArithmeticExpression);
        }
        return $sqlWalker->getConnection()->getDatabasePlatform()->getSubstringExpression($sqlWalker->walkStringPrimary($this->stringPrimary), $sqlWalker->walkSimpleArithmeticExpression($this->firstSimpleArithmeticExpression), $optionalSecondSimpleArithmeticExpression);
    }
    /**
     * @override
     */
    public function parse(\MailPoetVendor\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(\MailPoetVendor\Doctrine\ORM\Query\Lexer::T_IDENTIFIER);
        $parser->match(\MailPoetVendor\Doctrine\ORM\Query\Lexer::T_OPEN_PARENTHESIS);
        $this->stringPrimary = $parser->StringPrimary();
        $parser->match(\MailPoetVendor\Doctrine\ORM\Query\Lexer::T_COMMA);
        $this->firstSimpleArithmeticExpression = $parser->SimpleArithmeticExpression();
        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(\MailPoetVendor\Doctrine\ORM\Query\Lexer::T_COMMA)) {
            $parser->match(\MailPoetVendor\Doctrine\ORM\Query\Lexer::T_COMMA);
            $this->secondSimpleArithmeticExpression = $parser->SimpleArithmeticExpression();
        }
        $parser->match(\MailPoetVendor\Doctrine\ORM\Query\Lexer::T_CLOSE_PARENTHESIS);
    }
}
