

// (function (factory) {
//   if (typeof define === "function" && define.amd) {
//     define(["jquery"], factory);
//   } else {
//     factory(jQuery);
//   }
// })(function ($) {

//   "use strict";

//   var log = function (o) {
//         try {
//           console.log(o)
//         } catch (e) {}
//       };

//   function CropAvatar($element) {
//     this.$container = $element;

//     this.$avatarView = this.$container.find(".avatar-view");
//     this.$avatar = this.$avatarView.find("img");
//     this.$avatarModal = this.$container.find("#avatar-modal");
//     this.$loading = this.$container.find(".loading");

//     this.$avatarForm = this.$avatarModal.find(".avatar-form");
//     this.$avatarUpload = this.$avatarForm.find(".avatar-upload");
//     this.$avatarSrc = this.$avatarForm.find(".avatar-src");
//     this.$avatarData = this.$avatarForm.find(".avatar-data");
//     this.$avatarInput = this.$avatarForm.find(".avatar-input");
//     this.$avatarSave = this.$avatarForm.find(".avatar-save");

//     this.$avatarWrapper = this.$avatarModal.find(".avatar-wrapper");
//     this.$avatarPreview = this.$avatarModal.find(".avatar-preview");

//     this.init();
//     log(this);
//   }

//   CropAvatar.prototype = {
//     constructor: CropAvatar,

//     support: {
//       fileList: !!$("<input type=\"file\">").prop("files"),
//       fileReader: !!window.FileReader,
//       formData: !!window.FormData
//     },

//     init: function () {
//       this.support.datauri = this.support.fileList && this.support.fileReader;

//       if (!this.support.formData) {
//         this.initIframe();
//       }

//       this.initTooltip();
//       this.initModal();
//       this.addListener();
//     },

//     addListener: function () {
//       this.$avatarView.on("click", $.proxy(this.click, this));
//       this.$avatarInput.on("change", $.proxy(this.change, this));
//       this.$avatarForm.on("submit", $.proxy(this.submit, this));
//     },

//     initTooltip: function () {
//       this.$avatarView.tooltip({
//         placement: "bottom"
//       });
//     },

//     initModal: function () {
//       this.$avatarModal.modal("hide");
//       this.initPreview();
//     },

//     initPreview: function () {
//       var url = this.$avatar.attr("src");

//       this.$avatarPreview.empty().html('<img src="' + url + '" class="resimg">');
//     },

//     initIframe: function () {
//       var iframeName = "avatar-iframe-" + Math.random().toString().replace(".", ""),
//           $iframe = $('<iframe name="' + iframeName + '" style="display:none;"></iframe>'),
//           firstLoad = true,
//           _this = this;

//       this.$iframe = $iframe;
//       this.$avatarForm.attr("target", iframeName).after($iframe);

//       this.$iframe.on("load", function () {
//         var data,
//             win,
//             doc;

//         try {
//           win = this.contentWindow;
//           doc = this.contentDocument;

//           doc = doc ? doc : win.document;
//           data = doc ? doc.body.innerText : null;
//         } catch (e) {}

//         if (data) {
//           _this.submitDone(data);
//         } else {
//           if (firstLoad) {
//             firstLoad = false;
//           } else {
//             _this.submitFail("Image upload failed!");
//           }
//         }

//         _this.submitEnd();
//       });
//     },

//     click: function () {
//       this.$avatarModal.modal("show");
//     },

//     change: function () {
//       var files,
//           file;

//       if (this.support.datauri) {
//         files = this.$avatarInput.prop("files");

//         if (files.length > 0) {
//           file = files[0];

//           if (this.isImageFile(file)) {
//             this.read(file);
//           }
//         }
//       } else {
//         file = this.$avatarInput.val();

//         if (this.isImageFile(file)) {
//           this.syncUpload();
//         }
//       }
//     },

//     submit: function () {
//       if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
//         return false;
//       }

//       if (this.support.formData) {
//         this.ajaxUpload();
//         return false;
//       }
//     },

//     isImageFile: function (file) {
//       if (file.type) {
//         return /^image\/\w+$/.test(file.type);
//       } else {
//         return /\.(jpg|jpeg|png|gif)$/.test(file);
//       }
//     },

//     read: function (file) {
//       var _this = this,
//           fileReader = new FileReader();

//       fileReader.readAsDataURL(file);

//       fileReader.onload = function () {
//         _this.url = this.result
//         _this.startCropper();
//       };
//     },

//     startCropper: function () {
//       var _this = this;

//       if (this.active) {
//         this.$img.cropper("setImgSrc", this.url);
//       } else {
//         this.$img = $('<img src="' + this.url + '">');
//         this.$avatarWrapper.empty().html(this.$img);
//         this.$img.cropper({
//           aspectRatio: 1,
//           preview: this.$avatarPreview.selector,
//           done: function (data) {
//             var json = [
//                   '{"x":' + data.x,
//                   '"y":' + data.y,
//                   '"height":' + data.height,
//                   '"width":' + data.width + "}"
//                 ].join();

//             _this.$avatarData.val(json);
//           }
//         });

//         this.active = true;
//       }
//     },

//     stopCropper: function () {
//       if (this.active) {
//         this.$img.cropper("disable");
//         this.$img.data("cropper", null).remove();
//         this.active = false;
//       }
//     },

//     ajaxUpload: function () {
//       var url = this.$avatarForm.attr("action"),
//           data = new FormData(this.$avatarForm[0]),
//           _this = this;
//   data.append('username', this.$avatarForm.attr("id"));
// //data.append('username', this.$avatarForm.attr("id"));
//       $.ajax(url, {
//         type: "post",
//         data: data,
//         processData: false,
//         contentType: false,

//         beforeSend: function () {
//           _this.submitStart();
//         },

//         success: function (data) {
//           _this.submitDone(data);
//         },

//         error: function (XMLHttpRequest, textStatus, errorThrown) {
//           _this.submitFail(textStatus || errorThrown);
//         },

//         complete: function () {
//           _this.submitEnd();
//         }
//       });
//     },

//     syncUpload: function () {
//       this.$avatarSave.click();
//     },

//     submitStart: function () {
//       this.$loading.fadeIn();
//     },

//     submitDone: function (data) {
//       log(data);

//       try {
//         data = $.parseJSON(data);
//       } catch (e) {};

//       if (data && data.state === 200) {
//         if (data.result) {
//           this.url = data.result;

//           if (this.support.datauri || this.uploaded) {
//             this.uploaded = false;
//             this.cropDone();
//           } else {
//             this.uploaded = true;
//             this.$avatarSrc.val(this.url);
//             this.startCropper();
//           }

//           this.$avatarInput.val("");
//         } else if (data.message) {
//           this.alert(data.message);
//         }
//       } else {
//         this.alert("Failed to response");
//       }
//     },

//     submitFail: function (msg) {
//       this.alert(msg);
//     },

//     submitEnd: function () {
//       this.$loading.fadeOut();
//     },

//     cropDone: function () {
//         this.$avatarModal.modal("hide");
//       this.$avatarSrc.val("");
//       this.$avatarData.val("");
//       this.$avatar.attr("src", this.url+'?'+new Date().valueOf());
//       //alert(this.$avatar.attr('id'));
    
     
//          $("#"+this.$avatar.attr('id')+"_val").val(this.url);
         
     
//       this.stopCropper();
//      // this.$avatarModal.modal("hide");
//     },

//     alert: function (msg) {
//       var $alert = [
//             '<div class="alert alert-danger avater-alert">',
//               '<button type="button" class="close" data-dismiss="alert">&times;</button>',
//               msg,
//             '</div>'
//           ].join("");

//       this.$avatarUpload.after($alert);
//     }
//   };

//   $(function () {
//       //var image_no=0;
//     var example = new CropAvatar($("#crop-avatar"));
//     var example2 = new CropAvatar($("#crop-vehicle"));
//       var example3 = new CropAvatar($("#crop-avatar2"));
//     var example4 = new CropAvatar($("#crop-vehicle2"));
//   });
  
  
//   $('.newclick').click(function(){ 
 
    
          
//            $('#append').append('<div id="newform'+image_no+'" style="position:relative;margin-top:60px;"><div class="col-xs-12" style="top:-25px"><h1 class="formno">'+(image_no+1)+'</h1></div><div class="row clearfix margintop10 portlet portlet-orange"><div class=""><div id="inlineFormExample" class="" style="height: auto;"><h1 class="fa fa-times closbtn" onclick="howw('+image_no+');" data="'+image_no+'"></h1><div class="forminnerspace" style="padding:0 !important;"><!--right_panel_form START--><div class=" col-sm-5 col-md-5 col-lg-5 clearfix userprofileimg"><div id="crop-avatar'+image_no+'"><input type="hidden" name="image_path_2[]" value="" id="image_path'+image_no+'"> <!-- Current avatar --> <div class="avatar-view" title="Profile Picture"> <img src="public/image/default_user.png" alt="Avatar" class="resimg"> </div> <!-- Cropping modal --> <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label" aria-hidden="true"> <div class="modal-dialog modal-lg"> <div class="modal-content"> <form id="'+image_no+'"class="avatar-form" method="post" action="public/crop-avatar.php" enctype="multipart/form-data"> <div class="modal-header"> <h1 class="closbtn" style="right: -22px;border: none !important;" data-dismiss="modal"><i class="fa fa-close"></i></h1> <h4 class="modal-title" id="avatar-modal-label">Profile Picture</h4> </div> <div class="modal-body"> <div class="avatar-body"> <!-- Upload image and data --> <div class="avatar-upload"> <input class="avatar-src" name="avatar_src" type="hidden"> <input class="avatar-data" name="avatar_data" type="hidden"> <label for="avatarInput"></label> <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"> </div> <!-- Crop and preview --> <div class="row"> <div class="col-md-9"> <div class="loading" tabindex="-1" role="img" aria-label="Loading"></div><div class="avatar-wrapper"></div> </div> <div class="col-md-3"> <div class="avatar-preview preview-lg" style="position:relative;"></div> <div class="avatar-preview preview-md" style="position:relative;"></div> <div class="avatar-preview preview-sm" style="position:relative;"></div> </div> </div> </div> </div> <div class="modal-footer"><button class="btn btn-primary avatar-save col-sm-2 pull-right" type="submit" style="margin-left:10px;">Save</button> <button class="btn btn-default col-sm-2 pull-right" type="button" data-dismiss="modal">Close</button> </div> </form> </div> </div> </div><!-- /.modal --> <!-- Loading state --> </div><div id="crop-vehicle'+image_no+'"> <!-- Current avatar --> <div class="avatar-view userimg_byratio" title="Vehicle Picture"> <img src="public/image/vehicle.png" alt="Avatar" class="resimg"> </div> <!-- Cropping modal --> <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label" aria-hidden="true"> <div class="modal-dialog modal-lg"> <div class="modal-content"> <form class="avatar-form" id="v'+image_no+'" method="post" action="public/crop-avatar.php" enctype="multipart/form-data"> <div class="modal-header"> <h1 class="closbtn" style="right: -22px;border: none !important;" data-dismiss="modal"><i class="fa fa-close"></i></h1> <h4 class="modal-title" id="avatar-modal-label">Vehicle Picture</h4> </div> <div class="modal-body"> <div class="avatar-body"> <!-- Upload image and data --> <div class="avatar-upload"> <input class="avatar-src" name="avatar_src" type="hidden"> <input class="avatar-data" name="avatar_data" type="hidden"> <label for="avatarInput"></label> <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"> </div> <!-- Crop and preview --> <div class="row"> <div class="col-md-9"> <div class="loading" tabindex="-1" role="img" aria-label="Loading"></div><div class="avatar-wrapper"></div> </div> <div class="col-md-3"> <div class="avatar-preview preview-lg" style="position:relative;"></div> <div class="avatar-preview preview-md" style="position:relative;"></div> <div class="avatar-preview preview-sm" style="position:relative;"></div> </div> </div> </div> </div> <div class="modal-footer"><button class="btn btn-primary avatar-save col-sm-2 pull-right" type="submit" style="margin-left:10px;">Save</button> <button class="btn btn-default col-sm-2 pull-right" type="button" data-dismiss="modal">Close</button></div> </form> </div> </div> </div><!-- /.modal --> <!-- Loading state --> </div> </div></div></div> <!--right_panel_form START--> <div class="col-sm-7 col-md-7 col-lg-7 clearfix"> <div class="form-group clearfix spance"><label class="control-label col-sm-4 col-md-4"></label> <input type="hidden" name="driver_image2[]" value="'+image_no+'"class="col-sm-6 lg-6 inputfild driver_name name"/></div> <div class="form-group clearfix spance"><label class="control-label col-sm-4 col-md-4">Name<span class="mandat_star">*</span></label> <input type="text" name="driver_name2[]" class="col-sm-6 lg-6 inputfild driver_name name"/></div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">Father Name<span class="mandat_star">*</span></label> <input type="text" name="driver_father2[]" class="col-sm-6 col-lg-6 inputfild driver_name name"/></div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">Email<span class="mandat_star">*</span></label> <input type="email" id="driver_email" name="driver_email2[]" class="col-sm-6 col-lg-6 inputfild name" /></div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">Refrenced By<span class="mandat_star">*</span></label> <input type="text" id="driver_email" name="driver_ref2[]" class="col-sm-6 col-lg-6 inputfild name" /> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">Date Of Birth<span class="mandat_star">*</span></label> <input type="text" id="dateofbirth'+image_no+'" name="dateofbirth'+image_no+'[]" class="col-sm-6 col-lg-6 inputfild name dateofdriver" /> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">Gender<span class="mandat_star">*</span></label> <!--<input type="text" id="gender2" name="gender2[]" class="col-sm-6 col-lg-6 inputfild name" />--><select class=" col-sm-6 inputfild" id="gender2"  name="gender2[]"><option>Male</option><option>Female</option></select> </div><div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">City<span class="mandat_star">*</span></label> <input type="text" id="autocomplete'+image_no+'" onfocus="geolocate()"  name="city2[]" class="col-sm-6 col-lg-6 inputfild name" placeholder="Enter a location" /> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">Contact No.<span class="mandat_star">*</span></label> <input type="text" id="driver_no" name="phno[]" class=" col-sm-6 col-lg-6 inputfild phno"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4 col-md-4">Alternate Contact No.<span class="mandat_star">*</span></label> <input type="text" id="driver_Altno" name="phno2[]" class=" col-sm-6 col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Residential Address<span class="mandat_star">*</span></label> <textarea rows="3" id="driver_adds" name="add2[]" cols="5" class="col-lg-6 inputfild name"></textarea> <div class="col-sm-2"> <input name="file'+image_no+'" type="file" /> <div class="fa fa-spinner fa-spin fa-1_5x" style="position: absolute;color: #378D18; display:none" id="driver_resident_loderH'+image_no+'" ></div> <div class="loder" style="display:none" id="driver_residentH'+image_no+'"></div></div><input type="hidden" name="fileHa[]" id="fileHa'+image_no+'"> </div> <div class="form-group clearfix spance"><label class="control-label col-sm-4 col-md-4">Pin Code<span class="mandat_star">*</span></label> <input type="text" name="driver_pin2[]" class="col-sm-6 lg-6 inputfild driver_name name"/></div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Office Address<span class="mandat_star">*</span></label> <textarea rows="3" id="driver_oadds" name="oadd2[]" cols="5" class="col-lg-6 inputfild name"></textarea> <div class="col-sm-2"><input name="file_office'+image_no+'" type="file" /> <div class="fa fa-spinner fa-spin fa-1_5x" style="position: absolute;color: #378D18; display: none" id="driver_office_loderH'+image_no+'"></div> <div class="loder" style="display:none" id="driver_officeH'+image_no+'"></div></div> <input type="hidden" name="file_officeHa[]" id="file_officeHa'+image_no+'"> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Pan Card Details<span class="mandat_star">*</span></label> <input type="text" id="driver_pan" name="pan2[]" class="col-lg-6 inputfild name"/><div class="col-sm-2"><input name="file_pan'+image_no+'" type="file" /> <div class="fa fa-spinner fa-spin fa-1_5x" style="position: absolute;color: #378D18;display:none" id="driver_panupload_loderH'+image_no+'"></div> <div class="loder" style="display:none" id="driver_panuploadH'+image_no+'"></div><input type="hidden" name="file_panHa[]" id="file_panHa'+image_no+'"> </div> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">No. of Fleet<span class="mandat_star">*</span></label> <select name="fleet2[]" class=" col-sm-6 inputfild"> <option>1</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Name of Vehicle<span class="mandat_star">*</span></label> <input type="text" class="col-lg-6 inputfild name secodformV" name="nameV2[]"/><!--<input type="hidden" class="col-lg-6 inputfild name secodformVH'+image_no+'" name="nameVids2[]"/>--> <div class="col-sm-2"> <input name="file_vehicle'+image_no+'" type="file" /> <!--<progress max="100" value="0" style="visibility: hidden;" id="driver_vehicle"> </progress> --> <div class="fa fa-spinner fa-spin fa-1_5x" style="position: absolute;color: #378D18;display:none;" id="driver_vehicle_loderH'+image_no+'"></div> <div class="loder" style="display:none" id="driver_vehicleH'+image_no+'"></div><input type="hidden" name="file_vehicleHa[]" id="file_vehicleHa'+image_no+'"> </div> </div><div class="form-group clearfix spance"> <label class="control-label col-sm-4">Car Types<span class="mandat_star">*</span></label> <select name="driver_cartypes2[]" class=" col-sm-6 inputfild"> <option value="1">Economy</option> <option value="2">Sedan</option> <option value="3">Prime</option>  </select> </div>  <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Make of Vehicle<span class="mandat_star">*</span></label> <input type="text" class="col-lg-6 inputfild name" name="maveh2[]"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Model Year<span class="mandat_star">*</span></label> <input type="text" class="col-lg-6 inputfild name" name="moveh2[]"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Badge / License No.<span class="mandat_star">*</span></label> <input type="text" class="col-lg-6 inputfild name" name="lic2[]" inputfild/><div class="col-sm-2"> <input name="file_badge'+image_no+'" type="file" /> <!-- <progress max="100" value="0" style="visibility: hidden;" id="driver_badge"> </progress> --> <div class="fa fa-spinner fa-spin fa-1_5x" style="position: absolute;color: #378D18;display:none;" id="driver_badge_loderH'+image_no+'"></div> <div class="loder" style="display:none" id="driver_badgeH'+image_no+'"></div><input type="hidden" name="file_badgeHa[]" id="file_badgeHa'+image_no+'"> </div> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">License State*</label> <input type="text" class="col-lg-6 inputfild name" name="licState[]" inputfild/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Vehicle No.*</label> <input type="text" class="col-lg-6 inputfild name" name="vehicleNo2[]" inputfild/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Eye Sight<span class="mandat_star">*</span></label> <div class="col-sm-6"> <label class="radio-inline specs"> <input type="radio" name="optionsInlineRadios" value="" checked="" required="">Specs</label> <label class="radio-inline specs" style="padding-left:47px !important;"> <input type="radio" name="optionsInlineRadios" value="" required="">No Specs</label> </div> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Zone<span class="mandat_star">*</span></label> <input type="text" name="zone2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Security Amount*</label> <input type="text" name="SecurityAmt2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Bank Name & Branch Name<span class="mandat_star">*</span></label> <input type="text" name="driverBank2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Bank A/C Holder Name<span class="mandat_star">*</span></label> <input type="text" name="driverholdern2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Bank Address<span class="mandat_star">*</span></label> <input type="text" name="driverBaddess2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Bank A/C no<span class="mandat_star">*</span></label> <input type="text" name="driverAcNo2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">RTGS/NEFT Code<span class="mandat_star">*</span></label> <input type="text" name="driverrtgs2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">IBN No.<span class="mandat_star">*</span></label> <input type="text" name="driveribn2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Route Knowledge*</label> <input type="text" name="driveroute2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Pref Location*</label> <input type="text" name="driverpref2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Week Off*</label> <!--<input type="text" name="driverweek2[]" class="col-lg-6 inputfild name"/>--><select class=" col-sm-6 inputfild" id="driverweek2" name="driverweek2[]" ><option>Yes</option><option>No</option></select> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">Mobile IMEI No.*</label> <input type="text" name="driverIemi2[]" class="col-lg-6 inputfild name"/> </div> <div class="form-group clearfix spance"> <label class="control-label col-sm-4">GPS Device No.*</label> <input type="text" name="drivergps2[]" class="col-lg-6 inputfild name"/> </div> <div class="clearfix"> <label class="control-label col-sm-4">Language Known<span class="mandat_star">*</span></label> </div> <div class="form-group clearfix spance"> <table class="table" style="margin:0;"> <tbody><tr> <td style="border: none;" class="col-sm-4 "> <table class="reglengbox "> <tbody><tr><td style="border: none;">Write<span class="mandat_star">*</span></td></tr> <tr><td style="border: none; padding-top:7px;">Speak<span class="mandat_star">*</span></td></tr> </tbody></table> </td> <td style="border: none; padding:0;"> <table class="reglengbox"> <tbody><tr><td><input type="text" name="write2[]" class=" inputfild "/></td><td><input type="text" name="write3[]" class=" inputfild "/></td><td><input type="text" name="write4[]" class=" inputfild "/></td><td><input type="text" name="write5[]" class=" inputfild "/></td></tr> <tr><td><input type="text" name="speak2[]" class=" inputfild "/></td><td><input type="text" name="speak3[]" class=" inputfild "/></td><td><input type="text" name="speak4[]" class=" inputfild "/></td><td><input type="text" name="speak5[]" class=" inputfild "/></td></tr> </tbody></table> </td> </tr> </tbody></table> </div> <div class="form-group clearfix spance"> <table class="table" style="margin:0;"> <tbody><tr> <td style="border: none;" class="col-sm-4 "> <table class="reglengbox "> <tbody><tr><td style="border: none;">Shift of Login<span class="mandat_star">*</span></td></tr> <tr><td style="border: none; padding-top:5px;">Timing</td></tr> </tbody></table> </td> <td style="border: none; padding-left:0;"> <table class="reglengbox"> <tbody><tr><td>Morning</td><td>Evening</td><td>Night</td></tr> <tr> <td> <!--<input type="text" name="logtime2[]" class=" inputfild "/>--> <select class="inputfild" id="" name="logtime2[]" > <option>0:00</option> <option>1:00</option> <option>2:00</option> <option>3:00</option> <option>4:00</option> <option>5:00</option> <option>6:00</option> <option>7:00</option> <option>8:00</option> <option>9:00</option> <option>10:00</option> <option>11:00</option> <option>12:00</option> <option>13:00</option> <option>14:00</option> <option>15:00</option> <option>16:00</option> <option>17:00</option> <option>15:00</option> <option>19:00</option> <option>20:00</option> <option>21:00</option> <option>22:00</option> <option>23:00</option> </select> </td><td> <!--<input type="text" name="logtime3[]" class=" inputfild "/>--> <select class="inputfild" id="" name="logtime3[]" > <option>0:00</option> <option>1:00</option> <option>2:00</option> <option>3:00</option> <option>4:00</option> <option>5:00</option> <option>6:00</option> <option>7:00</option> <option>8:00</option> <option>9:00</option> <option>10:00</option> <option>11:00</option> <option>12:00</option> <option>13:00</option> <option>14:00</option> <option>15:00</option> <option>16:00</option> <option>17:00</option> <option>15:00</option> <option>19:00</option> <option>20:00</option> <option>21:00</option> <option>22:00</option> <option>23:00</option> </select> </td><td> <!--<input type="text" name="logtime4[]" class=" inputfild "/>--> <select class="inputfild" id="" name="logtime4[]" > <option>0:00</option> <option>1:00</option> <option>2:00</option> <option>3:00</option> <option>4:00</option> <option>5:00</option> <option>6:00</option> <option>7:00</option> <option>8:00</option> <option>9:00</option> <option>10:00</option> <option>11:00</option> <option>12:00</option> <option>13:00</option> <option>14:00</option> <option>15:00</option> <option>16:00</option> <option>17:00</option> <option>15:00</option> <option>19:00</option> <option>20:00</option> <option>21:00</option> <option>22:00</option> <option>23:00</option> </select> </td></tr> </tbody></table> </td> </tr> </tbody> </table> </div> </div> <div class="clearfix"></div> <div class="col-sm-12 col-md-12 col-lg-12"> <div class="form-group clearfix marginbtom0"> <label class="control-label col-lg-2 pull-left" style="margin-right:30px !important;">Duty Type pref.<span class="mandat_star">*</span></label> <div class="col-sm-9 pull-left leftmarg10" style="padding-left:0 !important;"> <label class="checkbox-inline checkboxtext leftmarg10 col-md-2"> <input type="checkbox" class="dAir2" data="'+image_no+'" name="dAir2[]" value="1">Airport Transf </label> <label class="checkbox-inline checkboxtext col-md-2"> <input type="checkbox" class="dAir3" data="'+image_no+'" name="dAir3[]" value="2">Outstation </label> <label class="checkbox-inline checkboxtext col-md-2"> <input type="checkbox" class="dAir4" data="'+image_no+'" name="dAir4[]" value="3">Local Packg </label> <label class="checkbox-inline checkboxtext col-md-2"> <input type="checkbox" class="dAir5" data="'+image_no+'" name="dAir5[]" value="4">Point To Point </label> <label class="checkbox-inline checkboxtext col-md-2"> <input class="dAir6" data="'+image_no+'" type="checkbox" name="dAir6[]" value="5">All </label> </div> </div> </div> <div class="col-sm-12 col-md-12 col-lg-12"> <div class="form-group clearfix"> <label class="control-label col-lg-2 pull-left" style="margin-right:30px !important;">Payment Type<span class="mandat_star">*</span></label> <div class="col-sm-9 pull-left leftmarg10" style="padding-left:0 !important;"> <label class="checkbox-inline checkboxtext leftmarg10 col-md-2"> <input type="checkbox" name="dCash2[]" value="1" class="dCash2" datacash="'+image_no+'">Cash </label> <label class="checkbox-inline checkboxtext col-md-2"> <input type="checkbox" name="dCash3[]" value="2" class="dCash3" datacash="'+image_no+'">Credit </label> <label class="checkbox-inline checkboxtext col-md-2"> <input type="checkbox" name="dCash4[]" value="3" class="dCash4" datacash="'+image_no+'">Both </label> </div> </div> </div> <div class="form-group clearfix col-sm-12"> <label class="control-label col-sm-2" style="margin-right:20px !important;">Police Verification<span class="mandat_star">*</span></label><div class="col-sm-4"> <input name="file_police'+image_no+'" type="file"/> <div class="fa fa-spinner fa-spin fa-1_5x" style="position: absolute;color: #378D18;display:none;" id="driver_police_loderH'+image_no+'"></div> <div class="loder" style="display:none" id="driver_policeH'+image_no+'"></div><input type="hidden" name="file_policeHa[]" id="file_policeHa'+image_no+'"> </div></div> <div class="form-group clearfix col-sm-12"> <label class="control-label col-sm-2" style="margin-right:20px !important;">Audit Report<span class="mandat_star">*</span></label> <div class="col-sm-2"> <input name="file_audit'+image_no+'" type="file"/><div class="fa fa-spinner fa-spin fa-1_5x" style="position: absolute;color: #378D18;display:none;" id="driver_audit_loderH'+image_no+'"></div> <div class="loder" style="display:none" id="driver_auditH'+image_no+'"></div> <input type="hidden" name="file_auditHa[]" id="file_auditHa'+image_no+'"></div> <div class="col-sm-5 auditformdownload" > <i class="fa fa-download fa-1_5x"></i> &nbsp;<label>Click here to download the Audit Report</label></div> </div> </div> </div> </div> </div> </div>');
//        initialize("autocomplete"+image_no);
	   
	   
	   
  	   
	   
// 	   var site_url = jQuery.cookie('BaseUrl');
// 	   $( ".secodformV").autocomplete({
//       source: site_url+'/tunnel/menu/vehicles?key='+API_KEY,minLength: 3,
    
     
//     });
	   
// 	   ////////////////
// 	$(".dAir2").on('click',function(){
	
// 	var formNo = $(this).attr("data");
//   //alert(formNo);
//     $(".dAir6").prop('checked',false);
// });  
// $(".dAir3").on('click',function(){
//   //var formNo = $(this).attr("data");
//     $(".dAir6").prop('checked',false);
// });
// $(".dAir4").on('click',function(){
  
//     $(".dAir6").prop('checked',false);
// });
// $(".dAir5").on('click',function(){
  
//     $(".dAir6").prop('checked',false);
// });
// $(".dAir6").on('click',function(){
// 		$(".dAir2").prop('checked',false);
// 		$(".dAir3").prop('checked',false);
// 		$(".dAir4").prop('checked',false);
// 		$(".dAir5").prop('checked',false);
		
// });

// $(".dCash4").on('click',function(){
    
//      $(".dCash2").prop('checked',false);
//     $(".dCash3").prop('checked',false);
// });

// $(".dCash2").on('click',function(){
  
//     $(".dCash4").prop('checked',false);
// });
// $(".dCash3").on('click',function(){
  
//     $(".dCash4").prop('checked',false);
// });
	   
	   
	   
	   
	   
// 	   ////////////////////
	   
	   
	   
//            // formlength = $('div').length;
//            // jQuery.cookie('FormLength', image_no, { expires: 1 });
//           // alert(image_no);
//          // formlength = image_no+1;
           
//       var example = new CropAvatar($("#crop-avatar"+image_no));
//        var example2 = new CropAvatar($("#crop-vehicle"+image_no));
//        image_no=image_no+1;
//        form_no=form_no+1;
//        $('.formno').each(function(index){
//            $(this).html(index+2); 
            
//         });
       
// 	 $(".auditformdownload").on('click',function(e){
    
//     e.preventDefault();

//     //alert("download");
//     //var site_url = jQuery.cookie('BaseUrl');  
//     window.location.href = site_url+'/public/audit/Audit Sheet.xlsx';
    
// })  ;  
	   

	   
	   
//         });
// });



	   
	   

