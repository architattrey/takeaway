<div class="log-w3">

<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12"></div>
<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
<div class="w3layouts-main">
	
	<h2><img src="admin/images/logo.png" alt="" class="img-responsive"></h2>

		<?php echo form_open(base_url().'admin/reset-password?'.$key,array('id'=>'admin_resetpass_form'));?>
			<input type="password" class="ggg" name="newPassword" placeholder="ENTER NEW PASSWORD" value="<?php echo set_value('newpassword')?>" maxlength="30" id="new_password">
			<?php echo form_error('newpassword','<label class="alert-danger">','</label>');?>
			<input type="password" class="ggg" name="confirmPassword" placeholder="ENTER CONFIRM PASSWORD" value="<?php echo set_value('confirmPassword')?>" maxlength="30">
			<?php echo form_error('confirmPassword','<label class="alert-danger">','</label>');?>
			
				<div class="clearfix"></div>
				<!-- <a href="index.html" class="subtedbtn">login</a> -->
				<button type="submit" class="subtedbtn" value="Login">Save</button>
		<?php echo form_close();?>

</div>		
</div>
<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12"></div>

</div>