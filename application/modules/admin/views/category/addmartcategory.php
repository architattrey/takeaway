<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info height-full">
  <div class="panel panel-default">
    <div class="panel-heading">List of Added Categories &nbsp; Add More  Categories</div>
    <?php if (isset($message)) { ?>
 <h4 style="color:green;"><?php echo $message?></h4><br>
<?php }?>
  </div>
 
    <div class="row w3-res-tb">
        <div class="div-center">
      <div class="col-sm-12 col-md-12 col-xs-12 m-b-xs">
        <?php   echo form_open("admin/category/addCategory");?>
		 <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12"></div>
         <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 div-center-border">
             <div class="heading-r underline-rest" style="text-align:center;">Add Categories</div>
         <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
          <input type="hidden" name="category_type" value="<?php echo 2;?>" >
          <input id="name" type="text" class="form-control" name="category_name" placeholder="Categories Name" value="<?php echo set_value('category_name')?>" maxlength ="10" required >
          
        </div>
         <?php echo form_error('category_name','<label class="alert-danger">','</label>');?>
            <div class="col-sm-12 col-md-12 col-xs-12 text-align mrg-top-bottom-r">
          <button type="submit" class="btn btn-success">Save</button>
          </div>
         </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12"></div>
         <?php  echo form_close(); ?>
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