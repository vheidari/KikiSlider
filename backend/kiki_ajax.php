<?php

defined('ABSPATH') || exit();

if(is_admin())
{
    // header( 'Content-Type: text/html; charset=utf-8' ); 
    add_action("wp_ajax_add_category", "add_category");
    add_action("wp_ajax_delete_category", "delete_category");
    add_action("wp_ajax_update_category", "update_category");
    add_action("wp_ajax_image_upload" , "image_upload");

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
    if(isset($_POST) && $_POST['category_name'])
    {
        $category_name =  sanitize_text_field($_POST["category_name"]);
        global $wpdb, $table_prefix;
        $sqlQuery = "INSERT INTO " . $table_prefix . "kiki_category (ID,kiki_category_name) VALUES (default,'" . $category_name . "')";

        $queryStatus = $wpdb->query($sqlQuery);
        
        if($queryStatus)
        {
            echo "Ok, new category add in database";
            
        }
        else
        {
            echo "Sorry, have problem to add new category in database";
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
         echo "Ok, category delete form database";
       }
       else
       {
        echo "Sorry, have problem to delete category from database";
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
            echo "value is update";

        }
        else 
        {
            echo "have problems in update";
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
                            echo "slide image is upload";
                        }
                        else
                        {  
                           
                            echo "problems in uploading image";
                            
                        }
                    }
                    else
                    {
                        echo $nowSlideImage['error'];
                    }
                }   
               
            
            }
        
        }
        else
        {
            echo "please send a file";
        }

}