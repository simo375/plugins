<?php

/*
 * This class will generated different types of Embeds with factory method
 */

require_once 'SplurgyEmbedGenerator.php';
require_once 'Exceptions.php';

class SplurgyEmbed
{

    private $_file;

    public function __construct() {
        $this->_file = dirname(__FILE__) . '/token.config';
        // Create a token.config file
        $this->createTokenConfig();
    }

    private function createTokenConfig() {
        if(!file_exists($this->_file)) {
             file_put_contents($this->_file,'');
        }
    }


    public function setToken($token) {
        $token = preg_replace('/[^a-zA-Z0-9_]*/', '', $token);
        $token = str_replace(' ', '', $token);
        if(empty($token)) {
            throw new TokenErrorException("Your token cannot be empty");
        }

        if(!preg_match('/^c_[a-zA-Z0-9]{40}$/', $token)) {
            throw new TokenErrorException("Your token is incorrect! Make sure you copied it correctly with no spaces!");
        }
        file_put_contents($this->_file, $token);

    }

    public function getToken() {
        if(file_exists($this->_file)) {
            $token = file_get_contents($this->_file);
        }
        return $token;
    }

    public function deleteToken(){
        file_put_contents($this->_file,'');
    }


    /*
     * Examples of templates,
     * mobile
     * offers
     * analytics
     * small
     * big
     * etc...
     *
     *
     */
    public function getEmbed($templateName=null, $offerId=null) {
         return new SplurgyEmbedGenerator(
                    $this->getToken(),
                    $templateName,
                    $offerId
                );
    }




}

?>
