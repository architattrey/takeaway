<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of Added Banners &nbsp; <?php echo (isset($detail['name']) && !empty($detail['name']))?  $detail['name'] : 'NA'?></div></div>
   
    <div class="row w3-res-tb">
      <div class="col-lg-2 col-md-2 col-sm-2"></div>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ba-nmr">
               <div class=""><img src="http://res.cloudinary.com/http-flynaut-com/image/upload/c_fill,h_360,w_900<?php echo $detail['image_path'];?>" class="img-responsive" alt=""  id='img-preview'></div>
			   
			   <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
       
       <div class="main-info ba-nmr-top">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-home" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Banner Name</div>
             <div class="para-r"><?php echo (isset($detail['name']) && !empty($detail['name']))?  $detail['name'] : 'NA'?></div>
             </div>
            </div>
       		
       </div>
	   <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
       
       <div class="main-info ba-nmr-top">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-upload" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Uploaded Date</div>
             <div class="para-r">
                 <?php
                       if (isset($detail['created_at'])&& !empty($detail['created_at'])) {
                            $created_at = strtotime($detail['created_at']);
                            $converteddate = date("d-M-Y",$created_at);
                            echo $converteddate;
                       }else{
                        echo "NA";
                       }
                      
                ?>
                </div>
             </div>
            </div>
       		
       </div>
      </div>
	  
      <div class="col-lg-2 col-md-2 col-sm-2"></div>
     
    
   
     
    </div>
   
  </div>
</div>
</section>

<!--main content end-->
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2017 Visitors. All rights reserved | Design by <a href="">ChromeInfotech</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->