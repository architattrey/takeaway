<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
  <div class="panel-heading">List of Added Marts &nbsp;  Add More Products For &nbsp; <?php echo isset($name['name'])?$name['name']:"NA";?></div>
   <div class="row w3-res-tb">
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		 
     </div>
    </div>
    <?php if (isset($message)) { ?>
     <h4 style="color:green;"><?php echo $message?></h4><br>
    <?php } ?>
    
    <div class="row w3-res-tb">
      
     
     <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
   		 <div class="heading-r underline-rest">Add More Products</div>
         <?php echo  form_open("",array('id'=>'add_mart_form'));?>
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
           </div>
        </div>
         <?php echo form_error('category_id','<label class="alert-danger">','</label>');?>
         </div>


         <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-cutlery"></i></span>
          <input id="product_name" type="text" class="form-control" name="product_name" placeholder="Enter Product Name" maxlength="100" value="<?php echo set_value('product_name')?>" required >
        </div>
         </div>
           <?php echo form_error('product_name','<label class="alert-danger">','</label>');?>


         <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
          <input id="quantity" type="text" class="form-control" name="quantity" placeholder="Enter Quantity" maxlength="8" value="<?php echo set_value('quantity')?>" required >
        </div>
         </div>
            <?php echo form_error('quantity','<label class="alert-danger">','</label>');?>

         <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
          <input id="price" type="text" class="form-control" name="price" placeholder=" Enter Price" maxlength="9" value="<?php echo set_value('price')?>"  required>
        </div>
         </div>
          <?php echo form_error('price','<label class="alert-danger">','</label>');?>


         
         <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
          <div class="form-group">
           <!--  <input type="file" name="img[]" class="file"> -->
            <div class="input-group col-xs-12">
              <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
               <input type="hidden" name="food_img_path" id="food_img_path">
              <input type="file" class="form-control" id="food_image"   placeholder="Upload Image" name="food_image" required>
              <span class="input-group-btn">
              <!--   <button class="browse btn btn-primary" type="button">Browse</button> -->
              </span>
            </div>
          </div>
          </div>
          <?php echo form_error('food_image','<label class="alert-danger">','</label>');?>
          
          
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-align mrg-top-bottom-r">
          <button type="submit" class="btn btn-success">Save </button>
          </div>
         <?php echo form_close();?>
     </div>
     
     
     
   
     
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
</section>