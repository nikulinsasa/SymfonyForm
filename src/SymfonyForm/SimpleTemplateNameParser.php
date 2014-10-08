<?php

namespace SymfonyForm;

use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\TemplateReference;

class SimpleTemplateNameParser implements TemplateNameParserInterface
{
    private $root;
 
    public function __construct($root)
    {
        $this->root = $root;
    }
 
    public function parse($name)
    {
        if (false !== strpos($name, ':')) {
            $path = str_replace(':', '/', $name);
        } else {
            $path = $this->root . '/' . $name;
        }
 
        return new TemplateReference($path, 'php');
    }

}