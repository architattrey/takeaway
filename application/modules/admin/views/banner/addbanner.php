<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of Added Banners > Add New Banner</div>
          <?php if (isset($message)) { ?>
            <h4 style="color:green;"><?php echo $message?></h4><br>
   <?php }?>
  </div>
   <?php   echo form_open("admin/banner/addBanner",array('id'=>'add_banner_form'));?>
    <div class="row w3-res-tb">
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		 <div class="heading-r underline-rest" style="text-align:center;">Add More Banner</div>
         <form>
		 <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12"></div>
         <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
          <input id="name" type="text" class="form-control" name="name" placeholder="Banner Name" value="<?php echo set_value('name')?>" maxlength ="20" required >
        </div>
        <?php echo form_error('name','<label class="alert-danger">','</label>');?>
		<div class="form-group">
      
            <!-- <input type="file" name="image" class="file"> -->
            <div class="input-group col-xs-12">
              <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
              <input type="hidden" name="image_path" id="image_path" >
              <input type="file" id="image" class="form-control"  placeholder="Upload Banner" name="image" required>
              <span class="input-group-btn">
              <!--   <button class="browse btn btn-primary" type="button">Browse</button> -->
              </span>
            </div>
            <?php echo form_error('image','<label class="alert-danger">','</label>');?>
          </div>
         </div>
          <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12"></div>
       
		 
         
 
         </form>
     </div>
     
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-align mrg-top-bottom-r">
          <button type="submit" class="btn btn-success">Save</button>
          </div>
     
     
    
   
     
    </div>
    <?php form_close();?>
   
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
