
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
        visibleItems: 6,
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
        visibleItems: 6,
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
        }     // Function: After callback
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


    $("#accordion").delegate("input,select", "change keyup", function () {
        var filter_val = $(this).val();
        var field_name = $(this).attr("ftype");

        // alert(filter_val);


        if (field_name == "office_email") {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(filter_val) == false) {

                var error = "<p id='filtererrors'>Not valid email</p>";
                showerror(error);
                return false;
            }
        }
        if (filter_val == "---Select---country---") {
            var error = "<p id='filtererrors'>Please select country</p>";
            // alert();
            $("select[ftype=state]").empty();
            $("select[ftype=city]").empty();
            $("select[ftype=state]").html("<option>---Select---state---</option>");
            $("select[ftype=city]").html("<option>---Select---city---</option>");
            showerror(error);
            return false;
        }
        if (filter_val == "---Select---state---") {
            var error = "<p id='filtererrors'>Please select state</p>";
            // alert();
            $("select[ftype=city]").empty();
            $("select[ftype=city]").html("<option>---Select---city---</option>");

            showerror(error);
            return false;
        }
        if (filter_val == "---Select---city---") {
            var error = "<p id='filtererrors'>Please select city</p>";
            // alert();
            showerror(error);
            return false;
        }
        if (field_name == "zip_pin_code") {
            if (/[0-9]/.test(filter_val) == true) {

                if (filter_val.length > 6) {
                    var error = "<p id='filtererrors'>Pincode length must be of 6 digits only</p>";
                    // alert(filter_val.length);	
                    showerror(error);
                    return false;
                }
            }
            else {
                var error = "<p id='filtererrors'>Pincode should be numeric</p>";

                showerror(error);
                return false;
            }
        }

        if (field_name == "full_name") {
            if (/[a-zA-Z]/.test(filter_val) == false) {

                var error = "<p id='filtererrors'>Name must be in alphabets</p>";
                showerror(error);
                return false;
            }
        }
        if (filter_val == "---Select---Profession---") {
            var error = "<p id='filtererrors'>Please select Profession</p>";
            // alert();
            showerror(error);
            return false;
        }
        if (filter_val == "---Select---Education---") {
            var error = "<p id='filtererrors'>Please select Education</p>";
            // alert();
            showerror(error);
            return false;
        }
        if (filter_val == "---Select---Designation---") {
            var error = "<p id='filtererrors'>Please select Designation</p>";
            // alert();
            showerror(error);
            return false;
        }
        if (filter_val == "---Marital---Status---") {
            var error = "<p id='filtererrors'>Please select Marital Status</p>";
            // alert();
            showerror(error);
            return false;
        }
        //debugger;
        $.ajax({
            // beforeSend : function(){
            // 	$(".filters_loader_box").show();
            // } ,

            //For Live purpose
            //url : "http://"+location.hostname+"/membership/filters",

            //For Testing purpose
            url: "http://" + location.hostname + "/rustagi/membership/filters",
            type: "POST",
            async: false,
            data: {value: filter_val, type: field_name},
            success: function (data) {
                $(".showerrorbox").fadeOut();
                $("#profilepage").hide();
                $("#listgrid").show();
                $("#profile").html(data);
                $('ul#items').easyPaginate({
                    step: 16
                });
                var CSCdata = $("#CSCresults").html();
                var atr = $("#CSCresults").attr("ftyle");
                var taratr = $("#accordion").find("select[ftype=" + atr + "]");

                taratr.html(CSCdata);
            },
            // complete : function(){
            // 	$(".filters_loader_box").hide();
            // }
        });



    });


    function showerror(error)
    {
        $(".showerrorbox").fadeIn();
        $(".showerrorbox").html(error);

    }

    $(".slider").each(function () {
        // $this is a reference to .slider in current iteration of each
        var $this = $(this);

        var field_name = $this.find(".slider-range").attr("ftype");

        if (field_name == "age")
        {
            // alert(field_name);
            var id = "age-amount";
            var amin = 1;
            var amax = 100;
            var set1 = 22;
            var set2 = 50;
        }
        else if (field_name == "height")
        {
            // alert(field_name);
            var id = "height-amount";
            var amin = 92;
            var amax = 214;
            var set1 = 130;
            var set2 = 190;
        }
        else {
            // alert(field_name);

            var id = "income-amount";
            var amin = 120000;
            var amax = 10000000;
            var set1 = 300000;
            var set2 = 1200000;
        }
        // console.log(whichIsVisible());



        var url = window.location.href;
        var urlsplit = url.split("?");
        if (urlsplit[0].match(/membership/g) == "membership")
            //For Live purpose
            //var ajaxurl = "http://"+location.hostname+"/membership/filters";

            //For Testing purpose
            var ajaxurl = "http://" + location.hostname + "/rustagi/membership/filters";

        else 
            //For Live purpose
            //var ajaxurl = "http://"+location.hostname+"/matrimonial/matrimonyfilters";

            //For Testing purpose
            var ajaxurl = "http://" + location.hostname + "/rustagi/matrimonial/matrimonyfilters";



        // find any .slider-range element WITHIN scope of $this
        $(".slider-range", $this).slider({
            range: true,
            min: amin,
            max: amax,
            values: [set1, set2],
            slide: function (event, ui) {
                // find any element with class .amount WITHIN scope of $this
                $(this).parent().find(".amount").html(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            },
            change: function (event, ui) {
                var filter_val = ui.values[ 0 ] + "-" + ui.values[ 1 ];
                var chkdata = $("input[name='matrimony_gender\\[\\]']:checked").map(function () {
                    return $(this).val();
                }).get();

                if (chkdata.length < 1) {
                    chkdata = 1;
                }

                // alert(ajaxurl);
                // var field_name = $(this).attr("ftype");

                // var array = filter_val.split("-");

                $.ajax({
                    // beforeSend : function(){
                    // 	$(".filters_loader_box").show();
                    // } ,
                    url: ajaxurl,
                    type: "POST",
                    async: false,
                    data: {gender_type: chkdata, value: filter_val, type: field_name, range_filter: 1},
                    success: function (data) {
                        // alert(1);
                        $(".showerrorbox").fadeOut();
                        $("#profilepage").hide();
                        $("#profile1").hide();
                        $("#profile").show();
                        $("#profile").html(data);
                        $('ul#items').easyPaginate({
                            step: 4
                        });
                        // $("#profile").html(data);
                    },
                    // complete : function(){
                    // 	$(".filters_loader_box").hide();
                    // }
                });
            }
        });
        $("#" + id).html(set1 + " - " + set2);
    });

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

    var maturl = window.location.href;
    var maturlsplit = maturl.split("?");
    if (!maturlsplit[0].match(/list-view/g) == true)
    {
        $("#Female").prop("checked", true);
        $("#Male").prop("checked", true);
    }
    else {
        $("#Female").removeAttr("id");
        $("#Male").removeAttr("id");
    }

    $("#dob").change(function () {
        var val = $(this).val();
        var queryString = "value=" + val;

        //For Live purpose
        //var action = "http://"+location.hostname+"/account/covertdateage";

        //For Testing purpose
        var action = "http://" + location.hostname + "/rustagi/account/covertdateage";

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
            url: "http://" + location.hostname + "/rustagi/user/getStateName",
            type: "POST",
            dataType: "json",
            data: {Country_ID: countryId},
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
            url: "http://" + location.hostname + "/rustagi/user/getCityName",
            type: "POST",
            dataType: "json",
            data: {State_ID: stateId},
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
            }
            else if (name == "full_name" || name == "father_name") {

                if (!/^[a-zA-Z ]+$/.test(val) == true) {

                    // alert(name);
                    $(this).after('<span class="error">Value must be in alphabets only.</span>');
                    // success = '0';
                    errelements.push(name);

                }
                else {
                    $(this).after("");
                    // success = '1';
                    removeA(errelements, name);

                }

            }
            else if (type == "text") {
                if (val.length < 6) {
                    $(this).after('<span class="error">Value is too small .</span>');
                    // success = '0';
                    errelements.push(name);


                }
                else {
                    $(this).after("");
                    // success = '1';
                    removeA(errelements, name);

                }
            }
            else if (type == "password") {
                if (val.length < 6) {
                    // alert(type);

                    $(this).after('<span class="error">Value is too small . It should be greater than 6 characters </span>');
                    // success = '0';
                    errelements.push(name);


                }
                else {
                    $(this).after("");
                    // success = '1';
                    removeA(errelements, name);

                }
            }
            else {
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

            }
            else {

                $("#" + name + "_other").hide();

                // $(".others"+name).html("");
            }
        }
    });


    $("#signupform").delegate("input[type=text]", "keyup", function () {
        var name = $(this).attr("name");
        var val = $(this).val();

        if (name == "full_name" || name == "father_name") {
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
    var what, a = arguments, L = a.length, ax;
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

    if (date1 == "" || date2 == "")
    {
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
        url: "http://" + location.hostname + "/rustagi/news/newsfilters",
        type: "post",
        async: false,
        data: {category: chkdata, from: date1, to: date2},
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

    if (date1 == "" || date2 == "")
    {
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

    if (date1 == "" || date2 == "")
    {
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
}

function ajax_call_normal(queryString, action, callback) {

    $.ajax({
        url: action,
        type: "post",
        dataType: "JSON",
        data: queryString,
        success: callback
    })

}

function ajax_call_simple(queryString, action, callback) {

    $.ajax({
        url: action,
        type: "post",
        data: queryString,
        success: callback
    })

}

function chkduplicate(val, id, action, callback) {
    var queryString = 'id=' + id + '&value=' + val;

// debugger;
    if (id == "email") {
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(val) == true) {
            $("#" + id).next("span").html("");
            ajax_call_normal(queryString, action, callback);
        }
        else {
            $("#" + id).next("span").html("<p style='color:red;'>not a valid email</p>");
        }
    }
    if (id == "mobile_no") {
        if (/[0-9]/.test(val) == true && val.length == 10) {
            $("#" + id).next("span").html("");
            ajax_call_normal(queryString, action, callback);
        }
        else {
            $("#" + id).next("span").html("<p style='color:red;'>not a valid number</p>");
        }
    }
    if (id == "username") {
        if (val.length > 6) {
            $("#" + id).next("span").html("");
            ajax_call_normal(queryString, action, callback);
        }
        else {
            $("#" + id).next("span").html("<p style='color:red;'>username is too small </p>");
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
    }
    else {
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
    }
    else {
        input.next("span").html("<p style='color:red;'>not a valid number</p>");
    }

    return false;

}

var confirmotpresults = function (data) {
    var parsed = data;

    if (parsed.resp == 1) {
        if (parsed.success.is_reg == 1) {
            alert(parsed.success.msg);
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            document.getElementsByClassName("trigger")[0].click();
        }
        else {
            // 		var otp = $("#otpform");
            // 		var chgpass = $("#chgpass");
            // 		// $("#mobileform").fadeOut();
            // 		otp.fadeOut();
            // 		chgpass.fadeIn();
            // 		chgpass.find("input[name=userid]").val(parsed.success.userid);
            // 			// alert();
        }
    }
    else {
        alert(parsed.error);
    }
}

var chgpassresults = function (data) {

    var parsed = data;

    if (parsed.resp == 1) {
        alert(parsed.success);
        location.reload();
    }
    else {
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

var cropimageresults = function (data) {
    // alert(data.Status);
    if (data.Status == 1) {
        // alert(data.data);
        $("#" + data.imgid).attr("src", data.data);
        $("input[name=" + data.imgid + "]").val(data.data);
        // alert(data.imgid);
    }
    else
        alert(data.message);

    location.reload();
    // console.log(data)	;
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



function showcropbox(field, table) {

    if (field != "profile_photo") {
        $("#forprofile").hide();
    }

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
        step: 16
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

    if (ischk == true)
    {
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
    var queryString = "idfield=" + chkdata + "&Itype=" + type + "&user_id=" + uid;
    ajax_call_simple(queryString, action, callback);
}

//for matrimony filter working start here


function filter()
{

    if (document.getElementById('Female').checked == true)
    {
        var female = document.getElementById('Female').value;


    }

    if (document.getElementById('Male').checked == true)
    {
        var male = document.getElementById('Male').value;


    }

    if (document.getElementById('filter_country').value != '---Select---country---')
    {
        var country = document.getElementById('filter_country').value;

    }

    if (document.getElementById('filter_state').value != '---Select---state---')
    {
        var state = document.getElementById('filter_state').value;

    }

    if (document.getElementById('filter_city').value != '---Select---city---')
    {

        var city = document.getElementById('filter_city').value;

    }


    if (document.getElementById('zip_pin_code').value != '')
    {

        var zip_pin_code = document.getElementById('zip_pin_code').value;

    }

    if (document.getElementById('phone_no').value != '')
    {

        var phone_no = document.getElementById('phone_no').value;

    }

    if (document.getElementById('full_name').value != '')
    {

        var full_name = document.getElementById('full_name').value;

    }

    if (document.getElementById('office_email').value != '')
    {

        var office_email = document.getElementById('office_email').value;

    }

    if (document.getElementById('ref_no').value != '')
    {

        var ref_no = document.getElementById('ref_no').value;

    }

    /* if ((minage>=1) && (maxage<=100))
     {
     //query = query + "Age selected -->";
     //var age = document.getElementById('age-amount').value; 
     alert(minage);   
     query = query+" AND "+"tui.age BETWEEN "+minage+" AND "+maxage;
     //alert(query);
     }
     
     if ((minsalary>=120000) && (maxsalary<=10000000)) 
     {
     //query = query + "Income amount  selected -->";
     //var annual_income = document.getElementById('income-amount').value;    
     query = query+" AND "+"tui.annual_income BETWEEN "+minsalary+" AND "+maxsalary;
     }*/

    if (document.getElementById('filter_height').value != '---Select---Height---')
    {

        var height = document.getElementById('filter_height').value;

    }

    if (document.getElementById('filter_profession').value != '---Select---Profession---')
    {

        var profession = document.getElementById('filter_profession').value;

    }

    if (document.getElementById('filter_education').value != '---Select---Education---')
    {

        var education_field = document.getElementById('filter_education').value;

    }

    if (document.getElementById('filter_designation').value != '---Select---Designation---')
    {

        var designation = document.getElementById('filter_designation').value;

    }

    if (document.getElementById('filter_mstatus').value != '---Marital---Status---')
    {

        var marital_status = document.getElementById('filter_mstatus').value;

    }

    if (document.getElementById('filter_dossam').value != '---Manglik---Dosh---')
    {

        var manglik_dossam = document.getElementById('filter_dossam').value;

    }


    var url = "http://" + location.hostname + '/rustagi/matrimonial/matrimonyfilters';

    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: {
            Female: female,
            Male: male,
            Country_name: country,
            State_name: state,
            City_name: city,
            Zip_pin_code: zip_pin_code,
            Phone_no: phone_no,
            Full_name: full_name,
            Office_email: office_email,
            Ref_no: ref_no,
            Height: height,
            Profession: profession,
            Education_field: education_field,
            Designation: designation,
            Marital_status: marital_status,
            Manglik_dossam: manglik_dossam},
        Success: function (result) {
            console.log(result);
        },
        error: function () {
            //console.log(); 
        }
    });


}
//for matrimony filter working end here