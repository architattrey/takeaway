<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
  <div class="panel-heading" >Update For <?php echo $detail['name']?> Reastaurant </div>
   <div class="row w3-res-tb">
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		 
     </div>
    </div>
    <?php if (isset($message)) { ?>
 <h4 style="color:green;"><?php echo $message?></h4><br>
 <?php } ?>
    <div class="row w3-res-tb">
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		 <div class="heading-r underline-rest">Update Restaurant</div>
        <?php echo form_open("admin/restaurant/updateRestaurant", array( 'id' => 'add_mart_form'));?>


          <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
          <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
          <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
          <input id="restaurantname" type="text" class="form-control" name="name" placeholder="Enter Restaurant Name" maxlength="20" value="<?php echo $detail['name'];?>" required >
          </div>
          <?php echo form_error('name','<label class="alert-danger">','</label>');?>
          </div>


         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
          <input id="number" type="number" class="form-control" name="phone" placeholder="Enter Contact Number" pattern="^\d{10}$" value="<?php echo $detail['phone'];?>" required >
         </div>
         <?php echo form_error('phone','<label class="alert-danger">','</label>');?>
         </div>



         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
          <input id="email" type="email" class="form-control" name="email" placeholder="Enter Email Address" maxlength="100" value="<?php echo  $detail['email'];?>" required > 
         </div>
         <?php echo form_error('email','<label class="alert-danger">','</label>');?>
         </div>



         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
           <input type="hidden" id="latitude" name="lat" >
           <input type="hidden" id ="longitude" name ="lng" >
          <input id="address" type="text" class="form-control" name="address" placeholder="Address" maxlength="100" value="<?php echo $detail['address'];?>" required >
         </div>
         <?php echo form_error('address','<label class="alert-danger">','</label>');?>
         </div>
         


         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
         <div class="form-group">
         <div class="heading-r ">Banner Image</div>
         <!-- <input type="file" name="img[]" class="file"> -->
         <div class="input-group col-xs-12">
          <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>

          <input type="hidden" name="banner_img_path" id="banner_img_path">
          <input id="banner_image" type="file" class="form-control" placeholder="Upload Image" name = "banner_image" value="<?php echo  $detail['banner_image'];?>" required >
           <p ><?php echo $detail['banner_image'];?></p>  
          <span class="input-group-btn">
          <!--  <button class="browse btn btn-primary" type="button">Browse</button> -->
          </span>
          </div>
          </div>
           <?php echo form_error('banner_image','<label class="alert-danger">','</label>');?>
          </div>
          



          <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
          <div class="form-group">
          <div class="heading-r ">Logo Image</div>
          <!--   <input type="file" name="img[]" class="file"> -->
          <div class="input-group col-xs-12">
          <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
           <input type="hidden" name="logo_img_path" id="logo_img_path">
          <input id="logo_image" type="file" class="form-control" placeholder="Upload Image"  name ="logo_image" value="<?php echo $detail['logo_image'];?>" required> 
          <p  ><?php echo $detail['logo_image'];?></p>  
          <span class="input-group-btn">
          <!-- <button class="browse btn btn-primary" type="button">Browse</button> -->
          </span>
          </div>
          <?php echo form_error('logo_image','<label class="alert-danger">','</label>');?>
          </div>
          </div>




          <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 padding-left">
          <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
          <input id="opening_time" class="timepicker form-control" name="opening_time" placeholder="Opening Time"  value="<?php echo $detail['opening_time'];?>" required >
          </div>
          <?php echo form_error('opening_time','<label class="alert-danger">','</label>');?>
          </div>



          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 padding-right">
          <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
          <input id="closing_time" class="timepicker form-control" name="closing_time" placeholder="Closing Time"  value="<?php echo $detail['closing_time'];?>" required> 
          </div>
          <?php echo form_error('closing_time','<label class="alert-danger">','</label>');?>
          </div>
          
          </div>
     </div>


   
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-align mrg-top-bottom-r">
          <button id="submit" type="submit" class="btn btn-success" value="submit">Udate</button>
          </div>



<?php echo form_close();?>

</div>
</div>
</div>
<footer class="panel-footer">
      <div class="row">
        
         <?php //echo $link;?> 
      </div>
    </footer>
  </div>
</div>
</section>

<!--main content end-->
 <!-- footer -->
      <div class="footer">
      <div class="wthree-copyright">
        <p>© 2017 Visitors. All rights reserved | Design by </p>
      </div>
      </div>
  <!-- / footer -->
</section>
