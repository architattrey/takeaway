<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of Vehicles</div>
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
        <button type="button" class="btn btn-sm btn-default" onclick="window.location.href='<?php echo base_url().$this->uri->segment(1)?>/vehicile'">Reset</button>                 
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
            <th>Vehicle</th>
            <th>Colour</th>
            <th>Number</th>
            <th>Model</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

        <?php if(!empty($vehicile) && $vehicile['count']>0):   
                unset($vehicile['count']);
                foreach( $vehicile as $key =>$val):
        ?>            
                      <tr>
                        <td><?php echo ++$key;?></td>
                        <td><?php echo ucfirst($val['vechile_name']);?></td>
                        <td><?php echo $val['vechile_color'];?></td>
                        <td><?php echo $val['vechile_number'];?></td>
                        <td><?php echo $val['vechile_model'];?></td>


                        <td id ="status_<?php echo $val['vechile_id'];?>"><?php echo ($val['status']==ACTIVE)?"Active":(($val['status']==INACTIVE)?"Inactive":"Blocked");?></td>

                        <td><?php echo $this->Common_model->setDate($val['created_at']);?></td>
                        <td>
                        <table>
                        <tr>
                        <td><a href="<?php echo base_url().$this->uri->segment(1)."/vehicile/detail?id=".$this->Common_model->encrypt($val['vechile_id']);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>

                        <?php if($val['status']==ACTIVE || $val['status']==INACTIVE){?>
                        
                        <td id="block_<?php echo $val['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($val['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this Vehicle?','Block')"><a href="javascript:void(0)"><i class="fa fa-ban"></i></a></td>

                        <!-- (type,status,id,url,msg,action send ho rha yha se javascrit  -->

                        <td style="display:none;" id="unblock_<?php echo $val['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($val['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this Vehicle?','UnBlock')"><a href="javascript:void(0)"><i class="fa fa-unlock"></i></a></td>

                        <?php } else{?>
                        <td style="display:none;" id="block_<?php echo $val['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo BLOCKED;?>','<?php echo $this->Common_model->encrypt($val['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to block this Vehicle?','Block')"><a href="javascript:void(0)"><i class="fa fa-ban"></i></a></td>

                        <td  id="unblock_<?php echo $val['vechile_id'];?>" onclick="blockUser('vehicile','<?php echo ACTIVE;?>','<?php echo $this->Common_model->encrypt($val['vechile_id']);?>','admin/ajax/changeUserStatus','Do you really want to unblock this Vehicle?','UnBlock')"><a href="javascript:void(0)"><i class="fa fa-unlock"></i></a></td>
                        <?php } ?>
                        <!-- <td><i class="fa fa-trash"></td> -->

                           <td id="delete<?php echo  $val['vechile_id'];?>" onclick="deleteVechile('<?php echo $this->Common_model->encrypt( $val['vechile_id']);?>','admin/ajax/deleteVechile','Do you really want to delete this Vehicle?')"><a href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
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