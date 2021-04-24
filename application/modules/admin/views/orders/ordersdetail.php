<section id="main-content">
			<section class="wrapper">
			<div class="table-agile-info">
           <div class="panel panel-default">
            <div class="row">
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="panel-heading">List of <?php echo ($detail['module_type']==1)?"Mart's  ":"Food's"?> Order Detail </div>
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="col-sm-10 col-xs-12 col-md-6 col-lg-10">
                
            </div>
            <div class="col-sm-2 col-xs-12 col-md-6 col-lg-2">
           <!--  <div class="fa-edit-r"><i class="fa fa-pencil-square-o" data-toggle="modal" data-target="#myModal" aria-hidden="true"></i></div> -->
            </div>
            </div>
            </div>
            </div>
            <div class="row w3-res-tb">                   
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 m-b-xs">
               <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 mrg-bottom-r">
               <div class="user-profile"><img src="../public/admin/images/profile.png?>" class="img-responsive" alt=""></div>
               </div>
               
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
      
       <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-user" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">User Name</div>
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
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">User Address</div>
             <div class="para-r"><?php echo ($detail['is_current_address']==1)?$detail['user_address']:(($detail['is_current_address']==0)?$detail['address']:"NA");?></div>
            </div>
            </div>
       </div>

       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Gender</div>
             <div class="para-r"><?php echo ($detail['gender']==1)?"Male":(($detail['gender']==2)?"Female":"Other")?></div>
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
           
             <div class="para-r" ><?php echo ($detail['status']==1)?"Pending":(($detail['status']==2)?"Paid":"Delivered");?></div>

            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-anchor" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Amount</div>
             <div class="para-r"><?php echo isset($detail['total_amount'])?$detail['total_amount']:"NA";?> RM</div>
            </div>
            </div>
       </div>
       
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Estimated Amount</div>
             <div class="para-r"><?php echo isset($detail['estimated_amt'])?$detail['estimated_amt']:"NA";?> RM</div>
            </div>
            </div>
       </div>
       
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">GST In %</div>
             <div class="para-r"><?php echo isset($detail['gst'])?$detail['gst']:"NA";?></div>
            </div>
           </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-anchor" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Delivary Amount</div>
             <div class="para-r"><?php echo isset($detail['delivery_amount'])?$detail['delivery_amount']:"NA";?> RM</div>
            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r"><?php echo ($detail['module_type']==1)?"Mart  ":'Food '?>Address</div>
             <div class="para-r"><?php echo isset($detail['module_address'])?$detail['module_address']:"NA";?></div>
             </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">User Address</div>
             <div class="para-r"><?php echo ($detail['is_current_address']==1)?$detail['user_address']:(($detail['is_current_address']==0)?$detail['address']:"NA");?></div>
            </div>
            </div>
       </div>
       
      
           
          <!--  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           		<div class="view-deals"><a href="javascript:void(0);">View Deals</a></div>
           </div>
                    -->  
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