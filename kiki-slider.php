<?php

defined("ABSPATH") or exit();

/*
 Plugin Name: kiki Slider
 Plugin URI: http://remixnet.ir
 Description: kiki makeing a simple bootstrap slider.
 Author: vahid heidari
 Author URI: http://thevoid.ir
 Version: 1.0.0
 License: GPLv2 or later
*/

define("KIKI_PATH", plugin_dir_path(__FILE__));


require_once( KIKI_PATH . "config/config.php" );
require_once( KIKI_FRONTEND_DIR . "kiki_frontend.php" );

 
 if(is_admin && is_super_admin)
     {
         require_once( KIKI_BACKEND_DIR . "kiki_backend.php");
         require_once( KIKI_BACKEND_DIR . "kiki_page.php");
         require_once( KIKI_BACKEND_DIR . "kiki_ajax.php");

         add_action("admin_menu", "kiki_admin_menu");
     }

/**
 * kiki register active and deactive hook 
 */

 register_activation_hook(__FILE__, "kiki_active");
 register_deactivation_hook(__FILE__, "kiki_deactive");
 

 function kiki_active()
 {
    
 }
 function kiki_deactive()
 {

 }

