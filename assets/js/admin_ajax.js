
jQuery(document).ready(function(){


    /**
     *  add a category 
     */
    jQuery("#submitCategory").on("click", function(){
      var category_name = jQuery("#category_name").attr("value");
      if(!category_name)
      {
        alert("category input filde is empty please enter a category name");
        return false;
      }
      jQuery.ajax({
          url:phpToJsPath.ajaxurl,
          type:"POST",
          data:{
              action:"add_category",
              category_name: category_name
          },
          success:function(response){
            location.reload();
            jQuery("#message").show(); 
          },
          error:function(err)
          {
            location.reload();
            jQuery("#errMessage").show();  
          }
      });
    });


    /**
     * delete a category
     */
     jQuery(".delete-category").on("click", function(){
         var confitMessage = confirm("would you like deleted this category  ?");
         if(!confitMessage)
            return false;
         var category_id = jQuery(this).attr("data-id");
         jQuery.ajax({
             url:phpToJsPath.ajaxurl,
             type:"POST",
             data:{
                 action:"delete_category",
                 category_id:category_id
             },
             success:function(response){
                 location.reload();
                console.log(response);
             },
             error:function(err){
                 location.reload();
                console.log(err);
             }
         });
     });

     
     /**
      * update a category
      */

      jQuery(".update-category").on("click",function(){
          var category_id = jQuery(this).attr("data-id");
          var category_name = prompt("please add a new name for category and click on OK for update category name !!");

          if(category_name == "" || category_name==null)
          { 
            return false;
          }

          jQuery.ajax({
              url:phpToJsPath.ajaxurl,
              type:"POST",
              data:{
                 action:"update_category",
                 category_id:category_id,
                 category_name:category_name
              },
              success:function(response){
                  location.reload();  
                  console.log(response);
              },
              error:function(err){
                  location.reload();
                  console.log(err);
              }
          });
      });




      /**
       * add a slide
       */
       jQuery("#uploadSlide").on("click", function(){
            
           
            
            var selectFile              = jQuery("input[name=slide_image]");
            var imageToUpload           = selectFile[0].files[0];
            var slide_caption           = jQuery("#slide_caption").val();
            var slide_alt_description   = jQuery("#slide_alt_description").val();
            var category_id             = jQuery("#category_id").val(); 
            var slide_status            = jQuery("#slide_status").is(':checked');
            var slide_time              = jQuery("#slide_time").val();
            var slide_update            = jQuery("#slide_update").val();
            var slide_width             = jQuery("#slide_width").val();
            var slide_height            = jQuery("#slide_height").val();
            var slide_description       = jQuery("#slide_description").val();
            
            if(imageToUpload == "" || imageToUpload == null)
            {
                alert("please select a file and submit file to upload !");
                return false;
            }

            if(category_id == "" || category_id == null)
            {
                alert("please choose a category and submit file to upload !");
                return false;
            }

            if(slide_time == "" || slide_time == null)
            {
                alert("please reload this upload form !");
                return false;
            }
        

            var formData = new FormData();
            formData.append("action", "image_upload");
            formData.append("image_slide", imageToUpload);
            formData.append("slide_caption", slide_caption);
            formData.append("slide_alt_description", slide_alt_description);
            formData.append("category_id", category_id);
            formData.append("slide_status", slide_status);
            formData.append("slide_time", slide_time);
            formData.append("slide_update", slide_update);
            formData.append("slide_width", slide_width);
            formData.append("slide_height", slide_height);
            formData.append("slide_description", slide_description);


             
             jQuery("#loading").fadeIn();
          
          jQuery.ajax({
              url:phpToJsPath.ajaxurl,
              type:"POST",
              processData:false,
              contentType:false,
              data:formData,
                success : function(response){
                    jQuery("#messageSuccessAddSlide").fadeIn();
                    jQuery("#loading").fadeOut();
                    jQuery("#slide_caption").val("");
                    jQuery("#slide_alt_description").val("");
                    jQuery("#category_id").val(""); 
                    jQuery("#slide_update").val("");
                    jQuery("#slide_width").val("");
                    jQuery("#slide_height").val("");
                    jQuery("#slide_description").val("");

                    console.log(response);
                },
                error : function(err){
                     jQuery("#messageSuccessAddSlide").fadeIn();
                    console.log(err);
                }

            });
       });


});