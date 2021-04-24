<section id="main-content">
			<section class="wrapper">
			<div class="table-agile-info">
           <div class="panel panel-default">
            <div class="row">
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="panel-heading">List of User <?php echo isset($detail['name'])?$detail['name']:"NA";?></div>
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="col-sm-10 col-xs-12 col-md-6 col-lg-10">
                

      <?php if($detail['status']==ACTIVE || $detail['status']==INACTIVE){?>
                        
      <div  class="blockk" id="block_<?php echo $detail['user_id'];?>" onclick="blockUser('user','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($detail['user_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this user?','Block')"><a href="javascript:void(0)">BLOCK</a></div>

      <div class="blockk" style="display:none;" id="unblock_<?php echo $detail['user_id'];?>" onclick="blockUser('user','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($detail['user_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this user?','UnBlock')"><a href="javascript:void(0)">UNBLOCK</a></div>

      <?php } else { ?>

      <div class="blockk" style="display:none;" id="block_<?php echo $detail['user_id'];?>" onclick="blockUser('user','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($detail['user_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this user?','Block')"><a href="      javascript:void(0)">BLOCK</a></div>

      <div class="blockk" id="unblock_<?php echo $detail['user_id'];?>" onclick="blockUser('user','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($detail['user_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this user?','UnBlock')"><a href="javascript:void(0)">UNBLOCK</a></div>

      <?php } ?>


            </div>
            <div class="col-sm-2 col-xs-12 col-md-6 col-lg-2">
            <div class="fa-edit-r"><i class="fa fa-pencil-square-o" data-toggle="modal" data-target="#myModal" aria-hidden="true"></i></div>
            </div>
            </div>
            </div>
            </div>
            <div class="row w3-res-tb">                   
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 m-b-xs">
               <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 mrg-bottom-r">
               <div class="user-profile"><img src="../public/admin/images/profile.png" class="img-responsive" alt=""></div>
               </div>
               
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
      
       <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-user" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Name</div>
             <div class="para-r"><?php echo isset($detail['name'])?$detail['name']:"NA";?></div>
             </div>
            </div>
       		
       </div>
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
             <div class="main-info">
             <div class="iconn">
            <div class="icon-r"><i class="fa fa-phone" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
             <div class="heading-r">Contact Number</div>
            <div class="para-r"><?php echo isset($detail['mobile'])?$detail['country_code'].$detail['mobile']:"NA";?></div>
            </div>
            </div>
       </div>
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-envelope" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Email Address</div>
             <div class="para-r"><?php echo isset($detail['email'])?$detail['email']:"NA";?></div>
            </div>
            </div>
       </div>

       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-leanpub" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Address</div>
             <div class="para-r"><?php echo isset($detail['address'])?$detail['address']:"NA";?></div>
            </div>
            </div>
       </div>
       

        <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-line-chart" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Status</div>
           
             <div class="para-r" id ="status_<?php echo $detail['user_id'];?>"><?php echo ($detail['status']==ACTIVE)?"Active":(($detail['status']==INACTIVE)?"Inactive":"Blocked");?></div>

            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-anchor" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Orders Made</div>
             <div class="para-r"><?php echo isset($detail['total_orders_made'])?$detail['total_orders_made']:"NA";?></div>
            </div>
            </div>
       </div>
       
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Payment Used</div>
             <div class="para-r"><?php echo isset($detail['total_payment_done'])?$detail['total_payment_done']:"NA";?></div>
            </div>
            </div>
       </div>
       
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total order of Take-Car</div>
             <div class="para-r"><?php echo isset($detail['total_ride_tokens'])?$detail['total_ride_tokens']:"NA";?></div>
            </div>
           </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-anchor" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Orders of Take-Mart</div>
             <div class="para-r"><?php echo isset($detail['total_orders_of_mart'])?$detail['total_orders_of_mart']:"NA";?></div>
            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Orders of Take-Food</div>
             <div class="para-r"><?php echo isset($detail['total_orders_of_restaurent'])?$detail['total_orders_of_restaurent']:"NA";?></div>
             </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Order of Take-Sent</div>
             <div class="para-r"><?php echo isset($detail['total_sent_services'])?$detail['total_sent_services']:"NA";?></div>
            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-cc-amex" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">E-Wallet </div>
             <div class="para-r"><?php echo isset($detail['wallet_credit_point'])?$detail['wallet_credit_point']:"NA";?></div>
            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Point</div>
             <div class="para-r"><?php echo isset($detail['points'])?$detail['points']:"NA";?></div>
            </div>
            </div>
       </div> 
           
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           		<div class="view-deals"><a href="javascript:void(0);">View Deals</a></div>
           </div>
                     
      </div>
      
      
    </div>
    
    
  </div>
</div>
			
			</section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2017 Visitors. All rights reserved | Design by <a href="javascript:void(0)"></a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>