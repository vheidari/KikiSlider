<?php

defined('ABSPATH') or exit();

if(is_admin())
{
    // header( 'Content-Type: text/html; charset=utf-8' );
    add_action("wp_ajax_add_category", "add_category");
    add_action("wp_ajax_delete_category", "delete_category");
    add_action("wp_ajax_update_category", "update_category");
    add_action("wp_ajax_image_upload" , "image_upload");
    add_action("wp_ajax_delete_slide","delete_slide");
    add_action("wp_ajax_get_Slide_Info_By_Id", "get_Slide_Info_By_Id");
    add_action("wp_ajax_update_form_submit", "update_form_submit");

}


/**
 * todo
 *
 * use strinpslashes();
 * and htmlspecialchars();
 *
 */
function add_category()
{
    if(isset($_POST) && isset($_POST['category_name']))
    {
        $category_name =  sanitize_text_field($_POST["category_name"]);
        global $wpdb, $table_prefix;
        $sqlQuery = "INSERT INTO " . $table_prefix . "kiki_category (ID,kiki_category_name) VALUES (default,'" . $category_name . "')";

        $queryStatus = $wpdb->query($sqlQuery);

        if($queryStatus)
        {
            die("Ok, new category add in database");
        }
        else
        {
            die("Sorry, have problem to add new category in database");
        }

    }
}

/**
 * todo
 *
 * use strinpslashes();
 * and htmlspecialchars();
 *
 */

function delete_category()
{
    if(isset($_POST) && isset($_POST['category_id']))
    {
       $category_id = sanitize_text_field($_POST['category_id']);
       global $wpdb, $table_prefix;
       $sqlQuery = "DELETE FROM " . $table_prefix . "kiki_category WHERE " . $table_prefix . "kiki_category.ID = " . $category_id . " LIMIT 1";
       $queryStatus = $wpdb->query($sqlQuery);
       if($queryStatus)
       {
         die("Ok, category delete form database");
       }
       else
       {
         die("Sorry, have problem to delete category from database");
       }
    }
}



/**
 * todo
 *
 * use strinpslashes();
 * and htmlspecialchars();
 *
 */
function update_category()
{
    global $wpdb, $table_prefix;
    if(isset($_POST) && isset($_POST['category_id']) && !empty($_POST['category_id']) && isset($_POST['category_name']) && !empty($_POST['category_name']))
    {
        $category_id    = sanitize_text_field($_POST['category_id']);
        $category_name  = sanitize_text_field($_POST['category_name']);

        $sqlQuery = "UPDATE " . $table_prefix . "kiki_category SET kiki_category_name='" . $category_name . "' WHERE ID=" . $category_id . " LIMIT 1";

        $sqlResult = $wpdb->query($sqlQuery);

        if($sqlResult)
        {
            die("value is update");
        }
        else
        {
            die("have problems in update");
        }
    }
}

/**
 * todo
 *
 * use strinpslashes();
 * and htmlspecialchars();
 *
 */
function image_upload()
{
        if(!empty($_POST) && $_POST != "")
        {
            if($_FILES && isset($_FILES)){


                $imageInformation = array(
                    "image_name" => trim($_FILES['image_slide']['name']),
                    "image_type" => $_FILES['image_slide']['type'],
                    "image_size" => $_FILES['image_slide']['size'],
                    "image_tmp"  => $_FILES['image_slide']['tmp_name']
                );

                if(function_exists("wp_handle_upload")){

                    $uploadFile = $_FILES['image_slide'];
                    $overridesOption = array('test_form' => false);

                    $nowSlideImage =  wp_handle_upload( $uploadFile, $overridesOption );

                    if( ! $nowSlideImage['error']){

                        $imageSlideUrl = $nowSlideImage['url'];
                        $imageInformation['image_url'] = $imageSlideUrl;


                        if(empty($_POST['slide_width']))
                        {
                            $slide_width = "100%";
                        }
                        else
                        {
                            $slide_width = $_POST['slide_width'];
                        }


                        if(empty($_POST['slide_height']))
                        {
                            $slide_height = "auto";
                        }
                        else
                        {
                            $slide_height  = $_POST['slide_height'];
                        }

                        if($_POST['slide_status'] === 'true')
                        {
                            $slide_status = 1;
                        }
                        else
                        {
                            $slide_status = 0;
                        }

                        //form data
                        $formData = array(
                            "slide_url"             => $imageInformation['image_url'],
                            "slide_caption"         => $_POST['slide_caption'],
                            "slide_alt_description" => $_POST['slide_alt_description'],
                            "category_id"           => $_POST['category_id'],
                            "slide_status"          => $slide_status,
                            "slide_time"            => $_POST['slide_time'],
                            "slide_update"          => "null",
                            "slide_width"           => $slide_width,
                            "slide_height"           => $slide_height,
                            "slide_description"     => $_POST['slide_description'],

                        );


                        global $wpdb, $table_prefix;

                        $sqlQuery = "INSERT INTO {$table_prefix}kiki_slides (ID, kiki_slide_path, kiki_slide_header, kiki_slide_content, kiki_slide_img_alt, kiki_slide_status, kiki_slide_date, kiki_last_update, kiki_slide_width, kiki_slide_height, kiki_slide_category_id) VALUES (default, '{$formData['slide_url']}', '{$formData['slide_caption']}', '{$formData['slide_description']}', '{$formData['slide_alt_description']}', '{$formData['slide_status']}', '{$formData['slide_time']}', '{$formData['slide_update']}', '{$formData['slide_width']}', '{$formData['slide_height']}', '{$formData['category_id']}')";


                        $queryResult = $wpdb->query($sqlQuery);
                        if($queryResult)
                        {
                            die("slide image is upload");
                        }
                        else
                        {

                            die("problems in uploading image");

                        }
                    }
                    else
                    {
                        die($nowSlideImage['error']);
                    }
                }


            }

        }
        else
        {
          die("please send a file");
        }

}


// delete slide
function delete_slide()
{
    if(!$_POST == "")
    {
        if(isset($_POST['id']))
        {
            $slide_id = strip_tags($_POST['id']);

            global $wpdb, $table_prefix;

            $sqlQuery = "SELECT kiki_slide_path FROM {$table_prefix}kiki_slides WHERE ID = {$slide_id} LIMIT 1";

            $sqlResult = $wpdb->get_results($sqlQuery);

            if($sqlResult)
            {
                foreach($sqlResult as $getUrl)
                {
                    $slideUrl =  $getUrl->kiki_slide_path;
                }


                $changeSlash = str_replace("/", "\\", $slideUrl);

                $exSlideUrl = explode("\\", $changeSlash);
                $sliceArray = array_slice($exSlideUrl, -5,5);


                $imSlidePath = implode("/", $sliceArray);

                $homeDir = get_home_path();
                $fileFullPath = $homeDir.$imSlidePath;

                if(file_exists($fileFullPath))
                {
                   $removeStatus = unlink($fileFullPath);

                   if($removeStatus)
                   {
                        $deleteSqlQuery = "DELETE FROM {$table_prefix}kiki_slides WHERE ID = {$slide_id}";

                        $deleteSqlResult = $wpdb->query($deleteSqlQuery);

                        if($deleteSqlResult)
                        {
                            die("successfully delete slide from database");
                        }
                        else
                        {
                            die("error '305' : error in delete file form server");
                        }
                   }
                   else
                   {
                     die("problems in remove file from server !");
                   }
                }
                else
                {
                    die("file not exist on server !");
                }


            }

        }
    }
}

/**
 * todo
 *
 * use strinpslashes();
 * and htmlspecialchars();
 *
 */
// get information slide by id
function get_Slide_Info_By_Id()
{
    if(isset($_POST['action']) == "get_Slide_Info_By_Id")
    {
        if(!empty($_POST))
        {
           global $wpdb, $table_prefix;
           $slide_id = $_POST['slideId'];

           $sqlQuery = "SELECT * FROM {$table_prefix}kiki_slides WHERE ID = {$slide_id} LIMIT 1";
           $sqlResult =  $wpdb->get_results($sqlQuery);

           if($sqlResult)
           {
             wp_send_json(json_encode($sqlResult));
           }
        }
    }
}



/**
 * todo
 *
 * use strinpslashes();
 * and htmlspecialchars();
 *
 */
function update_form_submit()
{
    if(isset($_POST["action"]) == "update_form_submit")
    {

        $slide_id           = $_POST["slide_id"];
        $slide_alt_tag      = $_POST["slide_alt_tag"];
        $slide_caption      = $_POST["slide_caption"];
        $slide_category     = $_POST["slide_category"];
        $slide_status       = $_POST["slide_status"];
        $slide_time         = $_POST["slide_time"];
        $slide_update       = $_POST["slide_update"];
        $slide_width        = $_POST["slide_width"];
        $slide_height       = $_POST["slide_height"];
        $slide_description  = $_POST["slide_description"];

        if($slide_status === 'true')
        {
            $slide_status = '1';
        }
        else
        {
            $slide_status = '0';
        }

        global $wpdb, $table_prefix;
        $sqlQuery = "UPDATE {$table_prefix}kiki_slides
                     SET kiki_slide_header = '{$slide_caption}', kiki_slide_content = '{$slide_description}',
                      kiki_slide_img_alt = '{$slide_alt_tag}', kiki_slide_status = '{$slide_status}', kiki_slide_date = '{$slide_time}',
                      kiki_last_update = '{$slide_update}', kiki_slide_width = '{$slide_width}', kiki_slide_height =  '{$slide_height}',
                      kiki_slide_category_id = '{$slide_category}' WHERE ID = '{$slide_id}' LIMIT 1";

        $sqlResult  = $wpdb->query($sqlQuery);

        if($sqlResult)
        {
            die("successful slide update");
        }
        else
        {
            die("problrms in update slide information");
        }
    }
}
