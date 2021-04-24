<section id="main-content">
			<section class="wrapper">
			<div class="table-agile-info">
           <div class="panel panel-default">
            <div class="row">
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="panel-heading">List of Vehicles &nbsp;- <?php echo isset($detail['vechile_name'])?$detail['vechile_name']:"NA";?>
                  
            </div>
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="col-sm-10 col-xs-12 col-md-6 col-lg-10">

<?php if($detail['status']==ACTIVE || $detail['status']==INACTIVE){?>
                        
                        <div class="blockk" id="block_<?php echo $detail['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($detail['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this Vehicle?','Block')"><a href="javascript:void(0)">BLOCK</a></div>

                        <!-- (type,status,id,url,msg,action send ho rha yha se javascrit  -->

                        <div class="blockk" style="display:none;" id="unblock_<?php echo $detail['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($detail['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this Vehicle?','UnBlock')"><a href="javascript:void(0)">UNBLOCK</a></div>

                        <?php } else{?>

                        <div class="blockk" style="display:none;" id="block_<?php echo $detail['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($detail['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this Vehicle?','Block')"><a href="javascript:void(0)">BLOCK</a></div>

                        <div class="blockk"  id="unblock_<?php echo $detail['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($detail['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this Vehicle?','UnBlock')"><a href="javascript:void(0)">UNBLOCK</a></div>
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
               <div class="user-profile"><img src="../public/admin/images/<?php echo $detail['image'];?>" class="img-responsive" alt="image not loaded cause of reasons"></div>
               </div>
               
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
       
       <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-cab" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Name</div>
             <div class="para-r"><?php echo isset($detail['vechile_name'])?$detail['vechile_name']:"NA";?></div>
             </div>
            </div>
       		
       </div>
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
             <div class="main-info">
             <div class="iconn">
            <div class="icon-r"><i class="fa fa-cab" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
             <div class="heading-r">Vehicle Colour</div>
            <div class="para-r"><?php echo isset($detail['vechile_color'])?$detail['vechile_color']:"NA";?></div>
            </div>
            </div>
       </div>
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-cab" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Vehicle Model</div>
             <div class="para-r"><?php echo isset($detail['vechile_model'])?$detail['vechile_model']:"NA";?></div>
            </div>
            </div>
       </div>

       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-cab" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Vehicle Number</div>
             <div class="para-r"><?php echo isset($detail['vechile_number'])?$detail['vechile_number']:"NA";?></div>
            </div>
            </div>
       </div> 

       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-user" aria-hidden="true"></i> </div>
            </div>
            <div class="iconn">
            <div class="heading-r">Driver Name Of The Vehicle</div>
             <div class="para-r"><?php echo isset($detail['name'])?$detail['name']:"NA";?></div>
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
             <div class="para-r" id ="status_<?php echo $detail['vechile_id'];?>"><?php echo ($detail['status']==ACTIVE)?"Active":(($detail['status']==INACTIVE)?"Inactive":"Blocked")?></div>
            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-phone" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Driver Contact Number</div>
             <div class="para-r"><?php echo ($detail['country_code'] && $detail['mobile'])?$detail['country_code']." ".$detail['mobile']:"NA";?></div>
            </div>
            </div>
       </div>

        <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-phone" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Driver email</div>
             <div class="para-r"><?php echo ($detail['email'])?$detail['email']:"NA";?></div>
            </div>
            </div>
       </div>
       
       
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
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="heading-black-r underline">Certification</div> 
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