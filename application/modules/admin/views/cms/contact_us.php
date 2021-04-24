<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">Content Management System</div>
    <div class="row w3-res-tb">
    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 tab-main-r padding-0px">
    <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 padding-0px">
    <div class="tab-r"><a  href="<?php echo base_url().$this->uri->segment(1)?>/Cms">Terms And Conditions</a></div>
    </div>
    <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 padding-0px">
    <div class="tab-r"><a  href="<?php echo base_url().$this->uri->segment(1)?>/Cms/aboutUs">About Us</a></div>
    </div>
 <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 padding-0px">
    <div class="tab-r tab-active-r"><a  href="<?php echo base_url().$this->uri->segment(1)?>/Cms/contactUs">Contact Us</a></div>
    </div>
    </div>
    </div>
 
     <div class="row w3-res-tb">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php if (isset($message)) { ?>
 <h4 style="color:green;"><?php echo $message?></h4><br>
<?php } ?>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10"><div class="terms">Contact Us</div></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"><div class="edit-icon"></div></div>
     <form action="<?php echo base_url().$this->uri->segment(1)."/cms/updateContactUs";?>" method="post">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conrt-mrg">
                <div class="content-border col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="content-para">
                    <input type="hidden" name="id" value="<?php echo $this->Common_model->encrypt($para['id']);?>"> 
                    <textarea name="contact_us" id="editor1" rows="8" cols="180" class="checkeditor" required><?php echo isset($para['contact_us'])?$para['contact_us']:"NA";?>
                
            </textarea>
             
                </div>
                 <?php echo form_error('contact_us','<label class="alert-danger">','</label>');?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-0px"><div class="content-contact">Email - 
                    <span> 
                   <div style=" width:250px;"> <input  type="text" class="form-control" name="email"  value="<?php echo isset($para['email'])?$para['email']:"NA";?> "  maxlength="30" required placeholder= "enter your email"></div></span>
                       
                       <?php echo form_error('email','<label class="alert-danger">','</label>');?>
               </div></div>


                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-0px"><div class="content-contact">Contact Number - 
                    <span> 
                  <div style=" width:250px;"><input  type="text" class="form-control" name="country_code"  value="<?php echo isset($para['country_code'])?$para['country_code']:"NA";?> " required placeholder= "enter your country code"> </div>

               <div style=" width:250px; margin-top: 10px;"> <input  type="text" class="form-control" name="phone"  value="<?php echo isset($para['phone'])?$para['phone']:"NA";?> "  maxlength="10" required placeholder= "enter your contact number"></div> </span>
           <?php echo form_error('phone','<label class="alert-danger">','</label>');?></div></div>

                    



                <button type="submit" class="btn btn-success" style="margin-left:44%; margin-top: 2%;">Update</button>
                </div>

            </div>
 </form>
            <div class="clearfix"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-button">
               <!--  <button type="button" class="btn btn-success">Save</button> -->
            </div>
            
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