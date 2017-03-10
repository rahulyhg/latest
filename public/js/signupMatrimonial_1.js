function chkduplicateMatrimonial(val, id, action) {
   // console.log(val);
    var queryString = 'id=' + id + '&value=' + val;

    // debugger;
    if (id == "email") {
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(val) == true) {
            $("#emailerror").html("");
            ajax_call_matrimonial_signup(queryString, action);
        } else {
            $("#emailerror").html("<p style='color:red;'>not a valid email</p>");
        }
    }
    if (id == "mobile_no") {
        if (/[0-9]/.test(val) == true && val.length == 10) {
            $("#" + id).next("span").html("");
            ajax_call_matrimonial_signup(queryString, action);
        } else {
            $("#" + id).next("span").html("<p style='color:red;'>not a valid number</p>");
        }
    }


    if (id == "username") {
        if (val.length > 6) {
            $("#" + id).next("span").html("");
            ajax_call_matrimonial_signup(queryString, action);
        } else {
            $("#" + id).next("span").html("<p style='color:red;'>username is too small </p>");
        }
        // alert(val);

    }

    if (id == "native_place") {
        var letters = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
        if (val.match(letters))
        {
            $("#" + id).next("span").html("");
        }
        else
        {
            $("#" + id).next("span").html("<p style='color:red;'>Please input alphabet characters only</p>");
        }

    }
    
    if (id == "referral_key") {
        if (val.length=="") {
             $("#" + id).next("span").html("<p style='color:red;'>Please Enter Referral Key </p>");
        } else {
             $("#" + id).next("span").html("");
             ajax_call_normal(queryString, action);
        }
        // alert(val);

    }
}

function ajax_call_matrimonial_signup(queryString, action) {

    $.ajax({
        url: action,
        type: "post",
        dataType: "JSON",
        data: queryString,
        beforeSend: function(){
            $('#Loading_Request').show();
        },
        complete: function(){
            $('#Loading_Request').hide();
        },
        success: function (data) {
    $("#" + data.id).next("span").html(data.message);
            if (data.id == "email") {
                $("#emailerror").html(data.message);
            }
        }
    })
    

}