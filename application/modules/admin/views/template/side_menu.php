
<?php 

$method=$this->router->fetch_method();
$class=$this->router->fetch_class();
$this->load->model('Common_model');


?>
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
            <li>
                    <a <?php if (in_array(strtolower($class),['dashboard','businessuser'])) echo 'class="active"'?> href="javascript:void(0);">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a <?php if (in_array(strtolower($class),['user'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)?>/user">
                        <span>Manage User</span>
                    </a>
                </li>
                 <li class="sub-menu">
                    <a <?php if (in_array(strtolower($class),['driver'])) echo 'class="active"'?>  href="javascript:;">
                        <span>Manage Driver/Rider</span>
                    </a>
                    <ul class="sub">
						
                        <li><a <?php if (in_array(strtolower($class),['driver']) && $method=='pending') echo 'class="active"'?>  href="<?php echo base_url().$this->uri->segment(1)?>/driver/pending">Pending Driver/Rider </a></li>

                        <li><a <?php if (in_array(strtolower($class),['driver']) && $method=='index') echo 'class="active"'?>  href="<?php echo base_url().$this->uri->segment(1)?>/driver">Registered Driver/Rider</a></li>

                    </ul>
                </li>
                 <li>
                    <a <?php if (in_array(strtolower($class),['vehicile'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)?>/vehicile">
                        <span>Manage Take Car</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a <?php if (in_array(strtolower($class),['restaurant'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)?>/Restaurant">
                        <span>Manage Take Food</span>
                        </a>
                </li>
                  
                <li>
                    <a <?php if (in_array(strtolower($class),['mart'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)?>/Mart">
                        <span>Manage Take Mart </span>
                    </a>
                </li>

                 

                 <li class="sub-menu">
                     <a  <?php if (in_array(strtolower($class),['orders'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)."/Orders?module_type=".$this->Common_model->encrypt(1);?>">
                        <span> Mart/Food Orders</span>
                    </a>
                </li>

                 
                <li class="sub-menu">
                     <a  <?php if (in_array(strtolower($class),['category'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)?>/Category">
                        <span>Manage Categories</span>
                    </a>
                </li>
                <li class="sub-menu">
                   <a <?php if (in_array(strtolower($class),['charges'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)?>/Charges">
                        <span>Manage Charges</span>
                    </a>
                </li>
                <li class="sub-menu">
                   
                        <a <?php if (in_array(strtolower($class),['cms'])) echo 'class="active"'?> href="<?php echo base_url().$this->uri->segment(1)?>/Cms">
                        <span>Manage In-App Content </span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="emergency.html">
                        <span>Manage Emergency Case</span>
                    </a>
                </li>
				<li class="sub-menu">
                    <a <?php if (in_array($class,['banner'])) echo "class='active'"?> href="<?php echo base_url().$this->uri->segment(1)?>/banner">
                        <span>Manage Banner</span>
                    </a>
                </li>
				<li class="sub-menu">
                    <a href="manage-transctions-food.html">
                        <span>Manage Transactions</span>
                    </a>
                </li>
				<li class="sub-menu">
                   
                        <a <?php if (in_array($class,['StatusUpgrade'])) echo "class='active'"?> href="<?php echo base_url().$this->uri->segment(1)."/StatusUpgrade"?>">
                        <span>Status Upgrade</span>
                    </a>
                </li>
				<li class="sub-menu">
                    <a href="credit-sell-back.html">
                        <span>Credit Sell Back</span>
                    </a>
                </li>
            </ul>           
             </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->


