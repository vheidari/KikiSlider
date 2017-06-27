<?php

defined("ABSPATH") || exit();

/**
 * kiki_dashboard function
 *
 * @return void
 */
function kiki_dashboard()
{
    global $wpdb, $table_prefix;
    $sqlQuery = "SELECT * FROM " . $table_prefix . "kiki_slides";
    $showPosts = $wpdb->get_results($sqlQuery);
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">All Slides</h1>
        <a href="<?php echo KIKI_ADD_NEW_SLIDE; ?>" class="page-title-action">Add New Slide </a>
        <hr>
        <table class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <td>Slider Title</td>
                <td>Slider Short Code</td>
                <td>Slider Title</td>
                <td>Slider Short Code</td>
                <td>Slider Title</td>
                <td>Update --- Delete</td>
                </tr>
            </thead>


            <tbody id="the-list">
            <?php
                foreach($showPosts as $post):
            ?>
                <tr>
                <th scope="row" class="check-column"> 
                <input id="" type="checkbox">
                </th>
                    <td>sample data</td>
                    <td>sample data</td>
                    <td>sample data</td>
                    <td>sample data</td>
                    <td>sample data</td>
                    <td><a href="#" class="update-category" data-id="" >update</a> --- <a href="#"  class="delete-category" data-id="">delete</a></td>
                </tr>
            <?php
                endforeach;
            ?>
            </tbody>


            <tfoot>
                <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <td>Slider Title</td>
                <td>Slider Short Code</td>
                <td>Slider Title</td>
                <td>Slider Short Code</td>
                <td>Slider Title</td>
                <td>Update --- Delete</td>
                </tr>
            </tfoot>


        </table>
        <?php

        ?>
    </div>


    <?php

}

/**
 * kiki_addNewSlide function
 *
 * @return void
 */
function kiki_addNewSlide()
{
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Add New Slide</h1>
        <hr>
        <form enctype="multipart/form-data">
        <table class="form-table"> 
            <tbody>
            <tr>
                <div id="message"    class="updated notice notice-success is-dismissible"><p>Ok, new slide add in database</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Close this</span></button></div>
                <div id="errMessage" class="update-nag"><p>Sorry, have problem to add new slide in database</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Close this</span></button></div>
                </tr>
                <tr>
                    <th><label for="slide_caption">Slide Caption</label></th>
                    <td><input type="text" id="slide_caption" name="slide_caption" value="" class="regular-text" placeholder="add a slide caption here"></td>
                </tr>
                <tr>
                    <th><label for="slide_image">Slide Image</label></th>
                    
                    <td>
                        <label for="slide_image" class="slide_image_style"><img src="<?php echo KIKI_URL."assets/image/image-upload-background.svg"; ?>" class="image-upload-background" alt=""></label>
                        <input type="file" id="slide_image" name="slide_image" value="" class="regular-text"  accept="image/*">
                    </td>
                </tr>
                <tr>
                    <th><label for="slide_alt_description">Slide alt tag description</label></th>
                    <td><input type="text" id="slide_alt_description" name="slide_alt_description" value="" class="regular-text" placeholder="add a slide alt description here"></td>
                </tr>
                <tr>
                    <th><label for="slide_category">Slide Category</label></th>
                    <td>
                     <select name="category_id" id="category_id">
                    <?php
                        global $wpdb, $table_prefix;
                        $slqQuery = "SELECT * FROM {$table_prefix}kiki_category;";
                        $queryResults = $wpdb->get_results($slqQuery);
                        
                        foreach($queryResults as $queryResult):
                    ?>
                        <option id="slide_category_id" value="<?php echo $queryResult->ID;?>"><?php echo $queryResult->kiki_category_name;?></option>
                    <?php endforeach; ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="slide_status">Slide Status</label></th>
                    <td>
                    <input type="checkbox" id="slide_status" name="slide_status" value="status" checked="checked" class="regular-text"> TRUE / FALSE
                    <input type="hidden" id="slide_time" name="slide_time" value="<?php echo time();?>" class="regular-text"> 
                    <input type="hidden" id="slide_update" name="slide_update" value="" class="regular-text"> 
                    </td>
                </tr>
                <tr>
                    <th><label for="slide_width">Slide Width</label></th>
                    <td>
                        <input type="text" id="slide_width" name="slide_width" value="" class="regular-text" placeholder="add a slide width here">
                        <br>
                        <small class="green_text_color">if you empty this field, kiki puts width image = 100%</small>
                    </td>
                </tr>
                <tr>
                    <th><label for="slide_height">Slide Heigh</label></th>
                    <td>
                        <input type="text" id="slide_height" name="slide_height" value="" class="regular-text" placeholder="add a slide heigh here">
                        <br>
                        <small class="green_text_color">if you empty this field, kiki puts height image = auto</small>    
                    </td>
                   
                </tr>
                <tr>
                    <th><label for="slide_description">Slide Description</label></th>
                    <td><textarea rows="6" cols="35" id="slide_description"></textarea></td>
                </tr>
                <tr>
                    <th><label for="submit"></label></th>
                    <td>
                        <p id="loading">
                        <img src="<?php echo KIKI_URL."assets/image/loading.svg"; ?>"  alt="loading">
                        <br>
                        <small class="green_text_color">Please wait kiki upload image slide</small>
                        </p>
                        <p class="submit"><a href="#" id="uploadSlide" class="button button-primary">Upload Slide</a></p>
                    </td>
                </tr>
            </tbody>

        </table>
        </form>

    </div>

    <?php
}



/**
 * kiki_addNewSlideCategory function
 *
 * @return void
 */
function kiki_Categorys()
{

    global $wpdb, $table_prefix;
    $slqQuery = "SELECT * FROM " . $table_prefix . "kiki_category";
    $categoryResults = $wpdb->get_results($slqQuery);

    ?>
    
    <div class="wrap">
        <h1 class="wp-heading-inline">Add New Slide Category</h1>
        <hr>
        <table class="form-table"> 
            <tbody>
            <tr>
                <div id="message"    class="updated notice notice-success is-dismissible"><p>Ok, new category add in database</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Close this</span></button></div>
                <div id="errMessage" class="update-nag"><p>Sorry, have problem to add new category in database</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Close this</span></button></div>
            </tr>
                <tr>
                    <th><label for="category_name">Category name</label></th>
                    <td><input type="text" id="category_name" name="category_name" value="" class="regular-text" placeholder="add a category name here"></td>
                </tr>
                <tr>
                    <th><label for="submit"></label></th>
                    <td><p class="submit"><a href="#" id="submitCategory" class="button button-primary">Submit Category</a></p></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="wrap">
        <table class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <td>Category ID</td>
                <td>Category Name</td>
                <td>Update --- Delete</td>
                </tr>
            </thead>
            <tbody id="the-list">

                <?php
                    $id = 1;
                    foreach($categoryResults as $categoryResult):
                 ?>
                        <tr>
                        <th scope="row" class="check-column"> 
                        <input id="" type="checkbox">
                        </th>
                            <td><?php echo $id++; ?></td>
                            <td><?php echo $categoryResult->kiki_category_name; ?></td>
                            <td><a href="#" class="update-category" data-id="<?php echo $categoryResult->ID; ?>" >update</a> --- <a href="#"  class="delete-category" data-id="<?php echo $categoryResult->ID; ?>">delete</a></td>
                        </tr>
                <?php 
                    endforeach;

                ?>
            </tbody>

            <tfoot>
                <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <td>Category ID</td>
                <td>Category Name</td>
                <td>Update --- Delete</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <?php
}



/**
 * kiki_aboutPlugin function
 *
 * @return void
 */
function kiki_aboutPlugin()
{
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">About Kiki Slide</h1>
        <hr>
    </div>

    <?php
}
