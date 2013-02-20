<?php

require_once dirname(dirname(dirname(__FILE__))). '/src/wordpress/splurgy-lib/SplurgyAdUnitGenerator.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SplurgyAdUnitGenerator
 *
 * @author dmak
 */
class SplurgyAdUnitGeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $ad_unit;


    protected function setUp()
    {
        $path = dirname(dirname(dirname(__FILE__))). '/src/wordpress/splurgy-lib/embed-templates/';
        $this->ad_unit = new SplurgyAdUnitGenerator("token", "dimension");
    }

    public function testGetHtml()
    {
        $html = $this->ad_unit->getHtml();
        $template = '<!-- start splurgy ad code --> '
            . "\n"
            . '<script type="text/javascript" src="https://zen.visit.io/ad-2.js?_sply_=hook&token=token&dimension=dimension"></script>'
            . "\n"
            . '<!-- end splurgy ad code -->';

        $this->assertEquals($template, $html);
    }

}

?>
