$(window).load(function () {

    //console.log('on window load method');
    //debugger;		
    $("#flexiselDemo1").flexisel({
        visibleItems: 3,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 5000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        //console.log('flexiselDemo1');


        responsiveBreakpoints: {
            portrait: {
                changePoint: 481,
                visibleItems: 1
            },
            tablet: {
                changePoint: 769,
                visibleItems: 2
            }
        }
    });
    //debugger;
    $("#flexiselDemo2").flexisel({
        //alert('flexiselDemo2');						  					  	
        visibleItems: 1,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 5000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 480,
                visibleItems: 1
            },
            landscape: {
                changePoint: 640,
                visibleItems: 2
            },
            tablet: {
                changePoint: 769,
                visibleItems: 2
            }
        }
    });

    $("#flexiselDemo3").flexisel({
        //alert('flexiselDemo3');
        visibleItems: 8,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 5000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 481,
                visibleItems: 2
            },
            landscape: {
                changePoint: 640,
                visibleItems: 4
            },
            tablet: {
                changePoint: 769,
                visibleItems: 4
            }
        }
    });

    $("#flexiselDemo4").flexisel({
        //alert('flexiselDemo4');
        visibleItems: 8,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 5000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 481,
                visibleItems: 2
            },
            landscape: {
                changePoint: 640,
                visibleItems: 4
            },
            tablet: {
                changePoint: 769,
                visibleItems: 4
            }
        }
    });
    
    $("#flexiselDemo6").flexisel({
        //alert('flexiselDemo4');
        visibleItems: 8,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 5000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 481,
                visibleItems: 2
            },
            landscape: {
                changePoint: 640,
                visibleItems: 4
            },
            tablet: {
                changePoint: 769,
                visibleItems: 4
            }
        }
    });
    
    $("#flexiselDemo7").flexisel({
        //alert('flexiselDemo4');
        visibleItems: 8,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 5000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 481,
                visibleItems: 2
            },
            landscape: {
                changePoint: 640,
                visibleItems: 4
            },
            tablet: {
                changePoint: 769,
                visibleItems: 4
            }
        }
    });

    $("#flexiselDemo5").flexisel({
        //alert('flexiselDemo5');
        visibleItems: 1,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 5000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 481,
                visibleItems: 2
            },
            landscape: {
                changePoint: 640,
                visibleItems: 2
            },
            tablet: {
                changePoint: 767,
                visibleItems: 4
            }
        }
    });

    $(".rslides").responsiveSlides({
        //alert('rslides');
        auto: true, // Boolean: Animate automatically, true or false
        speed: 500, // Integer: Speed of the transition, in milliseconds
        timeout: 4000, // Integer: Time between slide transitions, in milliseconds
        pager: false, // Boolean: Show pager, true or false
        nav: false, // Boolean: Show navigation, true or false
        random: false, // Boolean: Randomize the order of the slides, true or false
        pause: false, // Boolean: Pause on hover, true or false
        pauseControls: true, // Boolean: Pause when hovering controls, true or false
        prevText: "Previous", // String: Text for the "previous" button
        nextText: "Next", // String: Text for the "next" button
        maxwidth: "", // Integer: Max-width of the slideshow, in pixels
        navContainer: "", // Selector: Where controls should be appended to, default is after the 'ul'
        manualControls: "", // Selector: Declare custom pager navigation
        namespace: "rslides", // String: Change the default namespace used
        before: function () {
        }, // Function: Before callback
        after: function () {
        } // Function: After callback
    });

    $("#zaccordion").zAccordion({
        tabWidth: "26%",
        width: "100%",
        height: "269px"
    });
    $(window).resize(function () {
        $("#zaccordion").height($(window).height());
        $("#zaccordion li").height($(window).height());
        $("#zaccordion img").height($(window).height());
    });
});



$(document).ready(function () {
    $("#disableme").delegate("li", "click", function () {
        if ($(this).find("a").prop("disabled") == true) {
            // alert("you need to login first");
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            document.getElementsByClassName("trigger")[0].click();
        }
    });

    $(".matrimonialli").delegate(".clickme", "click", function () {
        //debugger;
        var id = $(this).attr("atr");
        var src = $("#" + id).attr("src");
        //alert(src);
        $("#popimg").attr("src", src);
    });


    var filter = $(".panel-body").find("select");









    $("#eventsaccordion").delegate("select", "change", function () {

        var filter_val = $(this).val();
        var field_name = $(this).attr("ftype");
        var url = window.location.href;

        //For Live purpose
        //var x = location.hostname+"/events/eventsfilters";

        //For Testing purpose			
        var x = location.hostname + "/rustagi/events/eventsfilters";

        var querystring = "value=" + filter_val + "&type=" + field_name + "&filtaction=1&pagename=" + url;
        var result = Validate(filter_val, field_name);

        if (result == false) {
            return false;
        }
        else
            call_ajax_post(x, querystring);

    });

    $("#otherInstitution_accordion").delegate("select", "change", function () {

        // alert(1);

        var filter_val = $(this).val();
        var field_name = $(this).attr("ftype");
        var url = window.location.href;

        //For Live purpose
        //var x = location.hostname+"/pages/institutefilters";

        //For Testing purpose
        var x = location.hostname + "/rustagi/pages/institutefilters";


        var querystring = "value=" + filter_val + "&type=" + field_name + "&filtaction=1&pagename=" + url;
        var result = Validate(filter_val, field_name);

        if (result == false) {
            return false;
        }
        else
            call_ajax_post(x, querystring);

    });

    

    $("#dob").change(function () {
        var val = $(this).val();
        var queryString = "value=" + val;

        //For Live purpose
        //var action = "http://"+location.hostname+"/account/covertdateage";

        //For Testing purpose
        var action = "http://" + location.hostname + "/account/covertdateage";

        var callback = covertdateageresults;
        // alert();
        ajax_call_normal(queryString, action, callback)
    });

    $("#country").on('change', function () {
        var countryId = this.value;
        $.ajax({
            //For Live purpose
            //url:"http://"+location.hostname+"/user/getStateName",

            //For Testing purpose
            url: "/user/getStateName",
            type: "POST",
            dataType: "json",
            data: {
                Country_ID: countryId
            },
            beforeSend: function () {
                $('#Loading_Request').show();
            },
            complete: function () {
                $('#Loading_Request').hide();
            },
            success: function (resp) {

                if (resp.Status == 'Success') {
                    $("#state").empty();
                    $("#city").empty();
                    $("#state").append("<option value=''>Select State</option>");
                    $.each(resp.statelist, function (idx, obj) {
                        $("#state").append("<option value='" + obj["id"] + "'>" + obj["state_name"] + "</option>");
                    });
                } else {
                    $("#state").empty();
                    $("#city").empty();
                    alert("No States are available");
                }
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });
    });
    /*******************End******************/
    /*************Get City on Select State*************************************************/
    $("#state").on('change', function () {
        var stateId = this.value;
        $.ajax({
            //For Live purpose
            //url:"http://"+location.hostname+"/user/getCityName",

            //For Testing purpose
            url: "/user/getCityName",
            type: "POST",
            dataType: "json",
            data: {
                State_ID: stateId
            },
            beforeSend: function () {
                $('#Loading_Request').show();
            },
            complete: function () {
                $('#Loading_Request').hide();
            },
            success: function (resp) {
                if (resp.Status == 'Success') {
                    $("#city").empty();
                    $("#city").append("<option value=''>Select City</option>");
                    $.each(resp.statelist, function (idx, obj) {
                        $("#city").append("<option value='" + obj["id"] + "'>" + obj["city_name"] + "</option>");
                    });
                } else {
                    $("#city").empty();
                    alert("No Cities are Available");
                }
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });
    });

    $("#validateformbox").delegate("#signupform", "submit", function () {
        var msg = '<span class="error">Value is requred and cant be empty</span>';
        var form = $(this);
        var formelements = $(this).find(".form-control");
        $(formelements).each(function (index, val) {
            $(".error").html("");
        })


        var errelements = [];


        $(formelements).each(function (index, val) {
            var name = $(this).attr("name");
            var type = $(this).attr("type");
            var val = $(this).val();


            if (val == "") {
                $(this).after(msg);
                errelements.push(name);
                // success = false;
            } else if (name == "full_name" || name == "father_name") {

                if (!/^[a-zA-Z ]+$/.test(val) == true) {

                    // alert(name);
                    $(this).after('<span class="error">Value must be in alphabets only.</span>');
                    // success = '0';
                    errelements.push(name);

                } else {
                    $(this).after("");
                    // success = '1';
                    removeA(errelements, name);

                }

            } else if (type == "text") {
                if (val.length < 6) {
                    $(this).after('<span class="error">Value is too small .</span>');
                    // success = '0';
                    errelements.push(name);


                } else {
                    $(this).after("");
                    // success = '1';
                    removeA(errelements, name);

                }
            } else if (type == "password") {
                if (val.length < 6) {
                    // alert(type);

                    $(this).after('<span class="error">Value is too small . It should be greater than 6 characters </span>');
                    // success = '0';
                    errelements.push(name);


                } else {
                    $(this).after("");
                    // success = '1';
                    removeA(errelements, name);

                }
            } else {
                $(this).after("");
                removeA(errelements, name);
                // errelements.deleteElem(name);
            }
        });

        if (errelements.length == 0) {
            return true;
        }
        else
            return false;
    });

    $("#signupform").delegate("select", "change", function () {
        var name = $(this).attr("name");
        // elt.;
        if (name == "rustagi_branch" || name == "profession" || name == "gothra_gothram") {
            var option = $(this).find("option:selected").text();
            if (option == "Others") {
                // $(this).after("");
                var add = "<div class='others" + name + "'><br><input required placeholder='Please Specify Others' type='text' name='" + name + "_other' class='form-control'></div>";
                // $(".others"+name).html("");
                // $(this).after(add);
                // alert("1");
                $("#" + name + "_other").show();

            } else {

                $("#" + name + "_other").hide();

                // $(".others"+name).html("");
            }
        }
    });


    $("#signupform").delegate("input[type=text]", "keyup", function () {
        var name = $(this).attr("name");
        var val = $(this).val();

        if (name == "full_name" || name == "father_name" || name =="address" || name == "native_place") {
            var updated = titleCase(val);
            $(this).val(updated);
        }

    });



});



function titleCase(str) {
    var splitStr = str.toLowerCase().split(' ');
    for (var i = 0; i < splitStr.length; i++) {
        // You do not need to check if i is larger than splitStr length, as your for does that for you
        // Assign it back to the array
        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
    }
    // Directly return the joined string
    return splitStr.join(' ');
}

function removeA(arr) {
    var what,
            a = arguments,
            L = a.length,
            ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax = arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}


var covertdateageresults = function (data) {
    var resp = data;

    // alert(resp.status);
    if (resp.status == 0) {
        alert(resp.content);
    }
    else
        $("#age").val(resp.content);

}

var zodiacsignresults = function (data) {
    var resp = data;

     alert(resp.status);
    if (resp.status == 0) {
        alert(resp.content);
    }
    else
        $("#zodiac_sign_raasi").val(resp.content);

}

function cmtoftin(x) {
    var val = x % 30.48;
    // alert(val);
    return val;
}

function showform() {
    $("#frontform").fadeOut();
    $("#forgotform").fadeIn();

}

function newsdatevalidate() {
    var date1 = document.getElementById("dob").value;
    var date2 = document.getElementById("dob1").value;

    if (date1 == "" || date2 == "") {
        alert("Please select both dates");
        return false;
    }
    var chkdata = $("input[name='news_category\\[\\]']:checked").map(function () {
        return $(this).val();
    }).get();

    $.ajax({
        //For Live purpose
        //url:"http://"+location.hostname+"/news/newsfilters",

        //For Testing purpose
        url: "http://" + location.hostname + "/news/newsfilters",
        type: "post",
        async: false,
        data: {
            category: chkdata,
            from: date1,
            to: date2
        },
        success: function (data) {
            $("#newsContainer").html(data);
            $('ul#items').easyPaginate({
                step: 4
            });
        }
    });

    return false;
}

var postfiltersresults = function (data) {
    // alert(data);
    $(".filtersresults").html(data);
    $('ul#items').easyPaginate({
        step: 4
    });

}

function datevalidate(action, callback) {
    // debugger;
    // alert(action+callback);
    // return false;
    var date1 = document.getElementById("dob").value;
    var date2 = document.getElementById("dob1").value;
    var chkdata = $("input[name='category\\[\\]']:checked").map(function () {
        return $(this).val();
    }).get();
    var queryString = "from=" + date1 + "&to=" + date2 + "&category=" + chkdata;

    if (date1 == "" || date2 == "") {
        alert("Please select both dates");
        return false;
    }
    ajax_call_simple(queryString, action, callback);


    return false;
}

function eventsdatevalidate(action) {
    // debugger;

    var date1 = document.getElementById("dobeventfrom").value;
    var date2 = document.getElementById("dobeventto").value;
    var url = window.location.href;

    //For Live purpose
    //var x = location.hostname+"/events/eventsfilters";

    //For Testing purpose
    var x = location.hostname + "/rustagi/events/eventsfilters";

    var querystring = "from=" + date1 + "&to=" + date2 + "&pagename=" + url;

    if (date1 == "" || date2 == "") {
        alert("Please select both dates");
        return false;
    }
    // alert(url);
    call_ajax_post(x, querystring);

    return false;
}

function call_ajax_post(action, querystring) {

    // debugger;
    // alert(action);



    $.ajax({
        url: "http://" + action,
        type: "post",
        async: false,
        data: querystring,
        success: function (data) {
            $("#event_container,#myModal").html(data);
            $('ul#items').easyPaginate({
                step: 8
            });
            var CSCdata = $("#CSCresults").html();
            var atr = $("#CSCresults").attr("ftyle");
            var taratr = $("#otherInstitution_accordion").find("select[ftype=" + atr + "]");

            taratr.html(CSCdata);
            taratr.parents(".newulclass").next().find("select").html("<option>---Select---city---</option>");


            $(".itarget").click(function () {
                var id = $(this).attr("tar");
                $("#" + id).fadeToggle("slow").siblings(".dontshow").fadeOut("fast");
            });
        }
    });

}


function fetchcontacts() {

    var chkdata = $("select[name='contact_filter\\[\\]']").map(function () {
        return $(this).attr("ftype") + "=" + $(this).val();
    }).get();

    //For Live purpose
    //var url = location.hostname+"/pages/contactfilters";

    //For Testing purpose
    var url = location.hostname + "/rustagi/pages/contactfilters";

    var querystring = "querystringarray=" + chkdata;
    call_ajax_post(url, querystring);

    return false;
}

var chkduplicateresults = function (data) {
    $("#" + data.id).next("span").html(data.message);
    if (data.id == "email") {
        $("#emailerror").html(data.message);
    }
}

function ajax_call_normal(queryString, action, callback) {

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
        success: callback
    })

}

function ajax_call_simple(queryString, action, callback) {

    $.ajax({
        url: action,
        type: "post",
        data: queryString,
        beforeSend: function () {
            $('#Loading_Request').show();
        },
        complete: function () {
            $('#Loading_Request').hide();
        },
        success: callback
    })

}

function chkduplicate(val, id, action, callback) {
    var queryString = 'id=' + id + '&value=' + val;

    // debugger;
    if (id == "email") {
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(val) == true) {
            $("#emailerror").html("");
            ajax_call_normal(queryString, action, callback);
        } else {
            $("#emailerror").html("<p style='color:red;'>not a valid email</p>");
        }
    }
    if (id == "mobile_no") {
        if (/[0-9]/.test(val) == true && val.length == 10) {
            $("#" + id).next("span").html("");
            ajax_call_normal(queryString, action, callback);
        } else {
            $("#" + id).next("span").html("<p style='color:red;'>not a valid number</p>");
        }
    }


    if (id == "username") {
        if (val.length > 6) {
            $("#" + id).next("span").html("");
            ajax_call_normal(queryString, action, callback);
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
             ajax_call_normal(queryString, action, callback);
        }
        // alert(val);

    }
}

function SubmitPost(id) {
    if ($("#" + id).find("input[name=image]").val() == "") {
        // alert(.val());

        $("#" + id).find("input[name=image]").next("span").html("This is required and cant be empty");
    }
    else
        $("#" + id).find("input[name=image]").next("span").html();


    $("#" + id + " .form-control").each(function (index, val) {

        var formelement = $(this).attr("name");

        $(this).next("span").html("");
        // alert(formelement);
    });

    $("#" + id + " .form-control").each(function (index, val) {

        var formelement = $(this).attr("name");
        if ($(this).val() == "") {

            $(this).next("span").html("This is required and cant be empty");
            valid = false;
        }
        else
            valid = true;
    });

    return valid;

}

function validatecomment(id) {
    // alert(id);
    return true;
}


function ScrollToLogin() {
    // alert(id);
    // $("#loginbox").show();
    // $("#loginbox").removeClass("hide");
}

var forgotresponse = function (data) {
    var response = data;

    // alert(response.resp);
    if (response.resp == 1) {
        var otp = $("#otpform");
        $("#forgotform").fadeOut();
        otp.fadeIn();
        otp.find("input[name=time]").val(response.success.time);
        otp.find("input[name=code]").val(response.success.code);
        otp.find("input[name=number]").val(response.success.mobile);
    } else {
        alert(response.error);
    }
}

function validatenum(id, action, callback) {

    var input = $("#" + id).find("input[type=number]");

    if (input.val().length == 10) {
        var num = input.val();
        input.next("span").html("");
        var queryString = "number=" + num;

        ajax_call_normal(queryString, action, callback);
        // $.ajax({
        // 	url:action,
        // 	type:"post",
        // 	data:queryString,
        // 	dataType:"JSON",
        // 	success:function(data){
        // 		var parsed = JSON.parse(data);
        // 		if(parsed.resp==1){
        // 			var otp = $("#otpform");
        // 			$("#mobileform").fadeOut();
        // 			otp.fadeIn();
        // 			otp.find("input[name=time]").val(parsed.success.time);
        // 			otp.find("input[name=code]").val(parsed.success.code);
        // 			otp.find("input[name=number]").val(parsed.success.mobile);
        // 		}
        // 		else {
        // 				alert(parsed.error);
        // 		}
        // 	}
        // });
    } else {
        input.next("span").html("<p style='color:red;'>not a valid number</p>");
    }

    return false;

}

var confirmotpresults = function (data) {
    var parsed = data;

    if (parsed.resp == 1) {
        if (parsed.success.is_reg == 1) {
            document.getElementById('otpformss').style.display = "none";
            //document.getElementById('regthanks').style.display = "block";
            document.getElementById('changepswd').style.display = "block";
            //$("#otpform").hide();
            //$("#regthanks").show();
            alert(parsed.success.msg);
//            $("html, body").animate({
//                scrollTop: 0
//            }, 600);
            //document.getElementsByClassName("trigger")[0].click();
        } else {
            // 		var otp = $("#otpform");
            // 		var chgpass = $("#chgpass");
            // 		// $("#mobileform").fadeOut();
            // 		otp.fadeOut();
            // 		chgpass.fadeIn();
            // 		chgpass.find("input[name=userid]").val(parsed.success.userid);
            // 			// alert();
        }
    } else {
        alert(parsed.error);
    }
}


var changepswdresults = function (data) {
    var parsed = data;

    if (parsed.resp == 1) {
        if (parsed.success.is_reg == 1) {
            document.getElementById('changepswd').style.display = "none";
            document.getElementById('regthanks').style.display = "block";
            alert(parsed.success.msg);
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            document.getElementsByClassName("trigger")[0].click();
        } else {
            // 		var otp = $("#otpform");
            // 		var chgpass = $("#chgpass");
            // 		// $("#mobileform").fadeOut();
            // 		otp.fadeOut();
            // 		chgpass.fadeIn();
            // 		chgpass.find("input[name=userid]").val(parsed.success.userid);
            // 			// alert();
        }
    } else {
        alert(parsed.error);
    }
}

var chgpassresults = function (data) {

    var parsed = data;

    if (parsed.resp == 1) {
        alert(parsed.success);
        location.reload();
    } else {
        alert(parsed.error);
    }

}

function confirmotp(id, action, callback, is_reg) {

    var queryString = $("#" + id).serialize() + "&is_reg=" + is_reg;

    // alert(queryString);
    ajax_call_normal(queryString, action, callback);
    // alert
    return false;
}


function changepswd(id, action, callback) {
    
//    var old_password=$("old_password").val();
//    var new_password=$("new_password").val();
//    if(old_password==""){
//        alert('Please enter Old password');
//        return true;
//    }else if(new_password==""){
//        alert('Please enter New password');
//        return true;
//    }

    var queryString = $("#" + id).serialize();

    // alert(queryString);
    ajax_call_normal(queryString, action, callback);
    // alert
    return false;
}

var cropimageresults = function (data) {
    //console.log(data);
    //exit;
    //alert(data.Status);
    if (data.Status == 1) {
        //alert(data.data);
        $("#" + data.imgid).attr("src", data.data);
        $("input[name=" + data.imgid + "]").val(data.data);
        // alert(data.imgid);
    } else {

        alert(data.message);
    }
    //location.reload();
    window.location = window.location;
//  console.log(data)	;
}




function cropimage(action, callback) {
    // var file = $("input[name=avatar_file]").files[0];
    // var formdata = $("#cropform").serialize();
    var filedata = false;

    filedata = new FormData($("#cropform")[0]);



    $.ajax({
        beforeSend: function () {
            $("#showloader1").fadeIn();
        },
        complete: function () {
            $("#showloader1").fadeOut();

        },
        type: 'POST',
        url: action,
        // cache       : false,
        dataType: "JSON",
        data: filedata,
        contentType: false,
        processData: false,
        success: callback,
    });

    return false;

}

function cropimagebrotherdetail(action) {
    var x = location.hostname + "/my-rustagi/"+action;
    //alert(x);
      // var file = $("input[name=avatar_file]").files[0];
    // var formdata = $("#cropform").serialize();
    var filedata = false;

    filedata = new FormData($("#cropform")[0]);
    



    $.ajax({
        beforeSend: function () {
            $("#showloader1").fadeIn();
        },
        complete: function () {
            $("#showloader1").fadeOut();

        },
        type: 'POST',
        url: action,
        // cache       : false,
        dataType: "JSON",
        data: filedata,
        contentType: false,
        processData: false,
        success: function(data){
            //console.log(data);
           $("#brother_image_name_id_"+data.image_index).val(data.image_name);
           $("#brother_image_"+data.image_index).attr("src", "/temp/thumb/100x100/"+data.image_name);
           $("#avatar-modal1").removeClass("in")
           $("#avatar-modal1").attr("aria-hidden", "true");
           $("#avatar-modal1").css("display", "none");
           $("div").removeClass("modal-backdrop fade in");
           $("body").removeClass("modal-open");
//           console.log(data);
//           $('#brother_image').each(function(){
//                 console.log($(this).val());
//            });
           
//           var brotherImage = document.getElementsByName("brother_image[]");
//           brotherImage[2].attr("src", 'satya');
//           
            //$("input[name=brother_image_name[2]]").val('satya');
             //console.log(data);
            //alert('satya');
            //return false;
//            if (data.Status == 1) {
//                //alert(data.data);
//                $("#" + data.imgid).attr("src", data.data);
//                $("input[name=" + data.imgid + "]").val(data.data);
//                // alert(data.imgid);
//            } else {
//                alert(data.message);
//            }
            //location.reload();
            //window.location = window.location;
        }
    });

    return false;

}


function showcropbox(uid, ref_no, field, table) {



    //console.log(uid);
    //alert(field);

    if (field != "profile_photo") {
        $("#forprofile").hide();
    }

    $("#uid").val(uid);
    $("#ref_no").val(ref_no);
    $("#profile_photo").val(field);
    $("#profile_photo_flag").val(field);
    $("#field_name").val(field);
    $("#table_name").val(table);
    $("#field_name1").val(field);
    $("#table_name1").val(table);
}

function showcropboxbrotherdetail(uid, ref_no, field, table, imageIndex, selVal) {
        if(uid.length===0){
        $("#cropform").attr("onsubmit", "return cropimagebrotherdetail('cropimagebrotherdetail');");
         }

//           var cropForm = document.getElementByName("cropform");
//           var att = document.createAttribute("onsubmit");     
//               att.value = "showcropboxfamilydetail('dffff')";                           
//               cropForm.setAttributeNode(att); 
    //console.log(uid);
    //alert('satya');

    if (field != "profile_photo") {
        $("#forprofile").hide();
    }
    
   
    $("#uid").val(uid);
    $("#ref_no").val(ref_no);
    $("#profile_photo").val(field);
    $("#profile_photo_flag").val(field);
    $("#field_name").val(field);
    $("#table_name").val(table);
    $("#field_name1").val(field);
    $("#table_name1").val(table);
    $("#image_index").val(imageIndex);
    $("#sel_value").val(selVal);
}

function showcropboxpost(uid, ref_no, field, table) {



    //console.log(uid);
    alert(field);

    if (field != "profile_photo") {
        $("#forprofile").hide();
    }

    $("#uid").val(uid);
    $("#ref_no").val(ref_no);
    $("#profile_photo").val(field);
    $("#profile_photo_flag").val(field);
    $("#field_name").val(field);
    $("#table_name").val(table);
    $("#field_name1").val(field);
    $("#table_name1").val(table);
}

var sortmembersresults = function (data) {
    $(".showerrorbox").fadeOut();
    $("#profilepage").hide();
    $("#profile1").hide();
    $("#profile").show();
    $("#profile").html(data);
    $('ul#items').easyPaginate({
        step: 32
    });
}


function sortmembers(param, Stype, action, callback) {
    var li = $(param).parent();
    var querystring = "Type=" + Stype;
    // alert(Stype+action+callback);
    li.addClass("active").siblings("li").removeClass("active");
    ajax_call_simple(querystring, action, callback);
}


function disabletabs(x) {

    $("#disableme").find("a").prop("disabled", true);

}


var showallimagesresults = function (data) {
    // alert(data.Status);
    // if(data.Status==1){
    // 	// alert(data.data);
    // 	$("#"+data.imgid).attr("src",data.data);
    // 	// alert(data.imgid);
    // }
    // else alert(data.message);
    // console.log(data)	;
    $("#showallimages").fadeIn();
    $("#showallimages").html(data);
}

function showallimages(type, action, callback) {
    var queryString = "type=" + type;
    // alert(type+action+callback);

    ajax_call_simple(queryString, action, callback);
}
function showchck(ths) {

    $(ths).next().show();
}

function hidechck(ths) {

    // $(ths).next().hide();
}

function selectchk(ths) {

    var ischk = $(ths).next().find("input[type=checkbox]").prop("checked");

    if (ischk == true) {
        $(ths).next().find("input[type=checkbox]").prop("checked", false);
    }
    else
        $(ths).next().find("input[type=checkbox]").prop("checked", true);
}

var delselectedresults = function (data) {
    alert(data);
    location.reload();

}

function delselected(id, action, callback) {
    var chkdata = $("input[name='delimages\\[\\]']:checked").map(function () {
        return $(this).val();
    }).get();
    var type = $("#showallimages").find("input[name=type]").val();
    var uid = $("#showallimages").find("input[name=uid]").val();
    var path = $("#showallimages").find("input[name=path]").val();
    var queryString = "idfield=" + chkdata + "&Itype=" + type + "&user_id=" + uid + "&path=" + path;
    ajax_call_simple(queryString, action, callback);
}


//// Mohit Jain

function croppostimage(action, callback) {
    // var file = $("input[name=avatar_file]").files[0];
    // var formdata = $("#cropform").serialize();
    var filedata = false;

    filedata = new FormData($("#cropform_post")[0]);



    $.ajax({
        beforeSend: function () {
            $("#showloader_post").fadeIn();
        },
        complete: function () {
            $("#showloader_post").fadeOut();

        },
        type: 'POST',
        url: action,
        // cache       : false,
        dataType: "JSON",
        data: filedata,
        contentType: false,
        processData: false,
        success: callback,
    });

    return false;

}


var croppostimageresults = function (data) {
    //alert(data.Status);
    if (data.Status == 1) {
        var val = data.data;
        var post_img = val.split("/");
        $("#post_photo").attr("src", data.data);
        $("#image").val(post_img[2]);
        $("#post_image_flag").val('1');
        $("#avatar-modalpost_image").removeClass("in")
        $("#avatar-modalpost_image").attr("aria-hidden", "true");
        $("#avatar-modalpost_image").css("display", "none");
        $("div").removeClass("modal-backdrop fade in");
        $("body").removeClass("modal-open");
    } else {

        alert(data.message);
    }
    //location.reload();
//  console.log(data)	;
}



