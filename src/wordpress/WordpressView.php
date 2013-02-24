<?php

/**
 * All functions for hooks and will output HTML should go here.
 * Wordpress is so dirty, we have to echo!
 *
 * PHP version 5.3.1
 *
 * @category WordPressView
 * @package  PackageName
 * @author   Splurgy <support@splurgy.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     http://www.splurgy.com Splurgy
 */
require_once 'V4Embeds.php';
require_once 'splurgy-lib/TemplateGenerator.php';

/**
 * WordPress View Class definition
 *
 * @category WordPressView
 * @package  PackageName
 * @author   Splurgy <support@splurgy.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     http://www.splurgy.com Splurgy
 */
class WordpressView
{
    
    private $_templateGenerator;
    private $_path;
    private $_wpSettingsView;
    private $_V4Embeds;

    /**
     * Wordpress View construct function
     */
    public function __construct()
    {
        $this->_V4Embeds = new V4Embeds();
        $this->_wpSettingsView = new WordPressSettingsView();
        $this->_templateGenerator = new TemplateGenerator();
        $this->_path = dirname(__FILE__). '/view-templates/';
        $this->_templateGenerator->setPath($this->_path);
    }




    /**
     * LEAVE THIS HERE FOR BACKWARD SUPPORT
     * Short Code Function that makes the splurgy offer available via short code
     *
     * @param type $atts Attributes OfferId and TestMode for the Shortcode
     *
     * @return type the do_shortcode content i.e. the deal from Splurgy
     */

    public function splurgyShortCode($atts)
    {
        extract(
            shortcode_atts(
                array(
                    'offerid' => null,
                    'testmode' => false,
                ),
                $atts
            )
        );

        $token = get_option('splurgyToken');

        return do_shortcode(
            $this->_V4Embeds->coupon($token)
        );
    }

    /**
     * Main Function that will display the offer/content-lock on the Page / Post
     *
     * @param type $content The content
     *
     * @return type None
     */

    public function offer($content)
    {
        /* you will have to get the token for this page if specified */
        $token = get_option('splurgyToken');

        echo do_shortcode($content);
        $sOfferPowerSwState = get_post_custom_values('SplurgyOfferPowerSwitch');
        if ('off' != $sOfferPowerSwState[0] && !is_null($sOfferPowerSwState[0])) {
            if (!is_page() && is_single()) {
                echo $this->_V4Embeds->coupon($token);
            } elseif (is_page()) {
                echo $this->_V4Embeds->pagelock($token);                   
            }
        }
    }

    /**
     * Save Offers Meta Box Data on Posts
     *
     * @param type $post_id Id of the Post
     *
     * @return type None
     */
    public function savePostMetaBoxOfferData($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /*
         * Verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times
         */

        $authCheckBeforeSave = wp_verify_nonce(
            $_POST['splurgyOfferNonce'], plugin_basename(__FILE__)
        );

        /** Check permissions **/
        if ( !$authCheckBeforeSave && !current_user_can('edit_post', $post_id)) {
            return;
        }

        $this->_insertPowerSwitch($post_id, $_POST['offerPowerSwitch']);
        $this->_insertTestMode($post_id, $_POST['testmode']);
        $this->_insertPageLock($post_id, $_POST['pagelocktext']);
        $this->_insertOfferId($post_id, $_POST['offerId']);
    }

    /**
     * Inserts power switch data into database
     *
     * @param type $post_id           Post ID
     * @param type $offerPowerSwState Post Data from Page save
     *
     * @return type None
     */

    private function _insertPowerSwitch($post_id, $offerPowerSwState)
    {

        if (!is_null($offerPowerSwState)) {
            $offerPowerSwState = 'on';
        } else {
            $offerPowerSwState = 'off';
        }

        add_post_meta(
            $post_id, 'SplurgyOfferPowerSwitch', $offerPowerSwState, true
        ) or update_post_meta(
            $post_id, 'SplurgyOfferPowerSwitch', $offerPowerSwState
        );
    }


    /**
     * Inserts test mode data into database
     *
     * @param type $post_id  Post ID
     * @param type $testMode Post Data from Page save
     *
     * @return type None
     */

    private function _insertTestMode($post_id, $testMode)
    {
        switch($testMode) {
        case 'on':
            $testMode = 'true';
            break;
        default:
            $testMode = 'false';
            break;
        }
        add_post_meta($post_id, 'TestMode', $testMode, true) or
            update_post_meta($post_id, 'TestMode', $testMode);

    }

    /**
     * Inserts unlock text data into database
     *
     * @param type $post_id    Post ID
     * @param type $unlocktext Post Data from Page save
     *
     * @return type None
     */

    private function _insertPageLock($post_id, $unlocktext)
    {
        if (!empty($unlocktext)) {
            add_post_meta($post_id, 'unlocktext', $unlocktext, true) or
                update_post_meta($post_id, 'unlocktext', $unlocktext);
        }

    }

    /**
     * Inserts offer id data into database
     *
     * @param type $post_id Post ID
     * @param type $offerId Post Data from Page save
     *
     * @return type None
     */

    private function _insertOfferId($post_id, $offerId)
    {

        if ( 0 < intval(trim($offerId)) ) {
            add_post_meta($post_id, 'SplurgyOfferId', $offerId, true) or
                update_post_meta($post_id, 'SplurgyOfferId', $offerId);
        }
    }



    /**
     * Add Buttons On Init
     *
     * @return type None
     */

    public function addButtonsOnInit()
    {
        add_filter('mce_buttons', array($this, 'addButtonToPost'));
    }

}

?>
