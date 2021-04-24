<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default" style="padding-bottom:20px;">
    <div class="panel-heading">List of Added Restaurant &nbsp;  <?php echo isset($detail['name'])?$detail['name']:"NA";?> </div>
    <div class="row">
    
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 m-b-xs">
               <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 banner-spacing">
               <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
               <div class=""><img src="http://res.cloudinary.com/http-flynaut-com/image/upload/c_scale,h_360,w_1200<?php echo $detail['banner_img_path'];?>" class="img-responsive" alt="image not found" id="img-preview"></div>
               
               <div class="padding_50px">
               <img src="http://res.cloudinary.com/http-flynaut-com/image/upload/c_scale,h_300,w_200<?php echo $detail['logo_img_path'];?> " class="img-responsive" alt="image not found" id="img-preview">
               </div>
               </div>
            
               </div>
               
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
       
       <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-home" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Restaurant Name</div>
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
            <div class="para-r"><?php echo isset($detail['phone'])?$detail['phone']:"NA";?></div>
            </div>
            </div>
       </div>
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
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
            <div class="icon-r"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Operating Hours</div>
             <div class="para-r"><?php echo ($detail['opening_time'] && $detail['closing_time']?$detail['opening_time'].' To '.$detail['closing_time']:"NA")?></div>
            </div>
            </div>
       </div>
       
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="icon-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Date of Joining</div>
             <div class="para-r"><?php
                                        $time = strtotime($detail['created_at']);
                                        $forView = date("m/d/y", $time);
                                        echo isset($forView )?$forView:"NA";?></div>
            </div>
            </div>
       </div>
       
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="glyphicon glyphicon-move" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Orders Completed</div>
             <div class="para-r"><?php echo isset($detail['cmpltd_ordrs'])?$detail['cmpltd_ordrs']:"NA";?></div>
            </div>
           </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Ongoing Orders</div>
             <div class="para-r"><?php echo isset($detail['ongng_ordrs'])?$detail['ongng_ordrs']:"NA";?></div>
            </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Cancelled Orders</div>
             <div class="para-r"><?php echo isset($detail['cncld_ordrs'])?$detail['cncld_ordrs']:"NA";?></div>
             </div>
            </div>
       </div>
       
       <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mrg-r">
            <div class="main-info">
            <div class="iconn">
            <div class="icon-r"><i class="fa fa-money" aria-hidden="true"></i></div>
            </div>
            <div class="iconn">
            <div class="heading-r">Total Payment Earned</div>
             <div class="para-r"><?php echo isset($detail['ernd_pymnt'])?$detail['ernd_pymnt']:"NA";?></div>
            </div>
            </div>
       </div>
       
       
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div class="main-restaurant">
           		<div class="restaurant-btn view-deals"><a href="mart-item-user-always-pics.html">Item User Always Pics</a></div>
                <div class="restaurant-btn view-deals"><a href="mart-deals-history.html">View Deals</a></div>
           </div>
           </div>
                     
      </div>
    
    
    
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    <div class="bg-addr-more">
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12"><div class="menu-r">Menu</div></div>
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12"><div class="add-morr-r"><a href="<?php echo base_url().$this->uri->segment(1)."/restaurant/addProduct?name=". $detail['name'];?>">Add More Products</a></div></div>
    </div>
    </div>
    
    
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    
    <div class="table-responsive">
      <table id="products" cellpadding="10">
    <thead>
    <tr class="tr-bg">
        <th>S.No</th>
        <th>Image</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price </th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tr class="parent">
        <td style="font-size: 15px; color: #000;font-weight:600;">1</td>
        <td  style="font-size: 15px; color: #000;font-weight:600;" colspan="4">Category 1</td>
        <td><a href="#" class="glyphicon glyphicon-plus"  style="font-size: 15px; color: #000;font-weight:600;"></a></td>
 
    </tr>
    <!-- <tr>
        <td>1.1</td>
        <td><a class="example-image-link" href="images/g3.jpg" data-lightbox="example-1"><img class="example-image dish-img" src="images/g3.jpg" alt="image-1" /></a></td>
        <td>Product Name</td>
        <td>2</td>
        <td>RM 12</td>
        <td><i class="glyphicon glyphicon-pencil"></i></td>
    </tr>
    <tr>
        <td>1.2</td>
        <td><a class="example-image-link" href="images/g3.jpg" data-lightbox="example-1"><img class="example-image dish-img" src="images/g3.jpg" alt="image-1" /></a></td>
        <td>Product Name</td>
        <td>2</td>
        <td>RM 12</td>
        <td><i class="glyphicon glyphicon-pencil"></i></td>
    </tr>
    <tr>
        <td>1.3</td>
        <td><a class="example-image-link" href="images/g3.jpg" data-lightbox="example-1"><img class="example-image dish-img" src="images/g3.jpg" alt="image-1" /></a></td>
        <td>Product Name</td>
        <td>2</td>
        <td>RM 12</td>
        <td><i class="glyphicon glyphicon-pencil"></i></td>
    </tr>
    <tr>
        <td>1.4</td>
        <td><a class="example-image-link" href="images/g3.jpg" data-lightbox="example-1"><img class="example-image dish-img" src="images/g3.jpg" alt="image-1" /></a></td>
        <td>Product Name</td>
        <td>2</td>
        <td>RM 12</td>
        <td><i class="glyphicon glyphicon-pencil"></i></td>
    </tr>
    <tr>
        <td>1.5</td>
        <td><a class="example-image-link" href="images/g3.jpg" data-lightbox="example-1"><img class="example-image dish-img" src="images/g3.jpg" alt="image-1" /></a></td>
        <td>Product Name</td>
        <td>2</td>
        <td>RM 12</td>
        <td><i class="glyphicon glyphicon-pencil"></i></td>
    </tr>
    -->
   
</tbody>
       