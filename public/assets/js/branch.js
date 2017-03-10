
function findRowDataByBranchId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewBranchModel').html(data);
            
           $('#myModal').modal({show: true});
                   
                
           
       // var ddd=JSON.parse(data);
            //console.log(ddd);
//$("#myTabContent").html(data);
            //location.reload();

        }
    });
}

function viewRowDataById(){
    
}

var radioSearchResult2 = function (data, textStatus, xhr)
{
    
    $("#branch_data_list").html(data);
    
}

function grabvalues2(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='branch_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#branch_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var branchsearchresp = function (data) {
    $("#branchsearchresults").fadeIn();
    $("#branchsearchresults").html(data);
}

function branchsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues2(rname) {

    $("#search_branchName").val(rname);    
    $("#branchsearchresults").fadeOut();

}

// fiter data
function filterData2() {
   
    if (document.getElementById('filter_country2').value != 0) {
        var country = document.getElementById('filter_country2').value;
        
    }
    if (document.getElementById('filter_state').value != 0) {
        var state = document.getElementById('filter_state').value;
    }
    if (document.getElementById('filter_city').value != 0) {
        var city = document.getElementById('filter_city').value;
    }
    if (document.getElementById('filter_branch').value != 0) {
        var branch = document.getElementById('filter_branch').value;
    }
    //alert(country);
    //alert(state);
    //alert(city);
    //alert(branch);
//    if(document.getElementById('filter_country2').value == ''){
//        alert('select country first');
//    }
//    if(document.getElementById('filter_state').value == ''){
//        alert('select state first');
//    }
//    if(document.getElementById('filter_city').value == ''){
//        alert('select city first');
//    }
//    if(document.getElementById('filter_branch').value == ''){
//        alert('select branch first');
//    }
    

    var data = {
        
        Country_id: country,
        State_id: state,
        City_id: city,
        Branch_id: branch,
        
    }

    var url = 'branch/performsearch';
    $.ajax({
        type: 'POST',
        url: url,
        dataType: "html",
        data: data,
        success: function (result) {
            //alert(result);
            //$(".showerrorbox").fadeOut();
	    $("#branch_data_list").hide();
	    //$("#listgrid").show();
            document.getElementById("branch_search_list").innerHTML = result;
        },
        error: function () {
            //console.log(); 
        }
    });
}
//city search

$(document).ready(function () {
    
   
    //alert('countryId');
    /**************Get State on select Country***************/
    $("#filter_country2").on('change', function () {
        var countryId = this.value;
        //alert(countryId);
        $.ajax({
            url: 'city/getStateName',
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
                //alert(resp);
                if (resp.Status == 'Success') {
                    $("#filter_state").empty();
                    $("#filter_city").empty();
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
            url: 'city/getCityName',
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
    /*************Get Branch on Select City*************************************************/
    $("#filter_city").on('change', function () {
        var cityId = this.value;
        //alert(cityId);
        $.ajax({
            url: 'branch/getBranchName',
            type: "POST",
            dataType: "json",
            data: {
                City_ID: cityId
            },
            beforeSend: function () {
                $('#Loading_Request').show();
            },
            complete: function () {
                $('#Loading_Request').hide();
            },
            success: function (resp) {
                if (resp.Status == 'Success') {
                    $("#filter_branch").empty();
                    $("#filter_branch").append("<option value=''>Select Branch</option>");
                    $.each(resp.citylist, function (idx, obj) {
                        $("#filter_branch").append("<option value='" + obj["branch_id"] + "'>" + obj["branch_name"] + "</option>");
                    });
                } else {
                    $("#filter_branch").empty();
                    alert("No Branches are Available");
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