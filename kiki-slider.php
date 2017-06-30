<?php

defined("ABSPATH") or exit();

/*
 Plugin Name: kiki Slider
 Plugin URI: http://remixnet.ir
 Description: kiki making a simple bootstrap slider.
 Author: vahid heidari
 Author URI: http://thevoid.ir
 Version: 1.0.0
 License: MIT
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
 

 /**
  * todo
  * init database
  */
 function kiki_active()
 {
    global $table_prefix;

    $sqlCreatKikiSlideTable = "       
        CREATE TABLE IF NOT EXISTS `{$table_prefix}kiki_slides` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `kiki_slide_path` varchar(1024) COLLATE utf8_persian_ci NOT NULL,
            `kiki_slide_header` varchar(256) COLLATE utf8_persian_ci DEFAULT NULL,
            `kiki_slide_content` varchar(256) COLLATE utf8_persian_ci DEFAULT NULL,
            `kiki_slide_img_alt` varchar(256) COLLATE utf8_persian_ci DEFAULT NULL,
            `kiki_slide_status` tinyint(1) NOT NULL,
            `kiki_slide_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
            `kiki_last_update` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
            `kiki_slide_width` varchar(8) COLLATE utf8_persian_ci DEFAULT NULL,
            `kiki_slide_height` varchar(8) COLLATE utf8_persian_ci DEFAULT NULL,
            `kiki_slide_category_id` int(11) NOT NULL,
            PRIMARY KEY (`ID`),
            KEY `cat_id` (`kiki_slide_category_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;
        ";

    $sqlCreatKikiCategoryTable = "
        CREATE TABLE IF NOT EXISTS `{$table_prefix}kiki_category` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `kiki_category_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
            PRIMARY KEY (`ID`),
            UNIQUE KEY `kiki_category_name` (`kiki_category_name`)
            ) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;
        ";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // add tow kiki_slide and kiki_category table in database
    $dbDaltaKikiSlideResult     = dbDelta( $sqlCreatKikiSlideTable);
    $dbDaltaKikiCategoryResult  = dbDelta( $sqlCreatKikiCategoryTable);
 }

  /**
  * todo
  */
 function kiki_deactive()
 {

 }

