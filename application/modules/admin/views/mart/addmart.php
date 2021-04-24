<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
  <div class="panel-heading">List of Added Marts &nbsp; Add More Marts</div>
   <div class="row w3-res-tb">
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		 
     </div>
    </div>
    <?php if (isset($message)) { ?>
 <h4 style="color:green;"><?php echo $message?></h4><br>
<?php } ?>
    <div class="row w3-res-tb">
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		 <div class="heading-r underline-rest">Add More Mart</div>
<?php echo form_open("", array( 'id' => 'add_mart_form'));?>


          <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
          <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
          <input id="martname" type="text" class="form-control" name="name" placeholder="Enter Mart Name" maxlength="20" value="<?php echo set_value('name')?>" required >
          </div>
          <?php echo form_error('name','<label class="alert-danger">','</label>');?>
          </div>


         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
          <input id="number" type="number" class="form-control" name="phone" placeholder="Enter Phone Number" maxlength="13" value="<?php echo set_value('phone')?>" required >
         </div>
         <?php echo form_error('phone','<label class="alert-danger">','</label>');?>
         </div>



         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
          <input id="email" type="email" class="form-control" name="email" placeholder="Enter Email Address" maxlength="100" value="<?php echo set_value('email')?>" required > 
         </div>
         <?php echo form_error('email','<label class="alert-danger">','</label>');?>
         </div>



         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
           <input type="hidden" id="latitude" name="lat" >
           <input type="hidden" id ="longitude" name ="lng" >
          <input id="address" type="text" class="form-control" name="address" placeholder="Address" maxlength="100" value="<?php echo set_value('address')?>" required >
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
          <input id="banner_image" type="file" class="form-control" placeholder="Upload Image" name = "banner_image" value="<?php echo set_value('banner_image')?>" required >
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

          <input id="logo_image" type="file" class="form-control" placeholder="Upload Image"  name ="logo_image" value="<?php echo set_value('logo_image')?>" required>   
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
          <input id="opening_time" class="timepicker form-control" name="opening_time" placeholder="Opening Time"  value="<?php echo set_value('opening_time')?>" required />
          </div>
          <?php echo form_error('opening_time','<label class="alert-danger">','</label>');?>
          </div>



          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 padding-right">
          <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
          <input id="closing_time" class="timepicker form-control" name="closing_time" placeholder="Closing Time"  value="<?php echo set_value('closing_time')?>" required/> 
          </div>
          <?php echo form_error('closing_time','<label class="alert-danger">','</label>');?>
          </div>
          
          </div>
     </div>






    <?php// pr($detail);?>
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		     <div class="heading-r underline-rest">Menu Details</div>
           <div class="col-sm-12 col-md-12 col-xs-12">
           <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 padding-0px">
           <div class="form-group">
           <label>Select Category</label>
           <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
              <select class="form-control" id="sel1" name="category_id" required >
              <option value="">Select Food Type</option>
              <?php foreach ($detail as $key=>$val): ?>
          
               <option value="<?php echo isset($val['category_id'])?$val['category_id']:'NA'; ?>"><?php echo isset($val['category_name'])?$val['category_name']:'empty';?></option>

                <?php endforeach; ?>
              </select>
            </div>
            <?php echo form_error('category_id','<label class="alert-danger">','</label>');?>
           </div>
           </div>
           </div>






           <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
           <div class="input-group">
           <span class="input-group-addon"><i class="glyphicon glyphicon-cutlery"></i></span>
           <input type="text" class="form-control" id="product_name"  name="product_name" placeholder="Enter Product Name" maxlength="100" value="<?php echo set_value('product_name')?>" required  >
           </div>
           <?php echo form_error('product_name','<label class="alert-danger">','</label>');?>
           </div>



           <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
           <div class="input-group">
           <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
           <input id="quantity" type="text" class="form-control" name="quantity" placeholder="Enter Quantity" maxlength="8" value="<?php echo set_value('quantity')?>" required >
           </div>
           <?php echo form_error('quantity','<label class="alert-danger">','</label>');?>
           </div>



           <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
           <div class="input-group">
           <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
           <input id="price" type="text" class="form-control" name="price" placeholder="Price" maxlength="9" value="<?php echo set_value('price')?>"  required>
           </div>
           <?php echo form_error('price','<label class="alert-danger">','</label>');?>
           </div>





         
           <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
           <div class="form-group">
            <!-- <input type="file" name="img[]" class="file"> -->
           <div class="input-group col-xs-12">
           <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                     <input type="hidden" name="food_img_path" id="food_img_path">

           <input id="food_image" type="file" class="form-control"  placeholder="Upload Image" name="food_image" value="<?php echo set_value('food_image')?>" required >
           <span class="input-group-btn">
            <!--  <button class="browse btn btn-primary" type="button">Browse</button> -->
            </span>
            </div>
           
            </div>
            </div>
             <?php echo form_error('food_image','<label class="alert-danger">','</label>');?>
          
          
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-align mrg-top-bottom-r">
          <button id="submit" type="submit" class="btn btn-success" value="submit">Save</button>
          </div>



<?php echo form_close();?>
     </div>
     
     
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border-top">
     
     <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12">
     <div class="heading-r underline-rest">OR</div>
          <div class="form-group">
            <input type="file" name="img[]" class="file">
            <div class="input-group col-xs-12">
              <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
              <input type="text" class="form-control" disabled placeholder="Upload .csv file">
              <span class="input-group-btn">
                <button class="browse btn btn-primary" type="button">Browse</button>
              </span>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mrg-top-bottom-r padding-0px">
          <button type="button" class="btn btn-success"> Add </button>
          </div>
          </div>
       
     
     </div>
   
     
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
