<?php
/**
* fdfnsfldlgnzlfgrgilwrgb
*
* @category File
* @package  Dfsdf
* @author   Dfsff  <dfsff@gmail.com>
* @license  license.com  Random  License
* @link     dsfdsf
**/

/**
 * An example of how to write code to PEAR's standards
 *
 * Docblock comments start with "/**" at the top.  Notice how the "/"
 * lines up with the normal indenting and the asterisks on subsequent rows
 * are in line with the first asterisk.  The last line of comment text
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Original Author <author@example.com>
 * @author     Another Author <another@example.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      Class available since Release 1.2.0
 * @deprecated Class deprecated in Release 2.0.0
 */
?>
<?php
/*
Plugin Name: Splurgy Offers
Plugin URI: http://tba.com
Description: This plugin will allow users to easily add offers at the end of their post
Version: 1.0
Author: Douglas Mak and Hai Vo
Author URI: http://tba.com
License: GPL3 
*/
?>
<?php
/*
paste GPL3 license here
*/
?>
<?php
/**
 * An example of how to write code to PEAR's standards
 *
 * Docblock comments start with "/**" at the top.  Notice how the "/"
 * lines up with the normal indenting and the asterisks on subsequent rows
 * are in line with the first asterisk.  The last line of comment text
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Original Author <author@example.com>
 * @author     Another Author <another@example.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      Class available since Release 1.2.0
 * @deprecated Class deprecated in Release 2.0.0
 */
class Splurgy
{

  public $offerCount = 0;

  public function __construct()
  {
    // Hook for adding admin menus
    add_action('admin_menu', array( $this, 'adminMenu' ) );

    // Hook for adding admin menus
    add_action( 'the_content', array( $this, 'offer' ) );

    // Hook on the analytics embed
    add_action( 'wp_head', array( $this, 'analyticsEmbed' ) ) ;

    /* Add New post */
    add_action( 'add_meta_boxes', array( $this, 'myplugin_add_custom_box' ) );

    // backwards compatible (before WP 3.0)
    // add_action( 'admin_init', 'myplugin_add_custom_box', 1 );

    /* Do something with the data entered */
    add_action( 'save_post', array( $this, 'myplugin_save_postdata' ) );
  } 


  /**
  * An example of how to write code to PEAR's standards
  * 
  * @return void
  */
  public function adminMenu() {
      //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
      add_menu_page('Splurgy', 'Splurgy', 'manage_splurgy', 'splurgy');

      //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); 
      add_submenu_page('splurgy', 'Analytics', 'Analytics', 'manage_options', 'analytics', array( $this, 'analyticsPage' ) );
      add_submenu_page('splurgy', 'Verify', 'Verify', 'manage_options', 'verify', array( $this, 'verifyPage' ) );
  }

  public function verifyPage() {
      echo "<h2>Verify</h2>";
      echo "<button type='button'>Connect your Splurgy Account</button>";
  }

  public function analyticsPage() {
      echo "<h2>Analytics</h2>";
      echo '<img src="' .plugins_url( 'images/analytics.png' , __FILE__ ). '" > ';
      echo "<br/>";
      echo "<br/>";
      echo "To see more on analytics click on the link below<br/>";
      echo "<a href='#splurgycp'>Go to your Splurgy Control Panel</a>";
  }



  public function offer()
  {
    echo $content;
    // Only insert this if it allows
    if(is_single() || $this->offerCount < 3 ) {
        echo "<div style='clear: both; width: 100%; background: gray; padding: 10px; color: white; margin: 5px; text-align: center;'>Splurgy offer will be here!</div>";    
        $this->offerCount++;
    } else {
        echo "<div style='clear: both; width: 100%; background: #c54d42; padding: 10px; margin: 5px; text-align: center;'><a href='" .get_permalink(). "'' style='color: white;'>Click to See offer</a></div>";    
    }
  }
  
  public function analyticsEmbed() {
      echo "EMBED WILL GO HERE";
  }

  /* Adds a box to the main column on the Post and Page edit screens */
  public function myplugin_add_custom_box() {
      add_meta_box( 
          'myplugin_sectionid',
          __( 'Splurgy: Select an offer to display on this post!', 'myplugin_textdomain' ),
          array( $this, 'myplugin_inner_custom_box'),
          'post' 
      );
      add_meta_box(
          'myplugin_sectionid',
          __( 'Splurgy - Select an offer to display on this post!', 'myplugin_textdomain' ), 
          array( $this, 'myplugin_inner_custom_box'),
          'page'
      );
  }

  /* Prints the box content */
  public function myplugin_inner_custom_box( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

    // The actual fields for data entry
    echo '<label for="myplugin_new_field">';
         _e("Search Offers", 'myplugin_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" size="25" />';
    echo <<<END
      <select size="3" name="selectionField" style="width: 100%; height: 100px;" > 
        <option value="offer-1" >Offer 1</option>
        <option value="offer-2" >Offer 2</option>
        <option value="offer-3" >Offer 3</option>
        <option value="offer-4" >Offer 4</option>
        <option value="offer-5" >Offer 5</option>
        <option value="offer-6" >Offer 6</option>
        <option value="offer-7" >Offer 7</option>
        <option value="offer-8" >Offer 8</option>
        <option value="offer-9" >Offer 9</option>
        <option value="offer-10" >Offer 10</option>
        <option value="offer-11" >Offer 11</option>
      </select>
END;
  }



  /* When the post is saved, saves our custom data */
  public function myplugin_save_postdata( $post_id ) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    
    // Check permissions
    if ( 'page' == $_POST['post_type'] ) 
    {
      if ( !current_user_can( 'edit_page', $post_id ) )
          return;
    }
    else
    {
      if ( !current_user_can( 'edit_post', $post_id ) )
          return;
    }

    // OK, we're authenticated: we need to find and save the data

    $mydata = $_POST['myplugin_new_field'];

    // Do something with $mydata 
    // probably using add_post_meta(), update_post_meta(), or 
    // a custom table (see Further Reading section below)
  }



}
$sp = new Splurgy;


?>