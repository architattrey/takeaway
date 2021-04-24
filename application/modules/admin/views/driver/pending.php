<section id="main-content">
  <section class="wrapper">
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of Pending Drivers</div>
    <div class="row w3-res-tb">
    <form method="GET">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle" name ="status">
          <option value="">Select</option>
          <option value="<?php echo ACTIVE;?>">Active</option>
          <option value="<?php echo INACTIVE;?>">Inactive</option>
          <option value="<?php echo BLOCKED;?>">Blocked</option>
        </select>
        <button type="submit" class="btn btn-sm btn-default">Apply</button> 
        <button type="button" class="btn btn-sm btn-default" onclick="window.location.href='<?php echo base_url().$this->uri->segment(1)?>/driver/pending'">Reset</button>                 
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
      <table  cellpadding="10">
        <thead>
          <tr class="tr-bg">
            <th>No</th>
            <th>Name</th>
            <th>Email Address</th>
            <th>Contact Number</th>
            <th>Category</th>
            <th>Vehicle Type</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>


        <?php if(!empty($Driver) && $Driver['count']>0):   

        
                     // pr($Driver);                                     

                unset($Driver['count']);
                foreach($Driver as $key =>$val):
        ?>            
                      <tr>
                        <td><?php echo ++$key;?></td>
                        <td><?php echo ucfirst($val['name']);?></td>
                        <td><?php echo $val['email'];?></td>
                        <td><?php echo $val['country_code']."-".$val['mobile'];?></td>
                        <td><?php echo $val['title'];?></td>
                        <td><?php echo ($val['vechile_type'] == 1 && 2)? "car,bike":"NA"; ?></td>
                        
                        <td id ="status_<?php echo $val['driver_id'];?>"><?php echo ($val['status']==ACTIVE)?"Active":(($val['status']==INACTIVE)?"Inactive":"Blocked");?></td>

                        <td><?php echo $this->Common_model->setDate($val['created_at']);?></td>
                        <td>
                         <table>
                        <tr>
                        <td><a href="<?php echo base_url().$this->uri->segment(1)."/driver/detail?id=".$this->Common_model->encrypt($val['driver_id']);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>

                         <?php if($val['status']==ACTIVE ||$val['status']==INACTIVE){?>
                        
                        <td id="block_<?php echo $val['driver_id'];?>" onclick="blockUser('driver','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($val['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this driver?','Block')"><a href="javascript:void(0)"><i class="fa fa-ban"></i></a></td>

                        <td style="display:none;" id="unblock_<?php echo $val['driver_id'];?>" onclick="blockUser('driver','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($val['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this driver?','UnBlock')"><a href="javascript:void(0)"><i class="fa fa-unlock"></i></a></td>

                        <?php } else{?>
                        <td style="display:none;" id="block_<?php echo $val['driver_id'];?>" onclick="blockUser('driver','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($val['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this driver?','Block')"><a href="javascript:void(0)"><i class="fa fa-ban"></i></a></td>

                        <td  id="unblock_<?php echo $val['driver_id'];?>" onclick="blockUser('driver','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($val['driver_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this driver?','UnBlock')"><a href="javascript:void(0)"><i class="fa fa-unlock"></i></a></td>


                        <?php } ?>

                        <td  id="verified_<?php echo $val['driver_id'];?>" onclick="verifyDriver('driver','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($val['driver_id']);?>','admin/ajax/verifyDriver','Do you really want to verified this driver?','Verified')"><a href="javascript:void(0)"><i class="fa fa-check"></i></a></td>


                        <td  id="verified_<?php echo $val['driver_id'];?>" onclick="rejectDriver('<?php echo $this->Common_model->encrypt($val['driver_id']);?>','<?php echo $val['email'];?>')"><a href="javascript:void(0)"><i class="fa fa-close" style="color: red;"></i></a></td>
                         
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
        
         <?php echo $link;?> 
      </div>
    </footer>
  </div>
</div>


<footer class="panel-footer">
      <div class="row">
        
         <?php echo $link;?> 
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