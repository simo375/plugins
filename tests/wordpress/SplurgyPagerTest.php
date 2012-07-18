<?php

require_once dirname(dirname(dirname(__FILE__))). '/src/wordpress/splurgy-lib/SplurgyPager.php';

class SplurgyPagerTest extends PHPUnit_Framework_TestCase
{


    protected $object;

    protected function setUp()
    {
        $this->object = new SplurgyPager;
    }

    protected function tearDown()
    {

    }

    public function testGetOffersShouldReturnArray()
    {
        $array = $this->object->getOffers();
        $this->assertTrue(is_array($array));
    }

}

?>
