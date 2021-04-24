<!DOCTYPE html>
<head>
<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<base href="<?php echo base_url(); ?>public/">
<script> var baseUrl = "<?php echo base_url()?>";</script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="admin/css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="admin/css/style-responsive.css" rel="stylesheet"/>
<!-- font CSS -->


<!--<link href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">-->

<!-- font-awesome icons -->
<link rel="stylesheet" href="admin/css/font.css" type="text/css"/>
<link href="admin/css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="admin/css/morris.css" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="admin/css/monthly.css">
<link rel="stylesheet" href="admin/css/page_loder.css">


<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="admin/js/jquery2.0.3.min.js"></script>
<script src="admin/js/raphael-min.js"></script>
<!-- <script src="admin/js/morris.js"></script>
 -->
     <!-- TIME PICKER OF JQUERY -->
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
 <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

 <!-- CLOUDANRY FILES -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"></script> -->
 


</head>
<body class="">
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div id="pre-page-loader" style="display:none;">
            <div id="pre-page-loader-center">
                <div id="pre-page-loader-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                    <div class="object" id="object_five"></div>
                    <div class="object" id="object_six"></div>
                    <div class="object" id="object_seven"></div>
                    <div class="object" id="object_eight"></div>
                    <div class="object" id="object_big"></div>
                </div>
            </div>
        </div>
<?php
    $adminProfileData = $this->Common_model->fetch_data('admin','image,name',['where'=>['admin_id'=>$this->_loginId]],true);
?>
<div class="brand">
    <a href="<?php echo base_url().$this->uri->segment(1);?>" class="logo">
        <img src="admin/images/logo.png" class="img-responsive" alt="" />
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
	<ul class="nav pull-left top-menu">
	<li><p id="date-time"></p></li>
	</ul>
    <ul class="nav pull-right top-menu">
        <li>
          <!--  <input type="text" class="form-control search" placeholder=" Search">-->
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <?php if(isset($adminProfileData['image']) && $adminProfileData['image']!=""){?>
                <img alt="" src="admin/images/<?php echo $adminProfileData['image']?>">
                <?php } else {?>
                <img alt="" src="admin/images/2.png">
                <?php }?>
                <span class="username"><?php echo $adminProfileData['name'];?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="<?php echo base_url().$this->uri->segment(1)?>/change-password"><i class="fa fa-cog"></i> Change Password</a></li>
                <li><a href="<?php echo base_url().$this->uri->segment(1)?>/logout"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
