<?php

/*
 * All wordpress hooks should go here
 */

class WordpressHooks
{
    protected $wordpressView;

    //put your code here
    public function __construct(WordpressView $wordpressView)
    {
        $this->wordpressView = $wordpressView;
        $file = dirname(__FILE__) . '/splurgy-lib/token.config';

        /* Required JavaScript files */
        add_action('admin_init', array( $this, 'requiredJsEnqueue'));

        /* Admin notice for when token isn't set */
        add_action('admin_notices', array( $this->wordpressView, 'missingTokenNotice' ) );

        /* Post handler function for settings page - This has to be before analytics */
        add_action('admin_head', array( $this->wordpressView, 'settingsPagePostHandler'));

        /* Settings page hook analytics */
        add_action( 'admin_head', array( $this->wordpressView, 'analyticsEmbed' ) );

        // Hook for adding admin menus
        add_action('admin_menu', array( $this, 'adminMenu' ) );

        $token = file_get_contents($file);
        if(!empty($token)) {
            // Hook on the analytics embed
            add_action( 'wp_head', array( $this->wordpressView, 'analyticsEmbed' ) );

            // Hook for adding admin menus
            add_action( 'the_content', array( $this->wordpressView, 'offer' ) );

            /* Add New post meta box */
            add_action( 'add_meta_boxes', array( $this->wordpressView, 'addPostMetaBoxOfferList' ) );

            /* Save Splurgy offer post meta data */
            add_action( 'save_post', array( $this->wordpressView, 'savePostMetaBoxOfferData' ) );

            /* JavaScript files */
            add_action('init', array( $this, 'javascriptEnque'));

        }

        /* Display error/success messages - This should always be last */
        add_action('admin_notices', array( $this->wordpressView, 'showWordPressMessage'));
    }

    public function adminMenu()
    {
        //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page('Splurgy', 'Splurgy', 'manage_splurgy', 'splurgy');

        //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
        // add_submenu_page('splurgy', 'Analytics', 'Analytics', 'manage_options', 'analytics', array($this->wordpressView, 'analyticsPage'));
        add_submenu_page('splurgy', 'Settings', 'Settings', 'manage_options', 'settings', array($this->wordpressView, 'settingsPage'));
    }

    public function requiredJsEnqueue() {
        wp_enqueue_script( 'jquery' );

        // Simpletip
        wp_enqueue_script( 'jquery-simpletip', plugins_url( '/js/vendors/jquery.simpletip-1.3.1.min.js', __FILE__ ));

        // jconfirmaction
        wp_enqueue_script( 'jquery-jconfirmaction', plugins_url( '/js/vendors/jconfirmaction.jquery.js', __FILE__ ));


        wp_enqueue_script( 'splurgy-jquery-settings', plugins_url( '/js/splurgy-jquery-settings.js', __FILE__ ));
        wp_enqueue_style('splurgy-css-settings', plugins_url('/css/splurgy-css-settings.css',__FILE__) );

    }

    public function javascriptEnque() {

        wp_enqueue_script( 'splurgy-jquery-postmetabox', plugins_url( '/js/splurgy-jquery-metabox.js', __FILE__ ));

        wp_enqueue_style( 'splurgy-css-metabox', plugins_url('/css/splurgy-css-metabox.css', __FILE__) );


        /* should refactor into other functions or class */
        // iphone-style-checkboxes
        wp_enqueue_style( 'jquery-iphone-checkboxes-css', plugins_url('/js/vendors/iphone-style-checkboxes/style.css', __FILE__) );
        wp_enqueue_script( 'jquery-iphone-checkboxes', plugins_url( '/js/vendors/iphone-style-checkboxes/jquery/iphone-style-checkboxes.js', __FILE__ ));

        // numeric
        wp_enqueue_script( 'jquery-numeric', plugins_url( '/js/vendors/numeric/jquery.numeric.js', __FILE__ ));

    }

}

?>