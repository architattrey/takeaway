<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of Added Banners</div>
    <div class="row w3-res-tb">
         <form method="get">
      <div class="col-sm-3 m-b-xs">
          <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search" name="search" value="<?php echo isset($search)?$search:""?>">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="submit">Go</button>
          </span>
        </div> 
      </div>
       </form>
      <div class="col-sm-6">
	  <div class="max-banner">Add Maximum 10 Banners</div>
      </div>
      <div class="col-sm-3">
        
        <?php
        if ($banner['count'] >=10):
        ?>
        <div class="add-more-r" style="line-height:0px; color: red;"> Can't add banner more than 10</div>
        <?php
      else:
        ?>
         <div class="add-more-r"><a href="<?php echo base_url().$this->uri->segment(1)?>/banner/addBanner" style="line-height:0px;">Add New Banner</a></div>
       <?php endif; ?>
        
      </div>
    </div>
    <div class="table-responsive">
      <table  cellpadding="10">
        <thead > 
          <tr class="tr-bg" >
            <th> No</th>
            <th>Banner Name</th>
            <th>Banner Image</th>
            <th>Uploaded Date </th>
             <th>Action</th>
          </tr>
        </thead>
        <tbody >
            <?php

            if (!empty($banner) && $banner['count']>0):
                unset($banner['count']);
                foreach ($banner as $key => $val):
            ?>
          <tr >
            <td><?php echo ++$key;?></td>
            <td><?php echo ucfirst($val['name']);?></td>
            <td>
			<a class="example-image-link" href="http://res.cloudinary.com/http-flynaut-com/image/upload/c_fill,h_360,w_900<?php echo $val['image_path'];?>" data-lightbox="example-1"><img class="example-image dish-img"  id='img-preview' src="http://res.cloudinary.com/http-flynaut-com/image/upload/c_fill,h_360,w_900<?php echo $val['image_path'];?>" alt="image not found" /></a>
			</td>
            <td><?php
                      $created_at = strtotime($val['created_at']);
                      $converteddate = date("d-M-Y",$created_at);
                      echo $converteddate;
                ?>
                
            </td>
            <td>
            <table>
            <tr>
          
             <td><a href="<?php echo base_url().$this->uri->segment(1)."/banner/detail?banner_id=".$this->Common_model->encrypt($val['banner_id']);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            <td id="delete<?php echo  $val['banner_id'];?>" onclick="deleteBanner('<?php echo $this->Common_model->encrypt( $val['banner_id']);?>','admin/ajax/deleteBanner','Do you really want to delete this banner?')"><a href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
            </tr>
            </table>
            </td>
          </tr>

          <?php 
             endforeach;
         else:
            echo "<tr><td colspan='8'>No data found.</td></tr>";
        endif;
          ?>
        </tbody>
      </table>
	  
	 <!--  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="view-deals"><a href="banner-view-deals.html">View Deals</a></div>
                   </div> -->
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