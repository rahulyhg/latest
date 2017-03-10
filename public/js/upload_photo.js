jQuery(document).ready(function(){

jQuery('.photoimg').on('change', function(){ 
        jQuery(".preview-avatar-profile").html('');
        jQuery(".preview-avatar-profile").html('Uploading....');
        jQuery(".cropimage").ajaxForm(
        {
        target: '.preview-avatar-profile',
        success:    function() { 
                        jQuery('img.photo').imgAreaSelect({
                        aspectRatio: '0:0',
                        parent: '.preview-avatar-profile',
                        onSelectEnd: getSizes,
                });
                jQuery('.image_name').val(jQuery('.photo').attr('file-name'));
                }
        }).submit();

});

//// Function for Save Image Starts Here ////	 

jQuery('.btn-crop').on('click', function(e){
    e.preventDefault();
    params = {
        //targetUrl: 'profile.php?action=save',
        targetUrl: basePath + '/account/uploadProfileImage?action=save',
        action: 'save',
        x_axis: jQuery('.hdn-x1-axis').val(),
        y_axis : jQuery('.hdn-y1-axis').val(),
        x2_axis: jQuery('.hdn-x2-axis').val(),
        y2_axis : jQuery('.hdn-y2-axis').val(),
        thumb_width : jQuery('.hdn-thumb-width').val(),
        thumb_height:jQuery('.hdn-thumb-height').val()        
    };
    saveCropImage(params);
});

//// Function for Save Image Ends Here ////
	    
//// Function for Get the Image Size Starts Here ////	 
	    
function getSizes(img, obj)
{
    var x_axis = obj.x1;
    var x2_axis = obj.x2;
    var y_axis = obj.y1;
    var y2_axis = obj.y2;
    var thumb_width = obj.width;
    var thumb_height = obj.height;
    if(thumb_width > 0)
        {
            jQuery('.hdn-x1-axis').val(x_axis);
            jQuery('.hdn-y1-axis').val(y_axis);
            jQuery('.hdn-x2-axis').val(x2_axis);
            jQuery('.hdn-y2-axis').val(y2_axis);
            jQuery('.hdn-thumb-width').val(thumb_width);
            jQuery('.hdn-thumb-height').val(thumb_height);
            jQuery('.crop_enabled').val('yes');
        }
    else
        alert("Please select portion..!");
}
	
//// Function for Get the Image Size Ends Here ////
//
//// Function for Save the Crop Image Starts Here ////
        
function saveCropImage(params) {
jQuery.ajax({
    url: params['targetUrl'],
    cache: false,
    dataType: "html",
    data: {
        action: params['action'],
        id: jQuery('.hdn-profile-id').val(),
         t: 'ajax',
                            w1:params['thumb_width'],
                            x1:params['x_axis'],
                            h1:params['thumb_height'],
                            y1:params['y_axis'],
                            x2:params['x2_axis'],
                            y2:params['y2_axis'],
       image_name :jQuery('.image_name').val(),
       crop_enabled:jQuery('.crop_enabled').val()
    },
    type: 'Post',
   // async:false,
    success: function (response) {
            alert(response);
            jQuery('.changePic').hide();
            jQuery('.change-pic').show();
            jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
            //jQuery(".avatar-edit-img").attr('src', response);
            jQuery(".preview-avatar-profile").html('');
            jQuery(".photoimg").val('');
            $('#avatar-modal1').modal('hide');
            window.location = window.location;

    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
    }
});
}

//// Function for Save the Crop Image Ends Here ////

});