<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">Formulate Upgrade</div></div>
   
    <div class="row w3-res-tb formulate">
       
    
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 charges-bottom-border">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10"><div class="terms">For Users</div> <p style="color:green; text-align:center;  margin-left:45%;"><?php if(isset($message)){echo $message;}?></p></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
            
                <div class="edit-icon"><!-- <i class="fa fa-pencil-square-o take-car"  value="enable" aria-hidden="true"></i> -->
            </div></div>

        </div>

        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 charges-bottom-border-edit status_tag">

				<h4 class="car_fare formulate_head"> </h4> <h4 class="car_fare formulate_head">*Everytime Target To Upgrade One Level</h4>
               
               <?php echo form_open("admin/StatusUpgrade/updateForUser", array('id'=>"user_form",'class'=>'form horizontal'));?>
                
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Number of Usage</label>
                         <input type="hidden" name="id" value="<?php echo $this->Common_model->encrypt($forUser['id']);?>">
                        <input type="text" class="form-control take-car-show" id="no_usage" placeholder="100 Times" name="usage" value="<?php echo $forUser['usage'];?>" maxlength="10" required>
                         <?php echo form_error('usage','<label class="alert-danger">','</label>');?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Review Rate By Driver</label>
                        <input type="text" class="form-control take-car-show" id="rvw_rate" placeholder="150 Stars" name="rvw_rate_by_drvr" value="<?php echo $forUser['rvw_rate_by_drvr'];?>" maxlength="10" required>
                         <?php echo form_error('rvw_rate_by_drvr','<label class="alert-danger">','</label>');?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Money Topup</label>
                        <input type="text" class="form-control take-car-show" id="money_topup" placeholder="RM 1000" name="money_topup" value="<?php echo $forUser['money_topup'];?>" maxlength="10" required>
                         <?php echo form_error('money_topup','<label class="alert-danger">','</label>');?>
                    </div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Number of Visit</label>
                        <input type="text" class="form-control take-car-show" id="no_visit" placeholder="150 Times" name="number_of_visit" value="<?php echo $forUser['number_of_visit'];?>" maxlength="10" required>
                         <?php echo form_error('number_of_visit','<label class="alert-danger">','</label>');?>
                    </div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Number of Friend Recommend</label>
                        <input type="text" class="form-control take-car-show" id="frnd_recmnd" placeholder="10 Friend" name="frnd_recmnd" value="<?php echo $forUser['frnd_recmnd'];?>" maxlength="10" required>
                         <?php echo form_error('frnd_recmnd','<label class="alert-danger">','</label>');?>
                    </div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Number of Merchant Recommend</label>
                        <input type="text" class="form-control take-car-show" id="mrchnt_recmnd" placeholder="10 Merchant" name="mrchnt_recmnd" value="<?php echo $forUser['mrchnt_recmnd'];?>" maxlength="10" required>
                         <?php echo form_error('mrchnt_recmnd','<label class="alert-danger">','</label>');?>
                    </div>
					<br>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Number of Cancel Deal</label>
                        <input type="text" class="form-control take-car-show" id="cncl_deals" placeholder="5 Deals" name="cncl_deals" value="<?php echo $forUser['cncl_deals'];?>" maxlength="10" required>
                         <?php echo form_error('cncl_deals','<label class="alert-danger">','</label>');?>
                    </div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h4 class="car_fare formulate_head"> </h4>
                        <h4 class="car_fare formulate_head">*If User cancel 5 deals then will downgrade One Level</h4>
                    </div>
					<br>
                    
                
				<div class="clearfix"></div>
           
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     <button type="submit" class="btn btn-success" style="margin-left:65%; margin-top: 2%;">Update</button>

                    </div>
                    <?php echo form_close();?>
        </div><div class="clearfix"></div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 charges-bottom-border">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10"><div class="terms">For Drivers</div><p style="color:green; text-align:center; margin-left:45%;"><?php if(isset($message)){ echo $message;}?></p> </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"><div class="edit-icon"><!-- <i class="fa fa-pencil-square-o take-car"  value="enable" aria-hidden="true"></i> -->
            </div></div>

        </div>
<?php //pr($forDriver);?>

        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 charges-bottom-border-edit status_tag">

				<h4 class="car_fare formulate_head"> </h4> <h4 class="car_fare formulate_head">*Everytime Target To Upgrade One Level</h4>
                <form class="form horizontal" id="driver_form" action="<?php echo base_url().$this->uri->segment(1)."/StatusUpgrade/updateForDriver"?>" method="post">
                   
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Number of Deliver</label>
                        <input type="hidden" name="id" value="<?php echo $this->Common_model->encrypt($forDriver['id']);?>">
                        <input type="text" class="form-control take-car-show" id="deliver" placeholder="200 Times" name="deliver" value="<?php echo $forDriver['deliver'];?>" maxlength="10" required>
                         <?php echo form_error('deliver','<label class="alert-danger">','</label>');?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Review Rate By User</label>
                        <input type="text" class="form-control take-car-show" id="rate_user" placeholder="200 Stars" name="rvw_rate_by_user" value="<?php echo $forDriver['rvw_rate_by_user'];?>" maxlength="10" required>
                         <?php echo form_error('rvw_rate_by_user','<label class="alert-danger">','</label>');?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Credit Sell Back To Take Away</label>
                        <input type="text" class="form-control take-car-show" id="credit" placeholder="RM 2000" name="credit_sell_back" value="<?php echo $forDriver['credit_sell_back'];?>" maxlength="10" required>
                         <?php echo form_error('credit_sell_back','<label class="alert-danger">','</label>');?>
                    </div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="text" class="color-black formulate_label">Number of Cancel Deals</label>
                        <input type="text" class="form-control take-car-show" id="cancel_deals" placeholder="5 Deals" name="cancel_deals" value="<?php echo $forDriver['cancel_deals'];?>" maxlength="10" required>
                         <?php echo form_error('cancel_deals','<label class="alert-danger">','</label>');?>
                    </div>
					<br>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h4 class="car_fare formulate_head"> </h4>
                        <h4 class="car_fare formulate_head">*If Driver cancel 5 deals then will downgrade One Level</h4>
                    </div>
					<br>
                    
               
				<div class="clearfix"></div>
           
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     
                     <button type="submit" class="btn btn-success" style="margin-left:65%; margin-top: 2%;">Update</button>  
                    </div>
                     </form>
        </div><div class="clearfix"></div>



    
    </div>
  </div>
</div>
</section>

<!--main content end-->
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2017 Visitors. All rights reserved | Design by <a href="javasript:void(0)">ChromeInfotech</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->