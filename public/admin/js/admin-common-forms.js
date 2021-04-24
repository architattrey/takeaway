




/* Universal Error Template starts */
function errortemplate(inputboxid, erboxid, ermsg) {
   // alert(erboxid);
   var ele = $('#' + erboxid);
   var eleB= $('body');
    $('#' + erboxid).html(ermsg);
   // alert(erboxid);
   $('html,body').animate({scrollTop: ele});
    $('#' + erboxid).slideDown();
    $('#' + inputboxid).focus();
    setTimeout(function () {
        $('#' + erboxid).hide();        
    }, 10000);
}



var _validFileExtensionsImage = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
var _validFileExtensionsImageVideo = [".jpg", ".jpeg", ".bmp", ".gif", ".png",".mp4"];
var _validFileExtensionsDoc = [".doc", ".docx", ".pdf"];    
function ValidateSingleInput(oInput, _validFileExtensions) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

var loadFile_signup = function(event,id, oInput) {
	var return_data = ValidateSingleInput(oInput, _validFileExtensionsImage,id);
	if (return_data) {
		var output = document.getElementById(id);
        $('#'+id).css('background-image', 'url(' + URL.createObjectURL(event.target.files[0]) + ')');
	}
};

  //not allow first character space on input
    $("input:text,input:password").on("keypress", function(e) {
        if (e.which === 32 && !this.value.length)
            e.preventDefault();
    });

/**
 * 
 * validating blog section images.
 * 
 **/
var loadFile_blog = function(event,id, oInput) {
	var return_data = ValidateSingleInput(oInput, _validFileExtensionsImageVideo,id);
	if (return_data) {
		var output = document.getElementById(id);
        output.src = URL.createObjectURL(event.target.files[0]);
	}
};

//-----------------------------------------------------------------------
/**
  *
  * @name starting to implement jquery code when document loaded.
  *
  **/
   $(function(){
	  
	  if($('.search-box').val()){ 
		   
		   if ($('.search-box').val().length) {
						$('.srch-close-icon').show();
						$('.search-icon').hide();
		   } else {
						$('.srch-close-icon').hide();
						$('.search-icon').show();      
		   }
	  }
   });
   
   


/**
 * 
 * @returns {undefined}
 * 
 */
 function pageCountForm(id){
     
     
     $('#'+id).submit();
 }



//------------------------------------------------------------------------------------

/**
 * @name validate mobile number for entering only digits.
 * @param {type} event
 * @returns {Boolean}
 */
 function validatePhone(event) {
    var key = window.event ? event.keyCode : event.which;

      if (event.keyCode == 37 || event.keyCode==43) {
          return true;
      }
      else if ( (key < 48 || key > 57) && key !=8) {
          return false;
      }
      else return true;
 };


 //----------------------------------------------------------------------
 /**
  * @name blockUser
  * @description This method is used to show block user modal.
  * 
  */
 
 function blockUser(type,status,id,url,msg,action){
	 
	 $('#new_status').val(status);
	 $('#new_id').val(id);
	 $('#new_url').val(url);
	 $('.modal-para').text(msg);
	 $('#for').val(type);
	 $('#myModal-block').modal('show');
 }

 //-----------------------------------------------------------------------
 /**
  * @name verifyDriver
  * @description This method is used to verifyDriver
  */
 
 function verifyDriver(type,status,id,url,msg,action){
   
   $('#verify_status').val(status);
   $('#verify_id').val(id);
   $('#verify_url').val(url);
   $('.modal-para').text(msg);
   $('#for1').val(type);
   $('#myModal-block').modal('show');
 }


  function rejectDriver(id,email){
 
   $('#reject_id').val(id);
   $('#reject_mailid').val(email);
    //$('#for1').val(type);
   $('#myModal-reject').modal('show');
 }
 // it will set the mailid and driver id in form of the snd mail than we will send the reqst by that form in ajax cntrlr.
// 

 function updateDriver(id,name,email,mobile,url){

    $('#driver_id').val(id);
    $('#driver_name').val(name);
    $('#driver_email').val(email);
    $('#driver_mobile').val(mobile);
    $('#verify_url').val(url);
   $('#updateDriverModal').modal('show');
 }

// category delete and update from here we call a modal in footer 

 function updateCategory(id,name,url){

   $('#category_id').val(id);
   $('#category_name').val(name);
    $('#verify_url').val(url);
   $('#updateModal').modal('show');
 }




function deleteCategory(id,url,msg){
   
   
   $('#category_id').val(id);
   $('#verify_url').val(url);
   $('.modal-para').text(msg);
   $('#deleteModal').modal('show');
 }

 function deleteBanner(id,url,msg){
   
   
   $('#banner_id').val(id);
   $('#verify_url').val(url);
   $('.modal-para').text(msg);
   $('#deletebanner').modal('show');
 }

  function deleteVechile(id,url,msg){
    
   $('#vechile_id').val(id);
   $('#verify_url').val(url);
   $('.modal-para').text(msg);
   $('#deletevechile').modal('show');

  }

  function deleteMart(id,url,msg){
    
   $('#mart_id').val(id);
   $('#verify_url').val(url);
   $('.modal-para').text(msg);
   $('#deletemart').modal('show');

  }

  function deleteRestaurant(id,url,msg){
    
   $('#restaurant_id').val(id);
   $('#verify_url').val(url);
   $('.modal-para').text(msg);
   $('#deleterestaurant').modal('show');

  }
  

  


function logout(type,status,id,url,msg,action){
	 $('#myModal-trash_logout').modal('show');
 }

//-----------------------------------------------------------------------
 /**
  * @name changeStatusToBlock
  * @description This method is used to block the user.
  */
 
 function changeStatusToBlock(type,status,id,url){
	var csrf  = $('#csrf').val();
	$.ajax({
            method: "POST",
            url: baseUrl+url,
            data:{type:type,new_status:status,id:id,'csrf_test_name':csrf},
            beforeSend:function(){
				      $('#pre-page-loader').fadeIn();
				      $('#myModal-block').modal('hide');
			      },
            success:function(res){

                $('#pre-page-loader').fadeOut();
				        res=JSON.parse(res);

				        var csrf  = $('#csrf').val(res.csrf_token);
				        if(res.code===200){
					
					      if(status==2){
						      $('#error').empty().append(string.successPrefix+string.block_success+string.successSuffix);
						      $('#unblock_'+res.id).show();
						      $('#block_'+res.id).hide();
						      $('#status_'+res.id).empty().text('Blocked');
					      }else{
						      $('#error').empty().append(string.successPrefix+string.unblock_success+string.successSuffix);
						      $('#block_'+res.id).show();
						      $('#unblock_'+res.id).hide();
						      $('#status_'+res.id).empty().text('Active');
					      }
				      }

			      },
			      error:function(xhr){
				     alert("Error occured.please try again");
				     $('#pre-page-loader').fadeOut();
			      }
        });
 } 



//-----------------------------------------------------------------------
 /**
  * @name verifyDriver
  * @description This method is used to verify the driver.
  */
 
 function verifyDriver(type,status,id,url){
  var csrf  = $('#csrf').val();
  $.ajax({
            method: "POST",
            url: baseUrl+url,
            data:{type:type,new_status:status,id:id,'csrf_test_name':csrf},
            beforeSend:function(){
              $('#pre-page-loader').fadeIn();
              $('#myModal-block').modal('hide');
            },
            success:function(res){
               
                location.reload(); 
            },


            error:function(xhr){
             alert("Error occured.password please try again");
             $('#pre-page-loader').fadeOut();
            }
        });
 
 } 


 //-----------------------------------------------------------------------


 /**
   * @name updateDriver
   * @description This method is used to update the  driver
   */
 
   function update_driver(id,name,email,mobile,url){
 //alert( baseUrl+url);

    var csrf  = $('#csrf').val();
    $.ajax({
              method: "POST",
              url: baseUrl+url,
              data:{id:id,name:name,email:email,mobile:mobile},
              beforeSend:function(){
                $('#pre-page-loader').fadeIn();
                $('#myModal-block').modal('hide');
              },
              success:function(res){
                //alert(res);               
                  location.reload(); 
              },


              error:function(xhr){
               alert("Error occured.password please try again");
               $('#pre-page-loader').fadeOut();
              }
          });
 
   } 


//-----------------------------------------------------------------------


//-----------------------------------------------------------------------
  /**
   * @name deleteCategory
   * @description This method is used to delete the  category.
   */
 
   function delete_Category(id,url){
 // alert(baseUrl +url+" "+id);

    var csrf  = $('#csrf').val();
    $.ajax({
              method: "POST",
              url: baseUrl+url,
              data:{id:id},
              beforeSend:function(){
                $('#pre-page-loader').fadeIn();
                $('#myModal-block').modal('hide');
              },
              success:function(res){

               
                  location.reload(); 
              },


              error:function(xhr){
               alert("Error occured.password please try again");
               $('#pre-page-loader').fadeOut();
              }
          });
 
   } 



//-----------------------------------------------------------------------
  /**
   * @name deleteVehicile
   * @description This method is used to delete the  Vehicile.
   */
 
   function delete_vechile(id,url){
 // alert(baseUrl+"== " +url+"== "+id);

    var csrf  = $('#csrf').val();
    $.ajax({
              method: "POST",
              url: baseUrl+url,
              data:{id:id},
              beforeSend:function(){
                $('#pre-page-loader').fadeIn();
                $('#myModal-block').modal('hide');
              },
              success:function(res){
                //alert(res);                                       

               
                  location.reload(); 
              },


              error:function(xhr){
               alert("Error occured.password please try again");
               $('#pre-page-loader').fadeOut();
              }
          });
 
   } 



//-----------------------------------------------------------------------
  /**
   * @name deleteMart
   * @description This method is used to delete the  Mart
   */
 
   function delete_mart(id,url){
 // alert(baseUrl+"== " +url+"== "+id);

    var csrf  = $('#csrf').val();
    $.ajax({
              method: "POST",
              url: baseUrl+url,
              data:{id:id},
              beforeSend:function(){
                $('#pre-page-loader').fadeIn();
                $('#myModal-block').modal('hide');
              },
              success:function(res){
                //alert(res);                                       

               
                  location.reload(); 
              },


              error:function(xhr){
               alert("Error occured.password please try again");
               $('#pre-page-loader').fadeOut();
              }
          });
 
   } 



//-----------------------------------------------------------------------


//-----------------------------------------------------------------------
  /**
   * @name deleteRestaurant
   * @description This method is used to delete the  restaurant
   */
 
   function delete_restaurant(id,url){
 // alert(baseUrl+"== " +url+"== "+id);

    var csrf  = $('#csrf').val();
    $.ajax({
              method: "POST",
              url: baseUrl+url,
              data:{id:id},
              beforeSend:function(){
                $('#pre-page-loader').fadeIn();
                $('#myModal-block').modal('hide');
              },
              success:function(res){
                //alert(res);                                       

               
                  location.reload(); 
              },


              error:function(xhr){
               alert("Error occured.password please try again");
               $('#pre-page-loader').fadeOut();
              }
          });
 
   } 



//-----------------------------------------------------------------------


 /**
   * @name updateCategory
   * @description This method is used to update the  category.
   */
 
   function update_Category(id,url,name){
 //alert( name+url+id);

    var csrf  = $('#csrf').val();
    $.ajax({
              method: "POST",
              url: baseUrl+url,
              data:{id:id,name:name},
              beforeSend:function(){
                $('#pre-page-loader').fadeIn();
                $('#myModal-block').modal('hide');
              },
              success:function(res){
                //  alert(res);

               
                  location.reload(); 
              },


              error:function(xhr){
               alert("Error occured.password please try again");
               $('#pre-page-loader').fadeOut();
              }
          });
 
   } 


//-----------------------------------------------------------------------



  /**
   * @name deleteBanner
   * @description This method is used to delete the banner
   */
 
   function delete_Banner(id,url){
 // alert(baseUrl +url+" "+id);

    var csrf  = $('#csrf').val();
    $.ajax({
              method: "POST",
              url: baseUrl+url,
              data:{id:id},
              beforeSend:function(){
                $('#pre-page-loader').fadeIn();
                $('#myModal-block').modal('hide');
              },
              success:function(res){

               
                  location.reload(); 
              },


              error:function(xhr){
               alert("Error occured.password please try again");
               $('#pre-page-loader').fadeOut();
              }
          });
 
   } 






//-------------------------------------------------------------------------------------
  /**
   *@Description Here is the methods starts for the form validations in admin using jquery validator. 
   * 
   */
  $(document).ready(function () {
		
		$.each($.validator.methods, function (key, value) {
           $.validator.methods[key] = function () {
               if(arguments.length > 0) {
                   arguments[0] = $.trim(arguments[0]);
               }

               return value.apply(this, arguments);
           };
		});
		
		// error message
	   $.validator.setDefaults({
			
			ignore: ':not(select:hidden, input:visible, textarea:visible):hidden:not(:checkbox)',

			errorPlacement: function (error, element) {
				if (element.hasClass('selectpicker')) {
					error.insertAfter(element);
				}
				else if (element.is(":checkbox")) {
				   // element.siblings('span').hasClass('.check_error_msg').append(error);

				   error.insertAfter($('.check_error_msg'));
				}
				 else {
					error.insertAfter(element);
				}
				/*Add other (if...else...) conditions depending on your
				* validation styling requirements*/
			}
		});
		//custom methods
    
		$.validator.addMethod("noSpace", function(value, element) {
			return value == '' || value.trim().length != 0; 
		  }, "");
		  
	    $.validator.addMethod("searchText", function(value, element) {
                             return value.replace(/\s+/g, '');
                            }, "");	  
		
		/**
		 * @name validate admin password change form
		 * @description This method is used to validate admin change password form.
		 * 
		 */
		 $("#admin_login_form").validate({
				errorClass: "alert-danger",
				rules: {
					email: {
						required: true,
						email:true
						
					},
					password: {
						required: true,
						maxlength:30
					},
				},
				submitHandler: function (form) {
					form.submit();
				}
			});
                    
    /**
		 * @name validate admin password forgot form
		 * @description This method is used to validate admin change password form.
		 * 
		 */
		 $("#forgot_pass_form").validate({
				errorClass: "alert-danger",
				rules: {
					email: {
						required: true,
						email:true
						
					},
				},
				submitHandler: function (form) {
					form.submit();
				}
			});   


      /**
     * @name admin_resetpass_form
     * @description This method is used to validate admin change password form.
     * 
     */
     $("#admin_resetpass_form").validate({
        errorClass: "alert-danger",
        rules: {
          
          newPassword: {
            required: true,
            
          },
          
          confirmPassword: {
            required: true,
            equalTo:"#new_password"
          },

        },
        messages:{
          
          newPassword:"New password field can not be empty.",
          confirmPassword:{
                  required:"Confirm password field can not be empty.",
                  equalTo:"Confirm password field do not match.",
            }
          
        },
        submitHandler: function (form) {
          form.submit();
        }
      });   

     // =====jquery code to change admin password ===========

    $("#admin_changepass_form").validate({
            errorClass: "alert-danger",
            rules: {

              oldPassword: {
                required: true,
                
              },
              
              newPassword: {
                required: true,
                
              },
              
              confirmPassword: {
                required: true,
                equalTo:"#new_password"
              },

            },
            messages:{

              oldPassword:"Old password field can not be empty.",
              newPassword:"New password field can not be empty.",
              confirmPassword:{
                      required:"Confirm password field can not be empty.",
                      equalTo:"Confirm password field do not match."
                }
              
            },
            submitHandler: function (form) {
              form.submit();
            }
      }); 



      // ============================== CATEGORY ADD =======================

    $("#category_add_form").validate({
            errorClass: "alert-danger",
            rules: {
                          categoryname: {
                required: true,
                minlength:4,
                maxlength:10
                
              }  
            },
            messages:{
                      categoryname:{
                            required:"Please enter the category name", 
                            minlength:"Name field must be at least 4 characters in length.",
                            maxlength:"Name field contain only 10 characters in length."
                           }
                     
            
                },
              
            submitHandler:function (form) {
              form.submit();
            }
      });


       
/// ============================ CATEGORY ADD ================================



// ============================= FORMULATE STATUS ==============================


$("#user_form").validate({
            errorClass: "alert-danger",
            rules: {

              no_usage: {
                required: true,
                
              },
              
              rvw_rate: {
                required: true,
                
              },
              
              money_topup: {
                required: true,
                
              },

              no_visit: {
                required: true,
                
              },

               frnd_recmnd: {
                required: true,
                
              },

              mrchnt_recmnd: {
                required: true,
                
              },

              cncl_deals: {
                required: true,
                
              },

            },
            messages:{

               no_usage:"This field can not be empty.",
               rvw_rate:"This field can not be empty.",
               money_topup:"This field can not be empty.",
               no_visit:"This field can not be empty.",
               frnd_recmnd:"This field can not be empty.",
               mrchnt_recmnd:"This field can not be empty.",
               cncl_deals:"This field can not be empty."
              
                },
              
            
            submitHandler: function (form) {
              form.submit();
            }
      }); 



$("#driver_form").validate({
            errorClass: "alert-danger",
            rules: {

              deliver: {
                required: true,
                
              },
              
              rate_user: {
                required: true,
                
              },
              
              credit: {
                required: true,
                
              },

              cancel_deals: {
                required: true,
                
              },
            },
            messages:{

               deliver:"This field can not be empty.",
               rate_user:"This field can not be empty.",
               credit:"This field can not be empty.",
               cancel_deals:"This field can not be empty."
                },
              
            
            submitHandler: function (form) {
              form.submit();
            }
      }); 





// ============================= FORMULATE STATUS ============================== 


// ==========================REJECTION DRIVER MAIL VALIDATION ==================
    
    $("#reject_driver_form").validate({
            errorClass:"alert-danger",
            rules:{
                    comment:{
                              required:true,
                              minlength:100,
                              maxlength:255
                    }
            },
            message:{ 
                      comment:{
                                required:"Please tell your rejection reason",
                                minlength:"Reason must be at least 100 characters in length. ",
                                maxlength:"Reason will contain maximum 255 characters."
                      },
                     
            },

             submitHandler:function (form) {
              form.submit();
            }
      });
   
  

    // ==========================REJECTION DRIVER MAIL VALIDATION ==================

    // ========================== ADD BANNER VALIDATIONN ============================

    $("#add_banner_form").validate({
            errorClass: "alert-danger",
            rules: {
                          name: {
                required: true,
                minlength:4,
                maxlength:20
                
              },

               image: {
                required: true,
                minImageWidth: 720,
                minImageHeight: 400
               
             }
                
            },
            messages:{
                      name:{
                            required:"Please enter the Banner name", 
                            minlength:"Name field must be at least 4 characters in length."
                           },
                     
            
                     image:{
                      required:"Please select banner image",
                     
                    }
                },
              
            submitHandler:function (form) {
              form.submit();
            }
      });


 // ========================== ADD BANNER VALIDATIONN ===========================
  


   //=========================== ADD MART AND FOOD VALIDATION =========================


   $("#add_mart_form").validate({
            errorClass: "alert-danger",
            rules: {
                          martname: {
                required: true,
                minlength:4,
                maxlength:10
                
              },
               restaurantname: {
                required: true,
                minlength:4,
                maxlength:13
                
              },
              
                number: {
                required: true,
                maxlength: 13
               
                
              },
              
                email: {
                required: true,
                email:true
              },

                address: {
                required: true,
                minlength:10,
               maxlength:30
                
              },
              
              banner_image: {
                required: true,
              },
              
              logo_image: {
                required: true, 
              },

              sel1: {
                required: true,
              },
              
              product_name: {
                required: true,
                minlength:4,
                maxlength:15

               },
               food_name: {
                required: true,
                
              },
               quantity: {
                required: true,
                 digits: true,
                 minlength: 1
               
              },
               price: {
                  required: true,
                  number:true,
                  minlength:1,
                  maxlength:8
               
              },
               food_image: {
                required: true,
               
               
             }
                
            },
            messages:{
                     
                      martname:{
                                 required:"Please enter the martname",
                                 rangelength:"enter valid time"
                               },
                      number:{
                                 required:"Please enter the contact number",
                                 maxlength:"Contact number must be with country code",
                                 digits: "Only numbers will allow"
                             },
                      email:{
                                 required:"Please enter the email", 
                                 email:"Please enter valid mail"
                            },
                      address:
                              {
                                 required:"Please enter mart address",
                                 rangelength:"Address will be contain minimum 10 and maximum 30 characters"
                              },
                      banner_image:"Please choose file",
                      logo_image:"Please choose file",
                             
                          
              product_name:{
                             required:"Please the product name",
                             maxlength:"Product name will be contain maximum 15 characters",
                             minlength:"Product name should have contain minimum 4 characters"
                           },

              food_name:{
                             required:"Please entering food name",
                             maxlength:"food name will be contain maximum 15 characters",
                             minlength:"food name should have contain minimum 4 characters"
                           },
              quantity:{
                        required:"Please enter minimum 1 quantity",
                        digits  :"Only numbers will allow",
                        minlength:"Please select atleast 1 quantity"
                      },
              price:{
                      required:"Please enter the price",
                      number:"Please enter number or decimal number",
                      minlength:"Price will be contain atleast 1 character",
                      maxlength:"Price will be contain maximum 8 character"
                    },
                    sel1:{
                      required:"Please select the category"
                     
                    },
                     food_image:{
                      required:"Please select the category"
                     
                    }
              
              
                },
              
            submitHandler:function (form) {
              form.submit();
            }
      });


  }); 

   // ==========================ADD MART FOOD VALIDATION ========================== 

   

    


    


 

 // +++++++++++++++++++++++++++ TIME PICKER OF JQUERY +++++++++++++++++++++++

//  FOR opening

$('#opening_time').timepicker({
     timeFormat: 'h:mm p',
    interval: 5,
    minTime: '1',
    maxTime: '11:59pm',
    defaultTime: '00:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

// FOR closing 

$('#closing_time').timepicker({
    timeFormat: 'h:mm p',
    interval: 5,
    minTime: '1',
    maxTime: '11:59pm',
    defaultTime: '00:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

 // +++++++++++++++++++++++++++ TIME PICKER OF JQUERY +++++++++++++++++++++++





//----------------common function for admin  section required-----------
    function set_limit(get_val){
        if(get_val!=''){
            $("#set_limit_val").val(get_val);
            document.getElementById("search_from").submit();

        }
    }
  
    //-------
    function action_handler(action,url){
        
        var selectedIds = [];
        var is_chcked = $('.select-comm:checked').length;
        var csrf_token =  $("#csrf").val();
        //--------if checkbox is selected---------
        
        if(is_chcked){
            
            $(".select-comm:checked").each(function(){
               selectedIds.push($(this).val());
            });
            //---------------------------
            if(action!='' && url!=''){
                if(action=="Delete"){
                  if(!confirm('Are you sure,you want to delete record(s) ?')){
                     return false;
                  }
                }
            
            if(action=="Activate"){
              if(!confirm('Are you sure,you want to active record(s) ?')){
                 return false;
              }
            }
            

            if (action == "Inactivate") {
                if (!confirm('Are you sure,you want to inactive record(s) ?')) {
                    return false;
                }
            }
              
                $.ajax({
                      type: "POST",
                      url: baseUrl+url,
                      dataType:"json",
                      data: {"ids":selectedIds,"action":action,"csrf_test_name":csrf_token},
                      success: function(response){
                         if(response.code==200){
                           location.reload();

                         }
                      }
                });
            }
            else{
                alert("Some request parameter is missing");
                return false;
            }
           
        }
        else{
            
            $('#maction').val('');
            alert("please select row using checkbox");
            return false;
        }
    }
     //--------search add cross btn on key press --
    $('.search-box').keyup(function() {
        if ($.trim($('.search-box').val()).length) {
            $(this).parent().addClass('cross-btn');
        } else {
            $(this).parent().removeClass('cross-btn');
        }
    });
    $('.srch-type-close-icon ').click(function() {
       
        $('input[type="text"]').val('');
        $('.srch-wrap').removeClass('cross-btn');
    });
    
    
  // image and video validation

function addBlog()
{
   
     if($('#upload1').val()==''){
     errortemplate('upload1','file_s','Blog image/video required');
     return false;
    }
    if($('#title').val()==''){
     errortemplate('title','title_s','Blog title required');
     return false;
    }
    if($('#page_desc').val()==''){
     errortemplate('description','description_s','Blog description required');
     return false;
    }
     
     $('.loder_wrap').css("display","block");
   
}


function editBlog()
{
   
     if(($('#upload1').val()=='')&&('#editblog').val()==''){
     errortemplate('upload1','file_s','Blog image/video required');
     return false;
    }
    if($('#title').val()==''){
     errortemplate('title','title_s','Blog title required');
     return false;
    }
    if($('#page_desc').val()==''){
     errortemplate('description','description_s','Blog description required');
     return false;
    }
     
     $('.loder_wrap').css("display","block");
   
}


$('.exportCsv').click(function () 
{ var filter = {}; 
    filter = $('#filterVal').val(); 
    var pageUrl = $('#pageUrl').val(); 
    filter = JSON.parse(filter); 
    filter['export'] = 1; 
    var queryParams = $.param(filter); 
    window.location.href = pageUrl + '?' + queryParams; 
});
