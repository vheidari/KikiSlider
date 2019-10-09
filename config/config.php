<?php
defined("ABSPATH") or exit();

/**
 * kiki plugin define configuration
 *  - KIKI_INC_DIR      = rerutn 'inc' path directory
 *  - KIKI_CONFIG_DIR   = rerutn 'config' path directory
 *  - KIKI_FRONTEND_DIR = rerutn 'frontend' path directory
 *  - KIKI_URL          = return  'kiki-slider/' plugin  url
 *  - KIKI_JS_URL       = return  'kiki-slider/assets/js/' plugin  url
 *  - KIKI_CSS_URL      = return  'kiki-slider/assets/css/' plugin  url
 *  - KIKI_IMG_URL      = return  'kiki-slider/assets/img/' plugin  url
 */

defined("KIKI_INC_DIR")  or define("KIKI_INC_DIR", trailingslashit(KIKI_PATH . "inc"));
defined("KIKI_CONFIG_DIR") or define("KIKI_CONFIG_DIR" , trailingslashit( KIKI_PATH . "config"));
defined("KIKI_BACKEND_DIR") or define("KIKI_BACKEND_DIR", trailingslashit( KIKI_PATH . "backend"));
defined("KIKI_FRONTEND_DIR") or define("KIKI_FRONTEND_DIR", trailingslashit( KIKI_PATH . "frontend"));
defined("KIKI_URL") or define("KIKI_URL", trailingslashit(dirname(plugin_dir_url(__FILE__))));
defined("KIKI_JS_URL") or define("KIKI_JS_URL" , trailingslashit( KIKI_URL . "assets/js"));
defined("KIKI_CSS_URL") or define("KIKI_CSS_URL" , trailingslashit( KIKI_URL . "assets/css"));
defined("KIKI_IMG_URL") or define("KIKI_IMG_URL" , trailingslashit( KIKI_URL . "assets/image"));
defined("KIKI_ADD_NEW_SLIDE") or define("KIKI_ADD_NEW_SLIDE", admin_url( "admin.php?page=kiki-addSlide", "http" ));
