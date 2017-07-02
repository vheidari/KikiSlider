
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


       // php delete slide
       jQuery(".delete-slide").on("click", function(){

           // ask a question for delete slide 
           var askQuestion = confirm("Are you sure remove this is slide ?");
           if(!askQuestion)
           {
            return false;
           } 

           var slide_id =  jQuery(this).attr("data-id");

           jQuery.ajax({
               url:phpToJsPath.ajaxurl,
               type:"POST",
               data:{
                   action:"delete_slide",
                   id:slide_id,
               },
               success:function(res){
                console.log(res);
                location.reload();
                jQuery("")
               },
               error:function(err){
                console.log(err);
               }
           });
       });


       /**
        *  jqury ui update form init 
        */
          jQuery( function() {
                var dialog, form, updateSlideId; 
                
                var slide_id            = jQuery("#upload-slide_id");
                var slide_caption       = jQuery("#update-slide-caption");
                var slide_description   = jQuery("#update-slide-description");
                var slide_alt_tag       = jQuery("#update-slide-alt-tag");
                var slide_category      = jQuery("#update-slide-category");
                var slide_status        = jQuery("#update-slide-status");
                var slide_time          = jQuery("#upload-slide-time");
                var slide_update        = jQuery("#upload-slide_update");
                var slide_width         = jQuery("#update-slide-width");
                var slide_height        = jQuery("#update-slide-height");


                function updateTips( t ) {
                tips
                    .text( t )
                    .addClass( "ui-state-highlight" );
                setTimeout(function() {
                    tips.removeClass( "ui-state-highlight", 1500 );
                }, 500 );
                }
            


            
                function updateSlide() {
                var valid = true;
                
                var checkBoxIsChecked = slide_status.is(':checked');
                
                 jQuery.ajax({
                     url:phpToJsPath.ajaxurl,
                     type:"POST",
                     data:{
                         action:"update_form_submit",
                         slide_id:slide_id.val(),
                         slide_alt_tag:slide_alt_tag.val(),
                         slide_caption:slide_caption.val(),
                         slide_category:slide_category.val(),
                         slide_status:checkBoxIsChecked,
                         slide_time:slide_time.val(),
                         slide_update:slide_update.val(),
                         slide_width:slide_width.val(),
                         slide_height:slide_height.val(),
                         slide_description:slide_description.val()

                     },
                     success:function(res){
                         location.reload();
                         console.log(res);
                         
                     },
                     error:function(err){
                         location.reload();
                        console.log(err); 
                     }
                 });
                  console.log("click on update information");
                }
            
                dialog = jQuery( "#dialog-form" ).dialog({
                autoOpen: false,
                height: 400,
                width: 350,
                title: 'Update slide information',
                modal: true,
                buttons: {
                    "Update informaion": updateSlide,
                    Cancel: function() {
                    dialog.dialog( "close" );
                    }
                },
                close: function() {
                    form[ 0 ].reset();
                }
                });
            
                form = dialog.find( "form" ).on( "submit", function( event ) {
                    console.log("you click on submit");
                });
            
                jQuery( ".update-slide" ).on( "click", function() {
                updateSlideId = jQuery(this).attr("data-id");
                
                jQuery.ajax({
                    url:phpToJsPath.ajaxurl,
                    type:"Post",
                    data:{
                        action:"get_Slide_Info_By_Id",
                        slideId:updateSlideId
                    },
                    success:function(res){

                        var dataRes = jQuery.parseJSON(res);
                        
                        slide_id.val(updateSlideId);
                        slide_caption.val(dataRes[0].kiki_slide_header);
                        slide_description.val(dataRes[0].kiki_slide_content);
                        slide_alt_tag.val(dataRes[0].kiki_slide_img_alt);
                        slide_status.val(dataRes[0].kiki_slide_status);
                        slide_time.val(dataRes[0].kiki_slide_date);
                        slide_update.val(Date.now());
                        slide_category.val(dataRes[0].kiki_slide_category_id);
                        slide_width.val(dataRes[0].kiki_slide_width);
                        slide_height.val(dataRes[0].kiki_slide_height);
                        
                        // check checkbox is checked
                        if(dataRes[0].kiki_slide_status == "1")
                        {
                            
                            jQuery("#update-slide-status").attr('checked', true);
                        }
                        else
                        {
                            jQuery("#update-slide-status").removeAttr('checked');
                        }
                    },
                    error:function(err){
                        console.log(err);
                    }
                });

                dialog.dialog( "open" );
                });
            } );



});