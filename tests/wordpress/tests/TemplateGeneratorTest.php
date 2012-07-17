<?php

require_once dirname(dirname(__FILE__)). '/splurgy-lib/TemplateGenerator.php';

class TemplateGeneratorTest extends PHPUnit_Framework_TestCase
{

    protected $templateGenerator;

    protected function setUp()
    {
        $path = dirname(dirname(__FILE__)). '/splurgy-lib/embed-templates/';
        $this->templateGenerator = new TemplateGenerator('analytics', $path);
    }

    public function testGetTemplate()
    {

        $template = $this->templateGenerator->getTemplate();
        $this->assertTrue(is_string($template));

    }

}

?>
