<div class="log-w3">

<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12"></div>
<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
<div class="w3layouts-main">
	<h2><img src="admin/images/logo.png" alt="" class="img-responsive"></h2>
	<?php
             if($this->session->flashdata('message')!=''){

                echo $this->session->flashdata('message');
             }
    ?>
		<?php echo form_open("",array('id'=>'forgot_pass_form'));?>
			<input type="email" class="ggg" name="email" placeholder="ENTER E-MAIL ADDRESS" value="<?php echo set_value('email')?>" maxlength="100">
			<?php echo form_error('email','<label class="alert-danger">','</label>');?>
			<h6><a href="<?php echo base_url()?>admin">Back to login</a></h6>
				<div class="clearfix"></div>
				<!-- <a href="index.html" class="subtedbtn">login</a> -->
				<button type="submit" class="subtedbtn" value="Send">Send</button>
		<?php echo form_close();?>
</div>		
</div>
<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12"></div>

</div>