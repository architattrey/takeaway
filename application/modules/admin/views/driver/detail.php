<section id="main-content">
			<section class="wrapper">
			<div class="table-agile-info">
           <div class="panel panel-default">
            <div class="row">
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="panel-heading">List of Driver &nbsp; <?php echo isset($detail['name'])?$detail['name']:"NA";?></div>
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="col-sm-10 col-xs-12 col-md-6 col-lg-10">
            
           
<?php if($detail['status']==ACTIVE || $detail['status']==INACTIVE){?>
                        
      <div class="blockk" id="block_<?php echo $detail['driver_id'];?>" onclick="blockUser('driver','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($detail['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this driver?','Block')">
            <a href="javascript:void(0)">BLOCK</a></div>

      <div class="blockk" style="display:none;" id="unblock_<?php echo $detail['driver_id'];?>" onclick="blockUser('driver','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($detail['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this driver?','UnBlock')"><a href="javascript:void(0)">UNBLOCK</a></div>

       <?php } else{?>

      <div class="blockk" style="display:none;" id="block_<?php echo $detail['driver_id'];?>" onclick="blockUser('driver','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($detail['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this driver?','Block')">
            <a href="javascript:void(0)">BLOCK</a></div>

      <div class="blockk"  id="unblock_<?php echo $detail['driver_id'];?>" onclick="blockUser('driver','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($detail['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this driver?','UnBlock')">
            <a href="javascript:void(0)">UNBLOCK</a></div>
       <?php } ?>



            </div>
            <div class="col-sm-2 col-xs-12 col-md-6 col-lg-2">
            <div class="fa-edit-r" id="update<?php echo  $detail['driver_id'];?>" onclick="updateDriver('<?php echo $this->Common_model->encrypt($detail['driver_id']);?>','<?php echo $detail['name'];?>','<?php echo $detail['email'];?>','<?php echo $detail['mobile'];?>','admin/driver/updateDriver')"><a href="javascript:void(0)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div>
            </div>
            </div>
            </div>
            </div>
            <div class="row w3-res-tb">                   
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 m-b-xs">
               <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 mrg-bottom-r">
               <div class="user-profile"><img src="../public/admin/images/profile.png" class="img-responsive" alt="image not loaded cause of reasons"></div>
               </div>
           <?php //pr($detail);?>
            <div class="heading-black-r underline">Driver Details</div>    
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
            <div class="para-r"><?php echo isset($detail['mobile'])?$detail['country_code']." ".$detail['mobile']:"NA";?></div>
            </div>
            </div>
       </div>
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="icon-envelope" aria-hidden="true"></i> </div>
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
            <div class="icon-r"><i class="icon-envelope" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Status</div>
              <div class="para-r" id ="status_<?php echo $detail['driver_id'];?>"><?php echo ($detail['status']==ACTIVE)?"Active":(($detail['status']==INACTIVE)?"Inactive":"Blocked");?></div>
            </div>
            </div>
       </div>
          
       <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="icon-envelope" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Category</div>
            <div class="para-r"><?php echo ($detail['category_id']==1)?"Take Mart":($detail['category_id']==2)?"Take Car":($detail['category_id']==3)?"Take Food":($detail['category_id']==4?"Take Bike":"NA")?></div>
            </div>
            </div>
       </div>
            </div>
                   
       
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="heading-black-r underline">Vehicle Details</div> 
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-anchor" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Vehicle Type</div>
                        <div class="para-r"><?php echo ($detail['vechile_type']==1)?"Car":(($detail['vechile_type']==2)?"Bike":"NA")?></div>
                        </div>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-anchor" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Car / Bike Name</div>
                         <div class="para-r"><?php echo isset($detail['vechile_name'])?$detail['vechile_name']:"NA";?></div>
                        </div>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Car / Bike Number</div>
                         <div class="para-r"><?php echo isset($detail['vechile_number'])?$detail['vechile_number']:"NA";?></div>
                        </div>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Car / Bike Color</div>
                         <div class="para-r"><?php echo isset($detail['vechile_color'])?$detail['vechile_color']:"NA";?></div>
                        </div>
                       </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-anchor" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Car / Bike Model</div>
                         <div class="para-r"> <?php echo isset($detail['vechile_model'])?$detail['vechile_model']:"NA";?></div>
                        </div>
                        </div>
                   </div>
                   
                    <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-anchor" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Total Request Received</div>
                         <div class="para-r"><?php echo isset($detail['request_received'])?$detail['request_received']:"NA";?></div>
                        </div>
                        </div>
                   </div>
                   
                        <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-anchor" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Total Request Accepted</div>
                         <div class="para-r"><?php echo isset($detail['request_accepted'])?$detail['request_accepted']:"NA";?></div>
                        </div>
                        </div>
                       </div>
                       
                       <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-anchor" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Total Request Rejected</div>
                         <div class="para-r"><?php echo isset($detail['request_rejected'])?$detail['request_rejected']:"NA";?></div>
                        </div>
                        </div>
                       </div>
                       
                       <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-anchor" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Total Payment</div>
                         <div class="para-r"><?php echo isset($detail['total_payment'])?$detail['total_payment']:"NA";?></div>
                        </div>
                        </div>
                       </div>
                                 <div class="clearfix"></div>
                   
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Driving License</div>
                         <div class="para-r"><img src="<?php echo $detail['license_img'];?>" class="img-responsive" alt="server problem"></div>
                         </div>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Identity Card</div>
                         <div class="para-r"><img src="<?php echo $detail['id_card_img'];?>" class="img-responsive" alt="server problem"></div>
                        </div>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Car / Bike Certificate</div>
                         <div class="para-r"><img src="<?php echo $detail['cert_img'];?>" class="img-responsive" alt="server problem"></div>
                        </div>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Road Tax Certificate</div>
                         <div class="para-r"><img src="<?php echo $detail['road_tax_cert_img'];?>" class="img-responsive" alt="server problem"></div>
                        </div>
                        </div>
                   </div>
                            <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Car / Bike Insurance Certificate</div>
                         <div class="para-r"><img src="<?php echo $detail['insurance_img'];?>" class="img-responsive" alt="server problem"></div>
                        </div>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 mrg-r">
                        <div class="main-info">
                        <div class="iconn">
                        <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
                        </div>
                        <div class="iconn">
                        <div class="heading-r">Car / Bike Image</div>
                         <div class="para-r"><img src="<?php echo $detail['vehicle_img'];?>" class="img-responsive" alt="server problem"></div>
                        </div>
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