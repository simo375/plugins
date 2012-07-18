<?php

require_once dirname(dirname(dirname(__FILE__))). '/src/wordpress/splurgy-lib/SplurgyEmbedGenerator.php';

class SplurgyEmbedGeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $callingOffers;
    protected $callingAnalytics;
    protected $token;
    protected $offerId;

    protected function setUp()
    {
        $this->offerId = 'offerID';
        $this->token='1234token4321';
        $this->callingAnalytics = new SplurgyEmbedGenerator(
                    $this->token, 'analytics', null
                );
        $this->callingOffers = new SplurgyEmbedGenerator(
                    $this->token, 'offers', $this->offerId
                );

    }

    protected function tearDown()
    {

    }

    public function testGetTemplateWhenAnalyticsIsCalled()
    {
        $this->assertTrue(
            is_string($this->callingAnalytics->getTemplate())
        );
    }

    public function testGetTemplateShouldReturnTemplate()
    {
        $this->assertTrue(
            is_string($this->callingOffers->getTemplate())
            );
    }

    public function testGetTemplateShouldReturnDefaultTemplate()
    {
        $generator = new SplurgyEmbedGenerator(
            $this->token
        );
        $this->assertTrue(
            is_string($generator->getTemplate())
        );
    }

    public function testExceptionNoSuchTemplate() {
        $generator = new SplurgyEmbedGenerator(
            $this->token, 'notemplate', null
        );
        try {
            $generator->getTemplate();
        } catch(Exception $expected) {
            return;
        }
        $this->fail("Exception has not been raised");
    }

}

?>
