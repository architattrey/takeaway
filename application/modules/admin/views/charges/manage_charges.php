
<section id="main-content">
    <section class="wrapper">
        <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">List of Added Charges</div></div>
   
    <div class="row w3-res-tb">
       
    
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 charges-bottom-border">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10"><div class="terms">Take Car</div></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 charges-bottom-border-edit">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="text-car">Shown Car</div>
                <h4 class="car_fare">Normal fare ( 9:00 am - 5:00 pm )</h4>
                <form action="<?php echo base_url().$this->uri->segment(1)."/charges/index";?>" method="post">
                   <input type="hidden" name="car_type" value="shown"/>
                   <input type="hidden" name="charge_type" value="normal"/>

                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">Base Fare</label>
                        <input type="text" name="base_fare" value="<?php echo set_value('base_fare', isset($shown_charges->base_fare)?$shown_charges->base_fare:""); ?>" class="form-control take-car-show" placeholder="Base Fare">
                        <?php echo form_error('base_fare','<label class="alert-danger">','</label>');?>
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">After 5 Kms</label>
                        <input type="text" name="after_kms" value="<?php echo set_value('after_kms', isset($shown_charges->after_kms)?$shown_charges->after_kms:""); ?>" class="form-control take-car-show" placeholder="After 5 Kms">
                        <label for="text" class="color-black">Per KM</label>
                        <?php echo form_error('after_kms','<label class="alert-danger">','</label>');?>
                    </div><br>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     <button type="submit" class="btn btn-success" style="float:left;">Submit</button>
                    </div>

                </form>
                <div class="clearfix"></div>

                <h4 class="car_fare">Traffic charge ( 7:00 am - 8:59 am & 5:01 pm - 7:01 pm )</h4>
                <form action="<?php echo base_url().$this->uri->segment(1)."/charges/showntraffic";?>" method="post">
                   <input type="hidden" name="car_type" value="shown"/>
                   <input type="hidden" name="charge_type" value="traffic"/>
                   
                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">Base Fare</label>
                        <input type="text" name="base_fare_shown_traffic" value="<?php echo set_value('base_fare_shown_traffic', isset($shown_charges_traffic->base_fare)?$shown_charges_traffic->base_fare:""); ?>" class="form-control take-car-show" placeholder="Base Fare">
                        <?php echo form_error('base_fare_shown_traffic','<label class="alert-danger">','</label>');?>
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">After 5 Kms</label>
                        <input type="text" name="shown_traffic_after_kms" value="<?php echo set_value('shown_traffic_after_kms', isset($shown_charges_traffic->after_kms)?$shown_charges_traffic->after_kms:""); ?>" class="form-control take-car-show" placeholder="After 5 Kms">
                        <label for="text" class="color-black">Per KM</label>
                        <?php echo form_error('shown_traffic_after_kms','<label class="alert-danger">','</label>');?>
                    </div><br>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     <button type="submit" class="btn btn-success" style="float:left;">Submit</button>
                    </div>

                </form>

                <div class="clearfix"></div>
                <h4 class="car_fare">Night charge ( 7:01 pm - 6:59 am )</h4>
                <form action="<?php echo base_url().$this->uri->segment(1)."/charges/shownnight";?>" method="post">
                   <input type="hidden" name="car_type" value="shown"/>
                   <input type="hidden" name="charge_type" value="night"/>
                   
                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">Base Fare</label>
                        <input type="text" name="base_fare_shown_night" value="<?php echo set_value('base_fare_shown_night', isset($shown_charges_night->base_fare)?$shown_charges_night->base_fare:""); ?>" class="form-control take-car-show" placeholder="Base Fare">
                        <?php echo form_error('base_fare_shown_night','<label class="alert-danger">','</label>');?>
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">After 5 Kms</label>
                        <input type="text" name="shown_night_after_kms" value="<?php echo set_value('shown_night_after_kms', isset($shown_charges_night->after_kms)?$shown_charges_night->after_kms:""); ?>" class="form-control take-car-show" placeholder="After 5 Kms">
                        <label for="text" class="color-black">Per KM</label>
                        <?php echo form_error('shown_night_after_kms','<label class="alert-danger">','</label>');?>
                    </div><br>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     <button type="submit" class="btn btn-success" style="float:left;">Submit</button>
                    </div>

                </form>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="text-car">Space Car</div>
                <h4 class="car_fare">Normal fare ( 9:00 am - 5:00 pm )</h4>
                <form action="<?php echo base_url().$this->uri->segment(1)."/charges/space";?>" method="post">
                   <input type="hidden" name="car_type" value="space"/>
                   <input type="hidden" name="charge_type" value="normal"/>

                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">Base Fare</label>
                        <input type="text" name="space_base_fare" value="<?php echo set_value('space_base_fare', isset($space_charges->base_fare)?$space_charges->base_fare:""); ?>" class="form-control take-car-show" placeholder="Base Fare">
                        <?php echo form_error('space_base_fare','<label class="alert-danger">','</label>');?>
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">After 5 Kms</label>
                        <input type="text" name="space_after_kms" value="<?php echo set_value('space_after_kms', isset($space_charges->after_kms)?$space_charges->after_kms:""); ?>" class="form-control take-car-show" placeholder="After 5 Kms">
                        <label for="text" class="color-black">Per KM</label>
                        <?php echo form_error('space_after_kms','<label class="alert-danger">','</label>');?>
                    </div><br>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     <button type="submit" class="btn btn-success" style="float:left;">Submit</button>
                    </div>

                </form>


                <div class="clearfix"></div>
                
                <h4 class="car_fare">Traffic charge ( 7:00 am - 8:59 am & 5:01 pm - 7:01 pm )</h4>
                        
                    <form action="<?php echo base_url().$this->uri->segment(1)."/charges/spacetraffic";?>" method="post">
                       <input type="hidden" name="car_type" value="space"/>
                       <input type="hidden" name="charge_type" value="traffic"/>
                       
                        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                            <label for="text" class="color-black">Base Fare</label>
                            <input type="text" name="base_fare_space_traffic" value="<?php echo set_value('base_fare_space_traffic', isset($space_charges_traffic->base_fare)?$space_charges_traffic->base_fare:""); ?>" class="form-control take-car-show" placeholder="Base Fare">
                            <?php echo form_error('base_fare_space_traffic','<label class="alert-danger">','</label>');?>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                            <label for="text" class="color-black">After 5 Kms</label>
                            <input type="text" name="space_traffic_after_kms" value="<?php echo set_value('space_traffic_after_kms', isset($space_charges_traffic->after_kms)?$space_charges_traffic->after_kms:""); ?>" class="form-control take-car-show" placeholder="After 5 Kms">
                            <label for="text" class="color-black">Per KM</label>
                            <?php echo form_error('space_traffic_after_kms','<label class="alert-danger">','</label>');?>
                        </div><br>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                         <button type="submit" class="btn btn-success" style="float:left;">Submit</button>
                        </div>

                    </form>

                <div class="clearfix"></div>


                <h4 class="car_fare">Night charge ( 7:01 pm - 6:59 am )</h4>
                <form action="<?php echo base_url().$this->uri->segment(1)."/charges/spacenight";?>" method="post">
                   <input type="hidden" name="car_type" value="space"/>
                   <input type="hidden" name="charge_type" value="night"/>
                   
                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">Base Fare</label>
                        <input type="text" name="base_fare_space_night" value="<?php echo set_value('base_fare_space_night', isset($space_charges_night->base_fare)?$space_charges_night->base_fare:""); ?>" class="form-control take-car-show" placeholder="Base Fare">
                        <?php echo form_error('base_fare_space_night','<label class="alert-danger">','</label>');?>
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <label for="text" class="color-black">After 5 Kms</label>
                        <input type="text" name="space_night_after_kms" value="<?php echo set_value('space_night_after_kms', isset($space_charges_night->after_kms)?$space_charges_night->after_kms:""); ?>" class="form-control take-car-show" placeholder="After 5 Kms">
                        <label for="text" class="color-black">Per KM</label>
                        <?php echo form_error('space_night_after_kms','<label class="alert-danger">','</label>');?>
                    </div><br>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     <button type="submit" class="btn btn-success" style="float:left;">Submit</button>
                    </div>

                </form>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 charges-bottom-border">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10"><div class="terms">Take Sent</div></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
             <div class="table-responsive">
            <table cellpadding="0px">
        <!-- <thead>
          <tr class="">
            <th>Pocket Type</th>
            <th>Size</th>
            <th>Weight</th>
            <th> </th>
             <th></th>
             <th> </th>
             <th></th>
             <th></th>
             <th></th>
          </tr>
        </thead> -->
        <tbody>
          <tr>
            <td>Envelope</td>
            <td>
                <table>
                    <tbody> 
                    <tr>
                    <td>
                        <div class="">Length</div>
                        <input type="text" class="input-width take-sent-show" name="" value="" placeholder="" >
                    </td>
                    <td>
                        <div class="">width</div>
                        <input type="text" class="input-width take-sent-show" name="" value="" placeholder="" >
                    </td>
                    <td>
                         <div class="">Height</div>
                        <input type="text" class="input-width take-sent-show" name="" value="" placeholder="" >
                    </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td><input type="text" name="" class="input-width take-sent-show" value="" placeholder="1 kg" ></td>
            <td>Base For</td>
            <td><input type="text" name="" class="input-width take-sent-show" value="" placeholder="RM 10" ></td>
            <td>For</td>
            <td><input type="text" name="" class="input-width take-sent-show" value="" placeholder="5 Kms" ></td>
            <td><input type="text" name="" class="input-width take-sent-show" value="" placeholder="RM 5" ></td>
            <td>Per KM</td>
          </tr>
          <tr>
             <td>Carton Box</td>
            <td>
                <table>
                    <tbody> 
                    <tr>
                    <td>
                        <div class="">Length</div>
                        <input type="text" class="input-width take-sent-show" name="" value="" placeholder="" >
                    </td>
                    <td>
                        <div class="">width</div>
                        <input type="text" class="input-width take-sent-show" name="" value="" placeholder="" >
                    </td>
                    <td>
                         <div class="">Height</div>
                        <input type="text" class="input-width take-sent-show" name="" value="" placeholder="" >
                    </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td><input type="text" name="" value="" class="input-width take-sent-show" placeholder="1 kg"></td>
            <td>Base For</td>
            <td><input type="text" name="" value="" class="input-width take-sent-show" placeholder="RM 10" ></td>
            <td>For</td>
            <td><input type="text" name="" value="" class="input-width take-sent-show" placeholder="5 Kms"></td>
            <td><input type="text" name="" value="" class="input-width take-sent-show" placeholder="RM 5" ></td>
            <td>Per KM</td>
          </tr>
          <tr style="margin-bottom:20px;">
            <td colspan="11">
                <button type="submit" class="btn btn-success" style="float:left;">Success</button>
              </td>
                    </tr>
        </tbody>
       
      </table>
        </div>
    </div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 charges-bottom-border">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10"><div class="terms">Take Food and Mart</div></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 charges-bottom-border-edit">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                
                <form class="form horizontal">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="text" class="color-black">Base Fare</label>
                        <input type="text" class="form-control take-food-mart-show" placeholder="RM 10" >
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="text" class="color-black">For</label>
                        <input type="text" class="form-control take-food-mart-show" placeholder="5 Kms" >
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="text" class="color-black">After 5 Kms</label>
                        <input type="text" class="form-control take-food-mart-show" placeholder="RM 10">
                        <label for="text" class="color-black">Per KM</label>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="text" class="color-black">10 Grocery Item</label>
                        <input type="text" class="form-control take-food-mart-show" placeholder="RM 5" >
                        <label for="text" class="color-black">Per ITEM</label>
                    </div>
                    <br>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                     <button type="submit" class="btn btn-success" style="float:left;">Success</button>
                    </div>
                    </form>
            </div>
        </div>


    
    </div>
  </div>
</div>
</section>

<!--main content end