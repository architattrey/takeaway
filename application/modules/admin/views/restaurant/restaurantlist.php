<section id="main-content">
  <section class="wrapper">
    <div class="table-agile-info">
  <div class="panel panel-default">
   <div class="row w3-res-tb">
      <div class="col-sm-7 col-md-7 col-xs-12 m-b-xs">
       <div class="panel-heading">List of Added Restaurants</div>
     </div>
     
     <div class="col-sm-5 col-md-5 col-xs-12">
      <div class="add-more-r"><a href="<?php echo base_url().$this->uri->segment(1)?>/restaurant/addRestaurant">Add More Restaurants</a></div>
     </div>
    </div>
    
   <div class="row w3-res-tb">
    <form method="GET">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle" name ="status">
          <option value="">Select</option>
          <option value="<?php  echo ACTIVE;?>">Active</option>
          <option value="<?php echo INACTIVE;?>">Inactive</option>
          <option value="<?php echo BLOCKED;?>">Blocked</option>
        </select>
        <button type="submit" class="btn btn-sm btn-default">Apply</button>
        <button type="button" class="btn btn-sm btn-default" onclick="window.location.href='<?php echo base_url().$this->uri->segment(1)?>/restaurant'">Reset</button>                 
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
    <div class="table-responsive">
      <table  cellpadding="10">
        <thead>
          <tr class="tr-bg">
            <th> No</th>
            <th>Restaurant Name</th>
            <th>Email Address</th>
            <th>Contact Number</th>
            <th>Address</th>
             <th>Status</th>
             <th>Date of Adding</th>
             <th>Opening Hours</th>
             <th>Action</th>
          </tr>
        </thead>
        <tbody>

        <?php if(!empty($restaurant) && $restaurant['count']>0):   
                unset($restaurant['count']);
                foreach( $restaurant as $key =>$val):
        ?>            
                      <tr>
                        <td><?php echo ++$key;?></td>
                        <td><?php echo ucfirst($val['name']);?></td>
                        <td><?php echo $val['email'];?></td>
                        <td><?php echo $val['phone'];?></td>
                         <td><?php echo $val['address'];?></td>
                        <td id ="status_<?php echo $val['restaurant_id'];?>"><?php echo ($val['status']==ACTIVE)?"Active":(($val['status']==INACTIVE)?"Inactive":"Blocked");?></td>
                        <td><?php echo $this->Common_model->setDate($val['created_at']);?></td>
                        <td><?php echo $val['opening_time'].' to '.$val['closing_time'];?></td>
                        <td>
                        <table>
                        <tr>
                        <td><a href="<?php echo base_url().$this->uri->segment(1)."/restaurant/detail?id=".$this->Common_model->encrypt($val['restaurant_id']);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>

                        <?php if($val['status']==ACTIVE || $val['status']==INACTIVE){?>
                        
                        <td id="block_<?php echo $val['restaurant_id'];?>" onclick="blockUser('restaurant','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($val['restaurant_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this restaurant?','Block')"><a href="javascript:void(0)"><i class="fa fa-ban"></i></a></td>

                        <td style="display:none;" id="unblock_<?php echo $val['restaurant_id'];?>" onclick="blockUser('restaurant','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($val['restaurant_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this restaurant?','UnBlock')"><a href="javascript:void(0)"><i class="fa fa-unlock"></i></a></td>

                        <?php } else{?>
                        <td style="display:none;" id="block_<?php echo $val['restaurant_id'];?>" onclick="blockUser('restaurant','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($val['restaurant_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this restaurant?','Block')"><a href="javascript:void(0)"><i class="fa fa-ban"></i></a></td>

                        <td  id="unblock_<?php echo $val['restaurant_id'];?>" onclick="blockUser('restaurant','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($val['restaurant_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this restaurant?','UnBlock')"><a href="javascript:void(0)"><i class="fa fa-unlock"></i></a></td>
                        <?php } ?>
                        <!-- <td><i class="fa fa-trash"></td> -->
                           <td><a href="<?php echo base_url().$this->uri->segment(1)."/restaurant/FetchDataForUpdateRestaurant?id=".$this->Common_model->encrypt($val['restaurant_id']);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                           <td id="delete<?php echo  $val['restaurant_id'];?>" onclick="deleteRestaurant('<?php echo $this->Common_model->encrypt( $val['restaurant_id']);?>','admin/ajax/deleteRestaurant','Do you really want to delete this Restaurant?')"><a href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                        </tr>
                        </table>
                        </td>
                      </tr>
          <?php endforeach;
                else:
                echo "<tr><td colspan='8'>No data found.</td></tr>";
                endif;
          ?>
         
      <!--  <tr>
            <td style="text-align:left;" colspan="4">Total Amount</td>
            <td>RM 1100</td>
            <td colspan="2"></td>
          </tr> -->
      
      
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
         <?php// echo $link;?> 
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