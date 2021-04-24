<!--main content end-->
</section>
<script src="admin/js/bootstrap.js"></script>
<script src="admin/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="admin/js/scripts.js"></script>
<script src="admin/js/jquery.slimscroll.js"></script>
<script src="admin/js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="admin/js/jquery.scrollTo.js"></script>
<script src="admin/js/globalMsg.js"></script>
<script src="admin/js/jqvalidate/dist/jquery.validate.js"></script>
<script src="admin/js/jqvalidate/dist/additional-methods.js"></script>
<script src="admin/js/admin-common-forms.js"></script>
<!-- <script src="admin/js/morris.js"></script> -->

 <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdn.ckeditor.com/4.9.0/standard/ckeditor.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATloYAbQ3ukB-0ovPH8NQ2sA0zhiGQo4o&callback=initMap"></script>

  <!-- CLOUDINARY FILE UPLOADED -->
 
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!-- CKEDITOR WITH TEXTEREA -->

  <script>
  // Replace the <textarea id="ckeditor"> with a CKEditor
  // instance, using default configuration.
  //{@linkapi CKEDITOR.replace CKEDITOR.replace}( '#ckeditor' );
  CKEDITOR.replace( 'editor1' );
  // CKEDITOR.replace( '#ckeditor' );
  </script>

 <!-- CLOUDINARY FILE UPLOADED  BY JAVASCRIPT WITHOUT VALIDATION-->

<!-- for banner image -->


<script type="text/javascript">
  let bannerImageUrl ='';
 var CLOUDINARY_URL = 'https://api.cloudinary.com/v1_1/http-flynaut-com/upload';
 var CLOUDINARY_UPLOAD_PRESET ='y66umjm8';

 var imgPreview = document.getElementById('img-preview');
 var fileUpload = document.getElementById('banner_image');

 fileUpload.addEventListener('change',function(event){
 //    console.log(event);
 var file = event.target.files[0];
 var formData = new FormData();
 //console.log(file);
 formData.append('file',file);
 formData.append('upload_preset',CLOUDINARY_UPLOAD_PRESET);

 axios({
         url:CLOUDINARY_URL,
         method:'POST',
         headers:{
                 'content-Type':'application/x-www-form-urlencoded'
                },
         data:formData
       }).then(function(res){
          bannerImageUrl = res.data.secure_url.split('upload')[1]; // here we get the dynamic url of cloudinary
          $('#banner_img_path').val(bannerImageUrl);
         //return console.log(bannerImageUrl);
       }).catch(function(err){
         console.log(err);
 });
 });


 </script> 

<!-- for logo image -->

 <script type="text/javascript">
  let logoImageUrl = '';
 var CLOUDINARY_URL = 'https://api.cloudinary.com/v1_1/http-flynaut-com/upload';
 var CLOUDINARY_UPLOAD_PRESET ='y66umjm8';

 var imgPreview = document.getElementById('img-preview');
 var fileUpload = document.getElementById('logo_image');

 fileUpload.addEventListener('change',function(event){
 //    console.log(event);
 var file = event.target.files[0];
 var formData = new FormData();
 //console.log(file);
 formData.append('file',file);
 formData.append('upload_preset',CLOUDINARY_UPLOAD_PRESET);

 axios({
         url:CLOUDINARY_URL,
         method:'POST',
         headers:{
                 'content-Type':'application/x-www-form-urlencoded'
                },
         data:formData
       }).then(function(res){
          logoImageUrl = res.data.secure_url.split('upload')[1];
          $('#logo_img_path').val(logoImageUrl);
         return console.log(logoImageUrl);
       }).catch(function(err){
         console.log(err);
 });
 });


 </script> 
<!-- for food image -->

<script type="text/javascript">
 let foodImageUrl ='';
 var CLOUDINARY_URL = 'https://api.cloudinary.com/v1_1/http-flynaut-com/upload';
 var CLOUDINARY_UPLOAD_PRESET ='y66umjm8';

 var imgPreview = document.getElementById('img-preview');
 var fileUpload = document.getElementById('food_image');

 fileUpload.addEventListener('change',function(event){
 //    console.log(event);
 var file = event.target.files[0];
 var formData = new FormData();
 //console.log(file);
 formData.append('file',file);
 formData.append('upload_preset',CLOUDINARY_UPLOAD_PRESET);

 axios({
         url:CLOUDINARY_URL,
         method:'POST',
         headers:{
                 'content-Type':'application/x-www-form-urlencoded'
                },
         data:formData
       }).then(function(res){
            foodImageUrl = res.data.secure_url.split('upload')[1];
          $('#food_img_path').val(foodImageUrl);
         return console.log(foodImageUrl);
       }).catch(function(err){
         console.log(err);
 });
 });


 </script> 

<!-- FOR ADD BANNER IMAGES -->


 <script type="text/javascript">
 let imageUrl = ''; 
 var CLOUDINARY_URL = 'https://api.cloudinary.com/v1_1/http-flynaut-com/upload';
 var CLOUDINARY_UPLOAD_PRESET ='y66umjm8';

 var imgPreview = document.getElementById('img-preview');
 var fileUpload = document.getElementById('image');

 fileUpload.addEventListener('change',function(event){
 //    console.log(event);
 var file = event.target.files[0];
 var formData = new FormData();
 //console.log(file);
 formData.append('file',file);
 formData.append('upload_preset',CLOUDINARY_UPLOAD_PRESET);

 axios({
         url:CLOUDINARY_URL,
         method:'POST',
         headers:{
                 'content-Type':'application/x-www-form-urlencoded'
                },
         data:formData
       }).then(function(res){
                imageUrl =  res.data.secure_url.split('upload')[1];
                $("#image_path").val(imageUrl);  
         return console.log(imageUrl);
       }).catch(function(err){
         console.log(err);
 });
 });
  
 </script>
 
 <!-- FOR ADD BANNER IMAGES -->


<!-- GET LAT LONH FROM JAVASCRIPTT  FROM THE  ADDRESS -->

<script>
  //please   enter the api key of google map
/* This showResult function is used as the callback function*/

function showResult(result) {
    document.getElementById('latitude').value = result.geometry.location.lat();
    document.getElementById('longitude').value = result.geometry.location.lng();
}

function getLatitudeLongitude(callback, address) {
    // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
    address = address || 'Ferrol, Galicia, Spain, malaysia';
    // Initialize the Geocoder
    geocoder = new google.maps.Geocoder();
    if (geocoder) {
        geocoder.geocode({
            'address': address
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                callback(results[0]);
            }
        });
    }
}

var button = document.getElementById('submit');
button.addEventListener("click", function () {
    var address = document.getElementById('address').value;
    getLatitudeLongitude(showResult, address)
});

</script>



<!-- morris JavaScript -->	
<script>
	// $(document).ready(function() {
	// 	//BOX BUTTON SHOW AND CLOSE
	//    jQuery(".small-graph-box").hover(function() {
	// 	  jQuery(this).find(".box-button").fadeIn("fast");
	//    }, function() {
	// 	  jQuery(this).find(".box-button").fadeOut("fast");
	//    });
	//    jQuery(".small-graph-box .box-close").click(function() {
	// 	  jQuery(this).closest(".small-graph-box").fadeOut(200);
	// 	  return false;
	//    });
	   
	//     //CHARTS
	//     function gd(year, day, month) {
	// 		return new Date(year, month - 1, day).getTime();
	// 	}
		
	// 	graphArea2 = Morris.Area({
	// 		element: "hero-area",
	// 		padding: 10,
 //        behaveLikeLine: true,
 //        gridEnabled: false,
 //        gridLineColor: "#dddddd",
 //        axes: true,
 //        resize: true,
 //        smooth:true,
 //        pointSize: 0,
 //        lineWidth: 0,
 //        fillOpacity:0.85,
	// 		data: [
	// 			{period: "2015 Q1", iphone: 2668, ipad: null, itouch: 2649},
	// 			{period: "2015 Q2", iphone: 15780, ipad: 13799, itouch: 12051},
	// 			{period: "2015 Q3", iphone: 12920, ipad: 10975, itouch: 9910},
	// 			{period: "2015 Q4", iphone: 8770, ipad: 6600, itouch: 6695},
	// 			{period: "2016 Q1", iphone: 10820, ipad: 10924, itouch: 12300},
	// 			{period: "2016 Q2", iphone: 9680, ipad: 9010, itouch: 7891},
	// 			{period: "2016 Q3", iphone: 4830, ipad: 3805, itouch: 1598},
	// 			{period: "2016 Q4", iphone: 15083, ipad: 8977, itouch: 5185},
	// 			{period: "2017 Q1", iphone: 10697, ipad: 4470, itouch: 2038},
			
	// 		],
	// 		lineColors:["#eb6f6f","#926383","#eb6f6f"],
	// 		xkey: "period",
 //            redraw: true,
 //            ykeys: ["iphone", "ipad", "itouch"],
 //            labels: ["All Visitors", "Returning Visitors", "Unique Visitors"],
	// 		pointSize: 2,
	// 		hideHover: "auto",
	// 		resize: true
	// 	});
		
	   
	// });
	
	

	</script>
	<script>
var d = new Date();
document.getElementById("date-time").innerHTML = d.toString();
</script>
<!-- calendar -->
	<script type="text/javascript" src="admin/js/monthly.js"></script>
	 
  
</body>
</html>


<!-- reject modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- USER MODAL UPDATE CONTENT-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit User Information</h4>
      </div>
      <div class="modal-body">
      
			<form>
			<div class="form-group">
			  <label for="usr">Name</label>
			  <input type="text" class="form-control" name="name" value="">
			</div>
			<div class="form-group">
			  <label for="usr">Email</label>
			  <input type="email" class="form-control" name="email" value="">
			</div>
			<div class="form-group">
			  <label for="pwd">Contact Number</label>
			  <input type="number" class="form-control" name="Phone Number" value="" >
			</div>
		  </form>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">Send</button>
      </div>
    </div>

  </div>
</div>

<!-- USER MODAL UPDATE CONTENT -->


<div id="myModal-block" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Block</h4>
      </div>
      <div class="modal-body">
      <spanm class="modal-para"><p></p></span>	

      
      </div>
      <input type="hidden" name="new_status" id="new_status">
      <input type="hidden" name="new_id" id="new_id">
      <input type="hidden" name="new_url" id="new_url" >
      <input type="hidden" name="action" id="action">
      <input type="hidden" name="for" id="for">

      <div class="modal-footer">
      	 <button type="button"  class="btn btn-success" onclick="changeStatusToBlock($('#for').val(),$('#new_status').val(),$('#new_id').val(),$('#new_url').val())">Yes</button>
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
       
      </div>
    </div>

  </div>
</div>
<!-- block modal -->


<!-- verify modal -->


<div id="myModal-verify" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Block</h4>
      </div>
      <div class="modal-body">
      <spanm class="modal-para"><p></p></span>	

      
      </div>
      <input type="hidden" name="new_status" id="verify_status">
      <input type="hidden" name="new_id" id="verify_id">
      <input type="hidden" name="new_url" id="verify_url" >
      <input type="hidden" name="action" id="action">
      <input type="hidden" name="for" id="for1">

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button"  class="btn btn-success" onclick="verifyDriver($('#for').val(),$('#verify_status').val(),$('#verifyid').val(),$('#verify_url').val())">Yes</button>
      </div>
    </div>

  </div>
</div>
<!-- verify modal -->


<!-- reject modal -->
<div id="myModal-reject" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

    <form action="<?php echo base_url().$this->uri->segment(1)?>/ajax/rejectDriver" id="reject_driver_form">	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rejection Reason</h4>
      </div>
      <div class="modal-body">
      
        
        <div class="form-group">
          <label for="comment">Comment:</label>
          <textarea class="form-control" rows="5" id="comment"   name="reason" maxlength="255" placeholder="Give rejection reason.."  required > </textarea>
          <input type="hidden" name="driver_id" id="reject_id">
          <input type="hidden" name="mailId"   id="reject_mailid">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Send</button>
      </div>
  </form>
    </div>
  </div>
</div>
<!-- reject modal -->

<!-- UPDATE DRIVER -->
<div id="updateDriverModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

    <form id="update_driver">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Driver</h4>
      </div>
      <div class="modal-body">
      
        
        <div class="form-group">
          <label for="comment">Update</label>
          <input type="hidden"  id="verify_url">
          <input type="hidden"  id="driver_id" >
          <input type="text"    id="driver_name">
          <input type="text"    id="driver_email">
          <input type="text"    id="driver_mobile">
        </div>
      
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="update_driver($('#driver_id').val(),$('#driver_name').val(),$('#driver_email').val(),$('#driver_mobile').val(),$('#verify_url').val())">Send</button>
      </div>

  </form>
    </div>

  </div>
</div>

<!-- UPDATE DRIVER -->



<!-- UPDATE CATEGORY -->

<div id="updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>


        <h4 class="modal-title">Edit Category</h4>
      </div>
      <div class="modal-body">
     
      <form id="category_add_form">
      <div class="form-group">
        <label for="pwd">Update Category</label>
         <input  type="hidden" value=" "                               id="category_id">
        <input type="hidden" name="new_url"                            id="verify_url" >
        <input  type="text" class="form-control" name="category_name"  id="category_name" value=" "  maxlength="20" required>
         
      </div>
  
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-success" value="Submit"  onclick="update_Category($('#category_id').val(),$('#verify_url').val(),$('#category_name').val())">
      </div>
    </div>
</form>
  </div>
</div>

<!-- UPDATE CATEGORY -->


<!-- DELETE CATEGORY -->

<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
      <span class="modal-para"><p></p></span>
      </div>
      
      <input type="hidden" name="category_id" id="category_id">
      <input type="hidden" name="new_url"     id="verify_url" >
  
     

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button"  class="btn btn-success" onclick="delete_Category($('#category_id').val(),$('#verify_url').val())">Yes</button>
      </div>
    </div>

  </div>
</div>


<!-- DELETE BANNER -->

<div id="deletebanner" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
      <span class="modal-para"><p></p></span>
      </div>
      
      <input type="hidden" name="banner_id" id="banner_id">
      <input type="hidden" name="new_url"     id="verify_url" >
  
     

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button"  class="btn btn-success" onclick="delete_Banner($('#banner_id').val(),$('#verify_url').val())">Yes</button>
      </div>
    </div>

  </div>
</div>




<!-- DELETE DELETE VHICILE -->

<div id="deletevechile" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
      <span class="modal-para"><p></p></span>
      </div>
      
      <input type="hidden" name="banner_id" id="vechile_id">
      <input type="hidden" name="new_url"     id="verify_url" >
  
     

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button"  class="btn btn-success" onclick="delete_vechile($('#vechile_id').val(),$('#verify_url').val())">Yes</button>
      </div>
    </div>

  </div>
</div>


<!-- DELETE  MART -->

<div id="deletemart" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
      <span class="modal-para"><p></p></span>
      </div>
      
      <input type="hidden" name="banner_id" id="mart_id">
      <input type="hidden" name="new_url"     id="verify_url" >
  
     

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button"  class="btn btn-success" onclick="delete_mart($('#mart_id').val(),$('#verify_url').val())">Yes</button>
      </div>
    </div>

  </div>
</div>


<!-- DELETE  RESTAURANT -->

<div id="deleterestaurant" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
      <span class="modal-para"><p></p></span>
      </div>
      
      <input type="hidden" name="banner_id" id="restaurant_id">
      <input type="hidden" name="new_url"     id="verify_url" >
  
     

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button"  class="btn btn-success" onclick="delete_restaurant($('#restaurant_id').val(),$('#verify_url').val())">Yes</button>
      </div>
    </div>

  </div>
</div>












