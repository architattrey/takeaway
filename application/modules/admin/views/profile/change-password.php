<!--main content start-->
<section id="main-content">
<section class="wrapper">
<div class="row">
<div class="col-lg-4 col-md-3 col-sm-2 col-xs-12"></div>
<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
<div class="panel-body">
<div class="w3layouts-main" style="padding:0px;">
<div class="w3ls-graph">
<!--agileinfo-grap-->
<div class="">	
	<div class="change-pass-text">Change Password</div>
	<?php
             if($this->session->flashdata('message')!=''){

                echo $this->session->flashdata('message');
             }
    ?>
    <?php
             if(isset($error)){

                echo $error;
             }
    ?>
		<!-- <form action="#" method="post" style="padding:18px 35px;"> -->
<?php echo form_open("",array('id'=>'admin_changepass_form',"style"=>"padding:18px 35px"));?>

<input type="password" class="ggg" name="oldPassword" placeholder="ENTER YOUR CURRENT PASSWORD"  value="<?php echo set_value('oldPassword')?>" maxlength="30" >

<?php echo form_error('oldPassword','<label class="alert-danger">','</label>');?>

<input type="password" class="ggg" name="newPassword" placeholder="ENTER YOUR NEW PASSWORD" value="<?php echo set_value('newPassword')?>" maxlength="30" id="new_password" >
<?php echo form_error('newPassword','<label class="alert-danger">','</label>');?>


	<input type="password" class="ggg" name="confirmPassword" placeholder="CONFIRM YOUR PASSWORD" value="<?php echo set_value('confirmPassword')?>" maxlength="30" >
	<?php echo form_error('confirmPassword','<label class="alert-danger">','</label>');?>

						
							<div class="clearfix"></div>
							<input type="submit" value="Change Password" name="login">
					<!-- </form> -->
					
					</div></div>
	<!--//agileinfo-grap-->

				</div>
			</div>
		</div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-12"></div>
        </div>
			
			</section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2017 Visitors. All rights reserved | Design by <a href=""></a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
