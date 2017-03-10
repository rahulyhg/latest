$(document).ready(function () {
    $("#matrimony_accordion").on("change keyup", "input,select", function () {
        var filter_val = $(this).val();
        var field_name = $(this).attr("ftype");
        //alert(field_name); 
        //zip code
        if (field_name == "zip_pin_code") {
            if (field_name == "zip_pin_code" && filter_val.length > 0) {
                // debugger;
                if (/[0-9]/.test(filter_val) == true) {
                    if (filter_val.length < 6) {
                        var error = "<p id='filtererrors'>Pincode length must be of 6 digits only</p>";
                        // alert(filter_val.length);	
                        showerror(error);
                        return false;
                    }
                    if (filter_val.length > 6) {
                        var error = "<p id='filtererrors'>Pincode length is more than 6 it must be of 6 digits only</p>";
                        // alert(filter_val.length);	
                        showerror(error);
                        return false;
                    }
                    if (filter_val.length == 6) {
                        hideerror();
                        filterData();
                        return false;
                    }

                }
                if (/[0-9]/.test(filter_val) == false) {
                    //console.log(filter_val.length);
                    var error = "<p id='filtererrors'>Pincode should be numeric</p>";

                    showerror(error);
                    return false;
                }
            }
            if (field_name == "zip_pin_code" && filter_val.length == 0) {
                hideerror();
                filterData();
                return false;
            }
        }

        // email
        if (field_name == "office_email") {
            if (filter_val.length == 0) {
                hideerror();
                filterData();
            }
            if (filter_val.length > 0) {
                if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(filter_val) == false) {
                    var error = "<p id='filtererrors'>Not valid email</p>";
                    showerror(error);
                    return false;
                } else {
                    hideerror();
                    filterData();
                }
            }
        }

        // full name
        if (field_name == "full_name") {
            if (field_name == "full_name" && filter_val.length > 0) {

                if (/[a-zA-Z]/.test(filter_val) == true && filter_val.length > 2) {
                    hideerror();
                    filterData();
                }
                if (/[a-zA-Z]/.test(filter_val) == false) {
                    var error = "<p id='filtererrors'>Name must be in alphabets</p>";
                    showerror(error);
                    return false;
                }
                if (filter_val.length < 2) {
                    var error = "<p id='filtererrors'>Name must be minimum 3 character</p>";
                    showerror(error);
                    return false;
                }
            }
            if (field_name == "full_name" && filter_val.length == 0) {
                hideerror();
                filterData();
            }
        }


        // ref_no
        if (field_name == "ref_no") {

            if (field_name == "ref_no" && filter_val.length > 0) {

                if (filter_val.length < 4) {
                    var error = "<p id='filtererrors'>Reference Number must be minimum 3 character</p>";
                    // alert(filter_val.length);	
                    showerror(error);
                    return false;
                }

                if (filter_val.length == 4 || filter_val.length > 4) {
                    hideerror();
                    filterData();
                    return false;
                }
            }
            if (field_name == "ref_no" && filter_val.length == 0) {
                hideerror();
                filterData();
                return false;
            }
        }

        // phone number
        if (field_name == "phone_no") {
            if (field_name == "phone_no" && filter_val.length > 0) {
                if (filter_val.length < 10) {
                    var error = "<p id='filtererrors'>Phone Number must be of 10 character only</p>";
                    // alert(filter_val.length);	
                    showerror(error);
                    return false;
                }
                if (filter_val.length > 10) {
                    var error = "<p id='filtererrors'>Phone Number Number must be of 10 character only</p>";
                    // alert(filter_val.length);	
                    showerror(error);
                    return false;
                }
                if (filter_val.length == 10) {
                    hideerror();
                    filterData();
                    return false;
                }
            }
            if (field_name == "phone_no" && filter_val.length == 0) {
                hideerror();
                filterData();
                return false;
            }
        }
    });

});

//slider for age 

$(function () {
    
    $("#slider_age_matrimony").slider({
        range: true,
        min: 22,
        max: 65,
        values: [22, 42],
        slide: function (event, ui) {

            $("#age-amount_matrimony").html(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            $("#amount_age1_matrimony").val(ui.values[ 0 ]);
            $("#amount_age2_matrimony").val(ui.values[ 1 ]);
            
            
            
        },
        change: function (event, ui) {
            var i=$("#matrimony_age_change").val();
                i++;
                $("#matrimony_age_change").val(i);
           

             if($("#matrimony_age_change").val()>2){
                 hideerror();
                 filterData();
             }
                 

        }
    });
    var valueA = $("#slider_age_matrimony").slider("values", 0);
    var valueB = $("#slider_age_matrimony").slider("values", 1);
    $("#age-amount_matrimony").html(valueA + "-" + valueB);
   

});



//annual income slider
$(function () {
    $("#slider_annual_income_matrimony").slider({
        range: true,
        min: 0,
        max: 10000000,
        values: [0, 1800000],
        slide: function (event, ui) {

            $("#income-amount_matrimony").html(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            $("#amount_annual_income1_matrimony").val(ui.values[ 0 ]);
            $("#amount_annual_income2_matrimony").val(ui.values[ 1 ]);
        },
        change: function (event, ui) {
            var i=$("#matrimony_amount_change").val();
                i++;
                $("#matrimony_amount_change").val(i);
           

             if($("#matrimony_amount_change").val()>2){
                 hideerror();
                 filterData();
             }
        }
    });
    var valueA = $("#slider_annual_income_matrimony").slider("values", 0);
    var valueB = $("#slider_annual_income_matrimony").slider("values", 1);
    $("#income-amount_matrimony").html(valueA + "-" + valueB);

});

// fiter data
function filterDataCommunity() {

  
    if (document.getElementById('filter_country').value != 0) {
        var country = document.getElementById('filter_country').value;
    }
    if (document.getElementById('filter_state').value != 0) {
        var state = document.getElementById('filter_state').value;
    }
    if (document.getElementById('filter_city').value != 0) {
        var city = document.getElementById('filter_city').value;
    }
    if (document.getElementById('rustagi_branch').value != 0) {
        var branch = document.getElementById('rustagi_branch').value;
    }
    if (document.getElementById('post_filter').value != 0) {
        var post = document.getElementById('post_filter').value;
    }
  

    var data = {
       
        Country_name: country,
        State_name: state,
        City_name: city,
        Branch_name: branch,
        Post_name: post
        
      
    }

    $.each(data, function (key, value) {
        if (value === "" || value === null || typeof data[key] === "undefined") {
            delete data[key];
        }
    });
    console.log(data);
    //exit;

    var url = '/community/communityfilters';
    $.ajax({
        type: 'POST',
        url: url,
        dataType: "html",
        data: data,
        success: function (result) {
            $(".showerrorbox").fadeOut();
	    $("#profilepage").hide();
	    $("#listgrid").show();
            //console.log(result);
            //exit;
            document.getElementById("community_filter_view").innerHTML = result;
        },
        error: function () {
            //console.log(); 
        }
    });
}



$(document).ready(function () {
    /**************Get State on select Country***************/
    $("#filter_country").on('change', function () {
        var countryId = this.value;
        $.ajax({
            url: '/user/getStateName',
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
                    $("#filter_state").empty();
                    $("#filter_city").empty();
                    $("#rustagi_branch").empty();
                    $("#filter_state").append("<option value=''>Select State</option>");
                    $.each(resp.statelist, function (idx, obj) {
                        $("#filter_state").append("<option value='" + obj["id"] + "'>" + obj["state_name"] + "</option>");
                    });
                } else {
                    $("#filter_state").empty();
                    $("#filter_city").empty();
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
    $("#filter_state").on('change', function () {
        var stateId = this.value;
        $.ajax({
            url: '/user/getCityName',
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
                    $("#filter_city").empty();
                    $("#rustagi_branch").empty();
                    $("#filter_city").append("<option value=''>Select City</option>");
                    $.each(resp.statelist, function (idx, obj) {
                        $("#filter_city").append("<option value='" + obj["id"] + "'>" + obj["city_name"] + "</option>");
                    });
                } else {
                    $("#filter_city").empty();
                    alert("No Cities are Available");
                }
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });
    });
    /*******************End******************/
     /*************Get Rustagi branch on Select City*************************************************/
    $("#filter_city").on('change', function () {
        var City_ID = this.value;
        //console.log(this.value);
        //exit;
        $.ajax({
            url: '/user/getRustagiBranch',
            type: "POST",
            dataType: "json",
            data: {
                City_ID: City_ID
            },
            beforeSend: function () {
                $('#Loading_Request').show();
            },
            complete: function () {
                $('#Loading_Request').hide();
            },
            success: function (resp) {
                if (resp.Status == 'Success') {
                    $("#rustagi_branch").empty();
                    $("#rustagi_branch").append("<option value=''>Select Branch</option>");
                    $.each(resp.statelist, function (idx, obj) {
                        $("#rustagi_branch").append("<option value='" + obj["branch_id"] + "'>" + obj["branch_name"] + "</option>");
                    });
                } else {
                    $("#rustagi_branch").empty();
                    alert("No Branch are Available");
                }
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });
    });
    /*******************End******************/
});


function showerror(error) {
    $(".showerrorbox").fadeIn();
    $(".showerrorbox").html(error);
}
function hideerror() {
    $(".showerrorbox").fadeOut();
}