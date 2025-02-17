<?php
/**
 * Plugin Name: WP Rocket - D-bugger
 * Plugin URI:  https://wp-media.me/
 * Description: A set of debugging tools for WP Rocket.
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
**/

namespace WP_Rocket\Helpers\various\debugging;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


add_action( 'admin_menu',  __NAMESPACE__ .'\rockettoolset_add_admin_menu' );
function rockettoolset_add_admin_menu() {
    add_management_page( 'WPR D-bugger', 'WPR D-bugger', 'install_plugins', 'wprockettoolset', __NAMESPACE__.'\wprockettoolset_admin_page' );
}


if( $_GET['page'] == 'wprockettoolset' ) {
    add_action( 'admin_enqueue_scripts',  __NAMESPACE__ .'\enqueue_admin_assets' );
}

function enqueue_admin_assets(){
    wp_enqueue_script( 'prism-js', plugins_url('assets/prism.js', __FILE__ ) , '1.0.0', false );
    wp_enqueue_style( 'prism-css', plugins_url('assets/prism.css', __FILE__ ) , '1.0.0', false);
    wp_enqueue_style( 'plugin-css', plugins_url('assets/style.css', __FILE__ ) , '1.0.0', false);
}


add_action('admin_init',  __NAMESPACE__ .'\wpr_rocket_debug_log_register_settings');
function wpr_rocket_debug_log_register_settings(){
    register_setting('wpr_rocket_debug_log_settings', 'wpr_rocket_debug_log_settings', 'wpr_rocket_debug_log_settings_validate');   
}


function wpr_rocket_debug_log_settings_validate($args){
    //$args will contain the values posted in your settings form,
    return $args;
}

$options = get_option( 'wpr_rocket_debug_log_settings' ); 
if (isset($options['wpr_rocket_debug_log_status']) && $options['wpr_rocket_debug_log_status'] != '' ) {   
    
    define('WP_ROCKET_DEBUG', true);
    
  }



//RUCSS
function wprockettoolset_admin_page() {

    $mode = $_GET['mode'];
    
   
    echo '<div class="wrap"><div id="wpbody" role="main"><div id="wpbody-content">';
    
    echo '<h1 class="wp-heading-inline">WPR D-bugger</h1>';
    include('inc/menu.php'); 
    include('inc/globals.php'); 
    
    if($mode == 'rucss' || $mode == '') { include('inc/rucss.php'); }
    if($mode == 'preload') { include('inc/preload.php'); }
    if($mode == 'debug') { include('inc/debug-log.php'); }
    if($mode == 'configs') { include('inc/configs.php'); }
    if($mode == 'phpinfo') { include('inc/phpinfo.php'); }

    echo '</div></div></div>';

 }
