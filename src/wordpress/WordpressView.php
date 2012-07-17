<?php

/*
 * All functions for hooks and will output HTML should go here
 * Wordpress is so dirty, we have to echo!
 */
require_once 'splurgy-lib/SplurgyPager.php';
require_once 'splurgy-lib/SplurgyEmbed.php';
require_once 'splurgy-lib/TemplateGenerator.php';


class WordpressView
{

    private $_offerCount = 0;
    private $_splurgyPager;
    private $_splurgyEmbed;
    private $_templateGenerator;
    private $_path;
    private $_messages = array();

    public function __construct()
    {
        $this->_splurgyPager = new SplurgyPager();
        $this->_splurgyEmbed = new SplurgyEmbed();
        $this->_templateGenerator = new TemplateGenerator();
        $this->_path = dirname(__FILE__). '/wordpress-view/';
        $this->_templateGenerator->setPath($this->_path);
    }

    public function setWordPressMessage($message, $error=false) {
        if($error===true){
            $this->_messages[] = '<div id="message" class="error"><p>'.$message.'</p></div>';
        }else{
            $this->_messages[] = '<div id="message" class="updated"><p>'.$message.'</p></div>';
        }
    }

    public function showWordPressMessage() {
        foreach($this->_messages as $message) {
            echo $message;
        }
        $this->_message = null;
    }


    public function missingTokenNotice()
    {
        $file = file_get_contents(dirname(__FILE__) . '/splurgy-lib/token.config');
        if (is_admin() && empty($file)) {
            $url = admin_url('admin.php?page=settings');
            $this->setWordPressMessage("<b>Splurgy Offers</b> To use this plugin, please configure your <a href='$url'>settings</a>", true);
        }
    }


    public function postMetaBoxOfferList()
    {
        // Use nonce for verification
        wp_nonce_field( plugin_basename( __FILE__ ), 'splurgyOfferNonce' );

        $splurgyOfferPowerSwitchState = get_post_custom_values('SplurgyOfferPowerSwitch');
        $splurgyOfferId = get_post_custom_values('SplurgyOfferId');

        $checked = '';
        $showOfferId = 'style="display: none;"';
        $currentOfferId = '';

        if('on' == $splurgyOfferPowerSwitchState[0]) {
            $checked = "checked='checked'";
            $showOfferId = "style='display: inline;'";
        }

        if(!empty($splurgyOfferId)) {
            $offerId = $splurgyOfferId[0];
            $currentOfferId =  "Current showing offer #: <b>" .$offerId. "</b>";
        }

        $this->_templateGenerator->setTemplateName('postMetaBoxOfferList');
        $this->_templateGenerator->setPatterns(array('{$checked}', '{$showOfferId}', '{$currentOfferId}'));
        $this->_templateGenerator->setReplacements(array($checked, $showOfferId, $currentOfferId));
        echo $this->_templateGenerator->getTemplate();
    }


    public function settingsPage()
    {
        $token = $this->_splurgyEmbed->getToken();
        $this->settingsPageView($token);
    }

    public function settingsPageView($token) {
        echo "<h2>Settings</h2>";

        if(!empty($token)) {
            echo "Your current token is <b>$token</b><br/>";
            echo "You now have options to add offers when adding a new post!<br/>";
        } else {
            echo "Your token is not setup right now<br/><br/>";

        }

        echo "<form name='input' method='post' id='token-form'>";
        echo "<input type='text' placeholder='Type your token' name='token' />";
        if(!empty($token)){
            $value = 'update';
        } else {
            $value = 'Add';
        }
        echo "<input type='submit'  class='ask-custom' value='$value' />";
        echo "<div id='settingPageTooltip'><a id='settingPageTooltip' >Where is my token?</a></div>";
        echo "</form>";
        if(!empty($token)){
            echo "<div id='settings-preview'><h2>Preview:</h2>";
            echo $this->_splurgyEmbed->getEmbed('settings-preview')->getTemplate();
            echo "</div>";
            echo "<form name='delete' method='post'><br/></br/>";
            echo "<h2>Delete your channel token</h2>";
            echo "<input type='hidden' name='delete' value='true' />";
            echo "<input type='submit' value='Reset' />";
            echo "</form>";
        }
    }

    public function settingsPagePostHandler()
    {
        if (isset($_POST['token'])) {
            try {
                $this->_splurgyEmbed->setToken($_POST['token']);
                $this->setWordPressMessage('Successfully saved token!');
            } catch (Exception $e) {
                $this->setWordPressMessage($e->getMessage() , true);
            }

        } elseif (isset($_POST['delete']) && $_POST['delete']==true) {
            $this->_splurgyEmbed->deleteToken();
        }
    }

    public function analyticsPage()
    {
        echo "<h2>Analytics</h2>";
        echo '<img src="' . plugins_url('images/analytics.png', __FILE__) . '" >';
        echo "<br/>";
        echo "<br/>";
        echo "To see more on analytics click on the link below<br/>";
        echo "<a href='#splurgycp'>Go to your Splurgy Control Panel</a>";
    }

    public function offer($content)
    {
        echo $content;
        $splurgyOfferId = get_post_custom_values('SplurgyOfferId');
        $splurgyOfferPowerSwitchState = get_post_custom_values('SplurgyOfferPowerSwitch');
        if( 'off' != $splurgyOfferPowerSwitchState[0] ) {
            if(!empty($splurgyOfferId)) {
                $offerId = $splurgyOfferId[0];


                if ((is_single() || $this->_offerCount < 3)) {
                    //echo '<a name="SplurgyOffer"></a>';
                    echo $this->_splurgyEmbed->getEmbed('offers', $offerId)->getTemplate();
                    $this->_offerCount++;

                } else {
                    echo "<div style='clear: both; width: 100%; text-align: center;'>
                    <a href='" . get_permalink() . "' style='color: black;'>
                        Click here to see the offer
                    </a></div>";
                }
            }
        }
    }

    public function analyticsEmbed()
    {
        echo $this->_splurgyEmbed->getEmbed('analytics')->getTemplate();
    }

    /* Adds a box to the main column on the Post and Page edit screens */

    public function addPostMetaBoxOfferList()
    {
        add_meta_box(
                'myplugin_sectionid', __('Splurgy Offers!', 'myplugin_textdomain'), array($this, 'postMetaBoxOfferList'), 'post', 'side', 'high'
        );
    }

    public function savePostMetaBoxOfferData($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /*
         * Verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times
         */

        if (!wp_verify_nonce($_POST['splurgyOfferNonce'], plugin_basename(__FILE__))) {
            return;
        }
        // Check permissions

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $offerPowerSwitchState = $_POST['offerPowerSwitch'];
        if( is_null($offerPowerSwitchState)) {
            $offerPowerSwitchState = 'off';
        }
        add_post_meta($post_id, 'SplurgyOfferPowerSwitch', $offerPowerSwitchState, true) or update_post_meta($post_id, 'SplurgyOfferPowerSwitch', $offerPowerSwitchState);

        $offerId = intval(trim($_POST['offerId']));
        if( 0 >= $offerId ) {
            return;
        }

        add_post_meta($post_id, 'SplurgyOfferId', $offerId, true) or update_post_meta($post_id, 'SplurgyOfferId', $offerId);



    }

}

?>
