<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of Added Categories</div>
    <div class="row w3-res-tb">
    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 tab-main-r padding-0px">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 padding-0px">
    <div class="tab-r tab-active-r"><a  href="<?php echo base_url().$this->uri->segment(1)?>/Category">Food Categories</a></div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 padding-0px">
    <div class="tab-r"><a  href="<?php echo base_url().$this->uri->segment(1)?>/Category/martCategoryList">Mart Categories</a></div>
    </div>
    </div>
    </div>
<form method="GET">
     <div class="row w3-res-tb">
      <div class="col-sm-3 col-md-3 col-lg-3 col-xs-12 m-b-xs">
       <div class="input-group">

          <input type="text" class="input-sm form-control" placeholder="Search" name="search"  value="<?php echo isset($search)?$search:""?>">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="submit">Go</button>
          </span>
        </div>               
      </div>
      </form>
      <div class="col-sm-6">
      </div>
      <div class="col-sm-3 col-md-3 col-lg-3 col-xs-12">
        <div class="add-more-r"><a href="<?php echo base_url().$this->uri->segment(1)?>/category/addMartCategory"  style="line-height:0px;">Add More Categories </a>
</div>
      </div>
    </div>

  


<div class="table-responsive">
      <table cellpadding="10">
        <thead>
          <tr class="tr-bg">
            <th>No</th>
            <th>Category Name</th>
             <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if(!empty($category) && $category['count']>0):
            unset($category['count']);
            foreach ($category as $key => $val): 
              
            
          ?>
          <tr>
            <td><?php echo ++$key;?></td>
            <td><?php echo ucfirst($val['category_name']);?></td>
            <td>
            <table>
            <tbody><tr>
            <td  id="update<?php echo  $val['category_id'];?>" onclick="updateCategory('<?php echo $this->Common_model->encrypt( $val['category_id']);?>','<?php echo $val['category_name'];?>','admin/category/updateCategory')"><a href="javascript:void(0)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
             
            <td id="delete<?php echo  $val['category_id'];?>" onclick="deleteCategory('<?php echo $this->Common_model->encrypt( $val['category_id']);?>','admin/ajax/deleteCategory','Do you really want to delete this category?')"><a href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>


            </tr>
            </tbody></table>
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
	  
    </div>
  </div>
</div>


</section>
<div class="footer">
      <div class="wthree-copyright">
        <p>© 2017 Visitors. All rights reserved | Design by </p>
      </div>
      </div>
  <!-- / footer -->
</section>
