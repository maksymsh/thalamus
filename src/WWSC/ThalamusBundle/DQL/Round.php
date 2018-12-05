<?php

namespace WWSC\ThalamusBundle\DQL;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class Round extends FunctionNode
{
    protected $roundExp;
    protected $roundPrecission;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'ROUND('.
            $sqlWalker->walkArithmeticExpression($this->roundExp).','.
            $sqlWalker->walkArithmeticExpression($this->roundPrecission)
        .')';
    }

    /**
     * parse - allows DQL to breakdown the DQL string into a processable structure.
     *
     * @param \Doctrine\ORM\Query\Parser $parser
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->roundExp = $parser->ArithmeticExpression(); // Указываем первое значение функции
        $parser->match(Lexer::T_COMMA); // Добавим разделитель
        $this->roundPrecission = $parser->ArithmeticExpression(); // И добавим второе значение

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}