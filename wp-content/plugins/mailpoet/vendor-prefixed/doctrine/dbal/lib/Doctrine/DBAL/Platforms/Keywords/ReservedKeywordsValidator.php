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
namespace MailPoetVendor\Doctrine\DBAL\Platforms\Keywords;

use MailPoetVendor\Doctrine\DBAL\Schema\Visitor\Visitor;
use MailPoetVendor\Doctrine\DBAL\Schema\Table;
use MailPoetVendor\Doctrine\DBAL\Schema\Column;
use MailPoetVendor\Doctrine\DBAL\Schema\ForeignKeyConstraint;
use MailPoetVendor\Doctrine\DBAL\Schema\Schema;
use MailPoetVendor\Doctrine\DBAL\Schema\Sequence;
use MailPoetVendor\Doctrine\DBAL\Schema\Index;
class ReservedKeywordsValidator implements \MailPoetVendor\Doctrine\DBAL\Schema\Visitor\Visitor
{
    /**
     * @var KeywordList[]
     */
    private $keywordLists = array();
    /**
     * @var array
     */
    private $violations = array();
    /**
     * @param \MailPoetVendor\Doctrine\DBAL\Platforms\Keywords\KeywordList[] $keywordLists
     */
    public function __construct(array $keywordLists)
    {
        $this->keywordLists = $keywordLists;
    }
    /**
     * @return array
     */
    public function getViolations()
    {
        return $this->violations;
    }
    /**
     * @param string $word
     *
     * @return array
     */
    private function isReservedWord($word)
    {
        if ($word[0] == "`") {
            $word = \str_replace('`', '', $word);
        }
        $keywordLists = array();
        foreach ($this->keywordLists as $keywordList) {
            if ($keywordList->isKeyword($word)) {
                $keywordLists[] = $keywordList->getName();
            }
        }
        return $keywordLists;
    }
    /**
     * @param string $asset
     * @param array  $violatedPlatforms
     *
     * @return void
     */
    private function addViolation($asset, $violatedPlatforms)
    {
        if (!$violatedPlatforms) {
            return;
        }
        $this->violations[] = $asset . ' keyword violations: ' . \implode(', ', $violatedPlatforms);
    }
    /**
     * {@inheritdoc}
     */
    public function acceptColumn(\MailPoetVendor\Doctrine\DBAL\Schema\Table $table, \MailPoetVendor\Doctrine\DBAL\Schema\Column $column)
    {
        $this->addViolation('Table ' . $table->getName() . ' column ' . $column->getName(), $this->isReservedWord($column->getName()));
    }
    /**
     * {@inheritdoc}
     */
    public function acceptForeignKey(\MailPoetVendor\Doctrine\DBAL\Schema\Table $localTable, \MailPoetVendor\Doctrine\DBAL\Schema\ForeignKeyConstraint $fkConstraint)
    {
    }
    /**
     * {@inheritdoc}
     */
    public function acceptIndex(\MailPoetVendor\Doctrine\DBAL\Schema\Table $table, \MailPoetVendor\Doctrine\DBAL\Schema\Index $index)
    {
    }
    /**
     * {@inheritdoc}
     */
    public function acceptSchema(\MailPoetVendor\Doctrine\DBAL\Schema\Schema $schema)
    {
    }
    /**
     * {@inheritdoc}
     */
    public function acceptSequence(\MailPoetVendor\Doctrine\DBAL\Schema\Sequence $sequence)
    {
    }
    /**
     * {@inheritdoc}
     */
    public function acceptTable(\MailPoetVendor\Doctrine\DBAL\Schema\Table $table)
    {
        $this->addViolation('Table ' . $table->getName(), $this->isReservedWord($table->getName()));
    }
}
