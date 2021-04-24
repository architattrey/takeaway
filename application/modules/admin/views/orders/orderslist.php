 <section id="main-content">
  <section class="wrapper">
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of User</div>

<div class="row w3-res-tb">
    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 tab-main-r padding-0px">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 padding-0px">
    <div class="tab-r tab-active-r"><a href="<?php echo base_url().$this->uri->segment(1)."/Orders?module_type=".$this->Common_model->encrypt(1);?>">Mart Orders</a></div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 padding-0px">
    <div class="tab-r"><a  href="<?php echo base_url().$this->uri->segment(1)."/Orders?module_type=".$this->Common_model->encrypt(2);?>">Food Orders</a></div>
    </div>
    </div>
    </div>

    <div class="row w3-res-tb">
    <form method="GET">
      <div class="col-sm-5 m-b-xs">
        <input type="hidden" name="module_type" value="<?php echo $_GET['module_type'];?>">
        <select class="input-sm form-control w-sm inline v-middle" name ="status">
          <option value="">Select</option>
          <option value="<?php echo 1;?>">Pending</option>
          <option value="<?php echo 2;?>">Paid</option>
          <option value="<?php echo 3;?>">Delivered</option>
        </select>
         
        <button type="submit" class="btn btn-sm btn-default">Apply</button> 
        <button type="button" class="btn btn-sm btn-default" onclick="window.location.href='<?php echo base_url().$this->uri->segment(1)."/Orders?module_type=".$this->Common_model->encrypt(1);?>'">Reset</button>                 
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          


          <input type="text" class="input-sm form-control" placeholder="Search" name="search" value="<?php echo isset($search)?$search:""?>">

          
          
          <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-default" type="button">Go</button>
             
          </span>
          
        </div>
      </div>
      </form>
    </div>

    <input type="hidden" name="<?php echo $csrfName;?>" value="<?php echo $csrfToken;?>" id="csrf">
    <label id="error"></label>
    <div class="table-responsive">
          <table cellpadding="10">
        <thead>
          <tr class="tr-bg">
             <th> No</th>
             <th>User Name</th>
             <th>User Address</th>
             <th>Gender</th>
             <th>User Contact Number</th>
             <th>Email</th>
             <th>Total Amount</th>
             <th>Estimated Amount</th>
             <th>GST in %</th>
             <th>Delivery Amount</th>
             <th>Address</th>
             <th>Status</th>
             <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php 
              if(!empty($orders) && $orders['count']>0):
                unset($orders['count']);
                foreach($orders as $key =>$val):
        ?>            
                      <tr>
                        <td><?php echo ++$key;?></td>
                        <td><?php echo $val['name'];?></td>
                        <td><?php echo ($val['is_current_address']==1)?$val['user_address']:(($val['is_current_address']==0)?$val['address']:"NA");?></td>
                        <td><?php echo ($val['gender']==1)?"Male":(($val['gender']==2)?"Female":"Other")?></td>
                        <td><?php echo $val['country_code']." ".$val['mobile'];?></td>
                        <td><?php echo $val['email'];?></td>
                        <td><?php echo $val['total_amount']." "."RM";?></td>
                        <td><?php echo $val['estimated_amt']." "."RM";?></td>
                        <td><?php echo $val['gst'];?></td>
                        <td><?php echo $val['delivery_amount']." "."RM";?></td>
                        <td><?php echo $val['module_address'];?></td>
                    <td id ="status_<?php echo $val['module_id'];?>"><?php echo ($val['status']==1)?"Pending":(($val['status']==2)?"Paid":"Delivered");?></td>

                       
                        <td>
                        <table>
                          <tbody>
                        <tr>
                        <td> <a href="<?php echo base_url().$this->uri->segment(1)."/orders/detail?order_id=".$this->Common_model->encrypt($val['order_id']);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>

                      


                        <!-- <td><i class="fa fa-trash"></td> -->
                        </tr>
                        </tbody>
                        </table>
                        </td>
                      </tr>

          <?php endforeach;
                else:

                echo "<tr><td colspan='8'>No data found.</td></tr>";
                endif;
          ?>
         
     
      
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
         <?php //echo $link;?> 
      </div>
    </footer>
  </div>
</div>
</section>

<!--main content end-->
 <!-- footer -->
      <div class="footer">
      <div class="wthree-copyright">
        <p>© 2017 Visitors. All rights reserved | Design by </p>
      </div>
      </div>
  <!-- / footer -->
</section>