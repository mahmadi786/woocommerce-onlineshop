<?php
 namespace MailPoetVendor\Twig\TokenParser; if (!defined('ABSPATH')) exit; use MailPoetVendor\Twig\Error\SyntaxError; use MailPoetVendor\Twig\Node\BodyNode; use MailPoetVendor\Twig\Node\MacroNode; use MailPoetVendor\Twig\Node\Node; use MailPoetVendor\Twig\Token; final class MacroTokenParser extends \MailPoetVendor\Twig\TokenParser\AbstractTokenParser { public function parse(\MailPoetVendor\Twig\Token $token) { $lineno = $token->getLine(); $stream = $this->parser->getStream(); $name = $stream->expect( 5 )->getValue(); $arguments = $this->parser->getExpressionParser()->parseArguments(\true, \true); $stream->expect( 3 ); $this->parser->pushLocalScope(); $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true); if ($token = $stream->nextIf( 5 )) { $value = $token->getValue(); if ($value != $name) { throw new \MailPoetVendor\Twig\Error\SyntaxError(\sprintf('Expected endmacro for macro "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext()); } } $this->parser->popLocalScope(); $stream->expect( 3 ); $this->parser->setMacro($name, new \MailPoetVendor\Twig\Node\MacroNode($name, new \MailPoetVendor\Twig\Node\BodyNode([$body]), $arguments, $lineno, $this->getTag())); return new \MailPoetVendor\Twig\Node\Node(); } public function decideBlockEnd(\MailPoetVendor\Twig\Token $token) { return $token->test('endmacro'); } public function getTag() { return 'macro'; } } \class_alias('MailPoetVendor\\Twig\\TokenParser\\MacroTokenParser', 'MailPoetVendor\\Twig_TokenParser_Macro'); 