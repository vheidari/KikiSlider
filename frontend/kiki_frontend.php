
<?php
  function kiki_export_shortcode($kiki_attr)
  {
    //get shortcode attribute
    $kiki_slider_attr = shortcode_atts( array(
          "ishomepage" => $kiki_attr,
          "catid" => $kiki_attr,
    ), $kiki_attr);
    
  //check is not empty catid attr
  if(!empty($kiki_slider_attr['catid']))
	{
		 // get result by cat id
		 global $wpdb, $table_prefix;

		 $sqlQuery = "SELECT * FROM {$table_prefix}kiki_slides WHERE kiki_slide_category_id = {$kiki_slider_attr['catid']}";
		 $sqlResutl =  $wpdb->get_Results($sqlQuery);

    // check results is empty
		if(empty($sqlResutl))
		  {
				 ?>
					 <div class="kiki-slider">
					 <p> 'kiki slider' not found slide. Please go to wp-admin > KIKI Slides > Add New Slide and upload slide</p>
					 </div>
				  <?php
						return false;
			}
			//check ishomepage attr is true  
			if($kiki_slider_attr['ishomepage'] == "true")
			{ 
			  	if(is_front_page())
				  {

						 ?>
						<div class="kiki-slider">

							<div id="myCarousel" class="carousel slide" data-ride="carousel">

							  <!--Wrapper for slides -->
							  <div class="carousel-inner">
								<?php
								$slide_active = 0;
								foreach($sqlResutl as $slide)
								{
									if($slide->kiki_slide_status == 1)
									{
										?>
										<div class="item <?php if($slide_active == 0){ echo "active"; } ?>">
										  <img src="<?php if(!empty($slide)){ echo $slide->kiki_slide_path; } ?>" <?php if(!empty($slide->kiki_slide_img_alt)){ echo "alt='{$slide->kiki_slide_img_alt}'"; }  if(!empty($slide->kiki_slide_width)){ echo "width='{$slide->kiki_slide_width}'"; } if(!empty($slide->kiki_slide_height)){ echo "height='{$slide->kiki_slide_height}'"; } ?>>
										  <div class="carousel-caption">
											<?php 
											if(!empty($slide->kiki_slide_header))
											  { 
												echo "<h3 style='color:#fff'>" . $slide->kiki_slide_header . "</h3>";
											  } 
											if(!empty($slide->kiki_slide_content))
											  {
												 echo "<p>". $slide->kiki_slide_content ."</p>";
											  }
											  ?>
										  </div>
										</div>
										
										<?php 
										
										$slide_active++;
									}
								}
								?>
							  </div>
								<!-- end of carousel-inner -->
							</div>
							<!-- end of myCarousel-->
						</div>
						<!-- end of kiki-slider -->
						<?php 
					  //end if is fontendpage
				  }
			}
			else
			{
			  // check ishomepage is false
			  if(!is_front_page())
			  {
			  ?>
			  
				  <div class="kiki-slider">

							<div id="myCarousel" class="carousel slide" data-ride="carousel">

							  <!--Wrapper for slides -->
							  <div class="carousel-inner">
								<?php
									$slide_active = 0;
									foreach($sqlResutl as $slide)
									{
										if($slide->kiki_slide_status == 1)
										{
											?>
											
											<div class="item <?php if($slide_active == 0){ echo "active"; } ?>">
											  <img src="<?php if(!empty($slide)){ echo $slide->kiki_slide_path; } ?>" <?php if(!empty($slide->kiki_slide_img_alt)){ echo "alt='{$slide->kiki_slide_img_alt}'"; }  if(!empty($slide->kiki_slide_width)){ echo "width='{$slide->kiki_slide_width}'"; } if(!empty($slide->kiki_slide_height)){ echo "height='{$slide->kiki_slide_height}'"; } ?>>
											  <div class="carousel-caption">
												<?php 
													if(!empty($slide->kiki_slide_header))
													  { 
														echo "<h3 style='color:#fff'>" . $slide->kiki_slide_header . "</h3>";
													  } 
													if(!empty($slide->kiki_slide_content))
													{
													  echo "<p>". $slide->kiki_slide_content ."</p>";
													}
												  ?>
											  </div>
											</div>
											
											<?php 
											
											$slide_active++;
										}
									}
								?>
							  </div>
                <!--end of carousel-inner-->
							</div>
							<!-- end of myCarousel-->
						</div>
						<!-- end of kiki-slider -->
				  <?php
			  }
			}
	}
	 else
	{
		  ?>
			<div class="kiki-slider">
				<p>oh no 'kiki slider' cannot show slide. please insert true shortcode. you can go to wp-admin > KIKI Slides > Categories and find true shortcode. for example in simple mode use [kiki_slider catid='10']</p>
			</div>
		  <?php

	 // end check is not empty catid attr
	}


  }


// add_action( "wp", "kiki_export");
 add_shortcode( "kiki_slider", "kiki_export_shortcode" );


?>