


function call_ajax_req(queryString, action, callback) {

    $.ajax({
        url: action,
        type: "post",
        async: false,
        data: queryString,
        success: function (data) {

            alert(data['status']);

            location.reload();

        }
    });
}


$(document).ready(function () {

    $(".itarget").click(function () {
        var target = $(this).attr("tar");

        $("#" + target).fadeIn().siblings(".dontshow").fadeOut();

    });

    $(".blue").click(function () {

        var id = $(this).attr("tar");

        $("#" + id).slideToggle("slow");

    });

    $("#showaddform").click(function () {
        //alert(11);
        //$('#addForm').html("");
        $("#addForm").fadeToggle("slow");
        $("#editForm").fadeOut("slow");

    });

    $("#search_countryName").blur(function () {

        $("#countrysearchresults").fadeOut();
    });
    $("#country_name").blur(function () {

        $("#searchresults").fadeOut();
    });
    $("#state_name").blur(function () {

        $("#searchresults").fadeOut();
    });

    var showChar = 20;
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";

    $('.showshort').each(function () {
        var content = $(this).html();

        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span style="display:none;">' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function () {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });

    $(".forgot-password-link").click(function () {
        $("#login-box").fadeOut();
        $("#forgotbox").fadeIn();

        // alert(1);
    });

    $(".back-to-login-link").click(function () {
        $("#forgotbox").fadeOut();
        $("#login-box").fadeIn();

        // alert(1);
    });

    // $("#closeCatBox").click(function(){
    // // $("#ShowCatBox").fadeIn();
    // 	$("#ShowCatBox").fadeOut();
    // })

});

function changestatus(id, element, url) {
    var statusval = $("#" + element).val();
    var queryString = 'id=' + id + '&IsActive=' + statusval;
    var callback = 'changestatusresp';
    var action = url;
    // alert(action+callback+queryString);
    call_ajax_req(queryString, action, callback);
}

var updateusertyperesult = function (data) {
    alert(data);
}

function changesuserType(utype, uid, action, callback) {
    // alert(uid+utype+action+callback);
    // var statusval = $("#"+element).val();
    var queryString = 'uid=' + uid + '&usertype=' + utype;
    if (utype == 0) {
        alert("please select something to change");
    }
    else {
        ajax_search(queryString, action, callback);
    }
}

function SubmitEventsForm(id) {

    var x = $("#editor1").html();

    // var y =	$("#image_path").val();

    // if(x.length<200){
    // 	alert("Description cant be empty.Please describe yor Event in minimum 20 words");
    // 	return false;
    // }
    // // else if(y.length==0){
    // // 	alert("File cant be empty. Please upload");
    // // 	return false;
    // // }
    // else {
    $("#event_desc").val(x);

    $("#" + id + " .form-control").each(function (index, val) {

        var formelement = $(this).attr("name");

        $(this).next("span").html("");
        // alert(formelement);
    });

    $("#" + id + " .form-control").each(function (index, val) {

        var formelement = $(this).attr("name");
        if ($(this).val() == "") {

            $(this).next("span").html("value is required and cant be empty");
            valid = false;
        }
        else
            valid = true;
    });

    return valid;
    // }


}

var searchboxresults = function (data) {

    $(".searchboxresults").fadeIn();
    $(".searchboxresults").html(data);
    // alert(data);

}

var addformResp = function (data) {
    var response = data;
    console.log(data);
    debugger;
// var elements = [];
    $("#" + response.FormId + " .form-control").each(function (index, val) {

        var formelement = $(this).attr("name");

        $("#" + response.FormId + " .form-control[name=" + formelement + "]").next("span").html("");

    });

    if (response.errors) {
        $.each(response.errors, function (i, field) {
            $("#" + response.FormId + " .form-control[name=" + field.element + "]").next("span").html(field.errors);
        });
    }
    else {
        alert(response.response);
        location.reload();
    }

// // alert(response.FormId);
// $.each(response.errors, function(i,field){
// 	alert(response.FormId);
// });


}


var editformresp = function (data) {
    $('#addForm').html("");
   // $("#addForm").fadeOut();
   //$("#addForm").html();
    $("#editForm").fadeIn();
    $("#editForm").html(data);
    //$("#addForm").fadeOut();
    
}

//added by amir...

var editformmatrimonialresp = function (data) {
    $('#addForm').html("");
   // $("#addForm").fadeOut();
   //$("#addForm").html();
    $("#editFormMatrimonial").fadeIn();
    $("#editFormMatrimonial").html(data);
    //$("#addForm").fadeOut();
    
}

var addformresp = function (data) {
    //alert(data);
    $('#editForm').html("");
    $("#editForm").fadeOut();
    $("#addForm").fadeIn();
    $("#addForm").html(data);
    //$("#addForm").fadeOut();
    
}

var editpageformresp = function (data) {
    // $("#addForm").fadeOut();
    // $("#editForm").fadeIn();
    $("#addForm").html(data);
    // alert(data);
}

function ajax_search(queryString, action, callback) {

    $.ajax({
        url: action,
        type: "post",
        dataType: "JSON",
        data: queryString,
        success: callback
    })

}

function ajax_search_normal(queryString, action, callback) {
    //alert(callback);
    $.ajax({
        url: action,
        type: "post",
        async: false,
        data: queryString,
        success: callback
    })

}

function SubmitFormAction(id, action, callback) {
    // alert(callback);
    var queryString = $("#" + id).serialize() + "&FormId=" + id;
    console.log(queryString);

    ajax_search(queryString, action, callback);

    return false;

}

function keyupresults(val, callback, field, action) {
    //alert(val);
    var queryString = "value=" + val + "&field=" + field;
   //alert(val+callback+action+field);
    ajax_search_normal(queryString, action, callback);

}

function keyupresults33(val, countryid, callback, action, field) {
    //alert(val);
    var queryString = "value=" + val + "&field=" + field + "&countryid=" + countryid;
   //alert(val+callback+action+field);
    ajax_search_normal(queryString, action, callback);

}

function keyupresults34(val, regionid, callback, action, field) {
    //alert(val);
    var queryString = "value=" + val + "&field=" + field + "&regionid=" + regionid;
   //alert(val+callback+action+field);
    ajax_search_normal(queryString, action, callback);

}

function keyupresults35(val, stateid, callback, action, field) {
    //alert(val);
    var queryString = "value=" + val + "&field=" + field + "&stateid=" + stateid;
   //alert(val+callback+action+field);
    ajax_search_normal(queryString, action, callback);

}

function grabvalues(cname, dcode, ccode, mid, element) {



   // if (element == "editparent") {
        $("form[name=editform] input[name='country_name']").val(cname);
        $("form[name=editform] input[name='dial_code']").val(dcode);
        $("form[name=editform] input[name='country_code']").val(ccode);
        $("form[name=editform] input[name='master_country_id']").val(mid);
        $(".searchboxresults").fadeOut();

    //}
    
    if(element==CountryForm){

        $("#country_name").val(cname);
        $("#dial_code").val(dcode);
        $("#country_code").val(ccode);
        $("#master_country_id").val(mid);
        $("#searchresults").fadeOut();
    }
}

function passvalues(sname, scode, mid, element) {

    //alert('hello');exit;

    //if (element == "StateFormEdit") {
        //alert('hello');exit;
        $("form[name=editform] input[name='state_name']").val(sname);
        //$("form[name=editform] input[name='dial_code']").val(dcode);
        $("form[name=editform] input[name='state_code']").val(scode);
        $("form[name=editform] input[name='master_state_id']").val(mid);
        $(".searchboxresults").fadeOut();

    //}
    if(element==StateForm) {

        $("#state_name").val(sname);
        //$("#dial_code").val(dcode);
        $("#state_code").val(scode);
        $("#master_state_id").val(mid);
        $("#searchresults").fadeOut();
    }
    
}

function sendvalues(cname, ccode, mid, element) {

    //alert('hello');exit;

    //if (element == "editparent") {
        //alert('hello');exit;
        $("form[name=editform] input[name='city_name']").val(cname);
        //$("form[name=editform] input[name='dial_code']").val(dcode);
        $("form[name=editform] input[name='city_code']").val(ccode);
        $("form[name=editform] input[name='master_city_id']").val(mid);
        $(".searchboxresults").fadeOut();

   // }
    if(element==CityForm) {

        $("#city_name").val(cname);
        //$("#dial_code").val(dcode);
        $("#city_code").val(ccode);
        $("#master_city_id").val(mid);
        $("#searchresults").fadeOut();
    }
    
}

function editboxsponsertype(id, action, callback) {

    // debugger;

    //alert(id + action + callback);
    var queryString = "chkedit=1&spons_type_id=" + id;

    ajax_search_normal(queryString, action, callback);
}

function editbox(id, action, callback) {

    // debugger;

    //alert(callback);
    var queryString = "chkedit=1&id=" + id;

    ajax_search_normal(queryString, action, callback);
}

function addbox1(action, callback) {

    // debugger;

    //alert(callback);
    var queryString = "chkedit=1&id=" + id;

    ajax_search_normal(queryString, action, callback);
}


var countrysearchresp = function (data) {
    $("#countrysearchresults").fadeIn();
    $("#countrysearchresults").html(data);
}

function countrysearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues(cname, dcode, ccode, mid) {

    $("#search_countryName").val(cname);
    $("#search_dialCode").val(dcode);
    $("#search_countryCode").val(ccode);
    $("#countrysearchresults").fadeOut();

}

function putCountry(sname, cname, cid) {
// alert(cname);
    $('#search_countryName').val(sname);
    $('#bookingFilter :input[name=country_id]').val(cid);
}

var performsearchresults = function (data) {
    // alert(data);

    // $('body').scrollTo('#dynamic-table',{duration:'slow', offsetTop : '50'});
    // $("#countrysearchresults").fadeIn();
    //$(".table-responsive").html(data);
    $("#dynamic-table").html(data);
}

function performsearch(id, action, callback) {

 //alert(id+action+callback);

    var queryString = $("#" + id + " .form-control").filter(function () {
        return !!this.value;
    }).serialize();

// alert(queryString);
    if (queryString == "") {
        alert("please enter something to search");
    }
    else {
        ajax_search_normal(queryString, action, callback);
    }
// alert(queryString);
    return false;
}

var radioSearchResult = function (data, textStatus, xhr)
{
    
    $("#country_data_list").html(data);
    
}



var RadioSearch = function (val, table, action, callback) {

    var queryString = "is_active=" + val + "&tbl=" + table;
// alert(val+table+action+callback);


    ajax_search_normal(queryString, action, callback);

}

var changstatusresult = function (data, textStatus, xhr)
{
    alert(data['status']);
    location.reload();
}

function changestatusquick(id, val, action, callback) {
   //alert(id+val+action+callback);
    if (val == 0) {
        val = 1;
    }
    else if (val == 1) {
        val = 0;
    }

    // // alert(val+5);
    var queryString = "id=" + id + "&is_active=" + val;
    // // alert(queryString);

    ajax_search(queryString, action, callback);
}

function changestatussponsertypequick(id, val, action, callback) {
   //alert(id+val+action+callback);
    if (val == 0) {
        val = 1;
    }
    else if (val == 1) {
        val = 0;
    }

    // // alert(val+5);
    var queryString = "spons_type_id=" + id + "&is_active=" + val;
    // // alert(queryString);

    ajax_search(queryString, action, callback);
}

function changestatuseventquick(id, val, action, callback) {
   //alert(id+val+action+callback);
    if (val == 0) {
        val = 1;
    }
    else if (val == 1) {
        val = 0;
    }

    // // alert(val+5);
    var queryString = "event_id=" + id + "&is_active=" + val;
    // // alert(queryString);

    ajax_search(queryString, action, callback);
}

function changestatussubeventquick(id, val, action, callback) {
   //alert(id+val+action+callback);
    if (val == 0) {
        val = 1;
    }
    else if (val == 1) {
        val = 0;
    }

    // // alert(val+5);
    var queryString = "subevent_id=" + id + "&is_active=" + val;
    // // alert(queryString);

    ajax_search(queryString, action, callback);
}

function checkall(id) {

    var chk = $("#" + id).prop("checked");
    $(".checkme").prop("checked", chk);
}

function checkall2(id) {

    var chk = $("#" + id).prop("checked");
    $(".checkme2").prop("checked", chk);
}

var delmultipleresp = function (data) {
    alert("selected record deleted");
    location.reload();

}

function delselected(action, callback) {


    var chkdata = $("input[name='checkme\\[\\]']:checked")
            .map(function () {
                return $(this).val();
            }).get();
    // alert(chkdata+action+callback);
    var queryString = "chkdata=" + chkdata;
    if (chkdata.length > 0) {
        ajax_search_normal(queryString, action, callback);
    }
    else
        alert("please select something to be deleted");
}



var statuschangeallresp = function (data) {

    alert(data);
    location.reload();
}

function statuschangeallsponsertype(action, callback, value) {

 //alert(action+callback+value);
    var chkdata = $("input[name='checkme\\[\\]']:checked")
            .map(function () {
                return $(this).val();
            }).get();
    // alert(chkdata+action+callback);
    var queryString = "spons_type_ids=" + chkdata + "&val=" + value;
    if (chkdata.length > 0) {
        ajax_search_normal(queryString, action, callback);
    }
    else
        alert("Please select something");
}

function statuschangeall(action, callback, value) {

// alert(action+callback+value);
    var chkdata = $("input[name='checkme\\[\\]']:checked")
            .map(function () {
                return $(this).val();
            }).get();
    // alert(chkdata+action+callback);
    var queryString = "ids=" + chkdata + "&val=" + value;
    if (chkdata.length > 0) {
        ajax_search_normal(queryString, action, callback);
    }
    else
        alert("Please select something");
}

function passVar(val, id, attr) {



    $("#" + id).fadeIn();
    $("#" + id).attr(attr, val);

}

//function passvalues(sname, scode, mid) {
//
//    // alert(sname+mid);
//    $("#state_name").val(sname);
//    $("#state_code").val(scode);
//    $("#master_state_id").val(mid);
//    $(".searchboxresults").fadeOut();
//}

var showeventsedit = function (data) {
// alert(data);
    $("#EditmyModal").html("");
    $("#EditmyModal").html(data);



}

var showeventsview = function (data) {
// alert(data);
// $("#ViewmyModal").html("");
    $("#ViewmyModal").html(data);



}

function validatenum(id, action) {

    var input = $("#" + id).find("input[type=number]");

    if (input.val().length == 10) {
        var num = input.val();
        input.next("span").html("");
        var queryString = "number=" + num;
        $.ajax({
            url: action,
            type: "post",
            data: queryString,
            dataType: "JSON",
            success: function (data) {
                var parsed = JSON.parse(data);
                if (parsed.resp == 1) {
                    var otp = $("#otpform");
                    $("#mobileform").fadeOut();
                    otp.fadeIn();
                    otp.find("input[name=time]").val(parsed.success.time);
                    otp.find("input[name=code]").val(parsed.success.code);
                    otp.find("input[name=number]").val(parsed.success.mobile);
                }
                else {
                    alert(parsed.error);
                }
            }
        });
    }
    else {
        input.next("span").html("<p style='color:red;'>not a valid number</p>");
    }

    return false;

}

var confirmotpresults = function (data) {
    var parsed = JSON.parse(data);

    if (parsed.resp == 1) {
        var otp = $("#otpform");
        var chgpass = $("#chgpass");
        // $("#mobileform").fadeOut();
        otp.fadeOut();
        chgpass.fadeIn();
        chgpass.find("input[name=userid]").val(parsed.success.userid);
        // alert();
    }
    else {
        alert(parsed.error);
    }
}

var chgpassresults = function (data) {

    var parsed = JSON.parse(data);

    if (parsed.resp == 1) {
        alert(parsed.success);
        location.reload();
    }
    else {
        alert(parsed.error);
    }

}

function confirmotp(id, action, callback) {

    var queryString = $("#" + id).serialize();

    ajax_search(queryString, action, callback);

    return false;
}

var showmembersresults = function (data) {
    // alert(data);
    $(".showrusertypes").html(data);
}

function showmembers(id, tab, action, callback) {

    // alert(id+tab+action+callback);
    var queryString = "id=" + id + "&tab=" + tab;

    ajax_search_normal(queryString, action, callback);
}

function SubmitpageForm(id) {

    var x = $("#editor1").html();

    if (x == "" || x.length < 200) {
        alert("content can not be empty and should be greater than 20 words");
        return false;
    }
    else
        $("#page_content").val(x);

    $("#" + id + " .form-control").each(function (index, val) {

        var formelement = $(this).attr("name");

        $(this).next("span").html("");
        // alert(formelement);
    });

    $("#" + id + " .form-control").each(function (index, val) {

        var formelement = $(this).attr("name");
        if ($(this).val() == "") {

            $(this).next("span").html("value is required and cant be empty");
            valid = false;
        }
        else
            valid = true;
    });

    return valid;
    // }


}
var changCommTyperesults = function (data) {
    // alert(data);
    $("#ShowCatBox").fadeIn();
    $("#ShowCatContent").html(data);
}

function changeCommType(cid, uid, action, callback) {
    var queryString = "cid=" + cid + "&user_id=" + uid;

    // alert(cid+uid+action+callback);
    if (cid == 0) {

        if (confirm("are you sure you want to unassign community designation")) {
            ajax_search_normal(queryString, action, callback);
        }
    }
    else
        ajax_search_normal(queryString, action, callback);
}

function closeme() {
    // body...
    $("#ShowCatBox").fadeOut();

}


var unassignparentres = function (data) {
    alert(data);
    location.reload();
}
var updcommresults = function (data) {
    var resp = data;
// alert(resp.status);
    if (resp.status == 4) {
        $("#ShowCatContent").html(resp.Content);

    }
    else if (resp.status == 3) {
        alert(resp.Content);

        if (confirm("To change this parent designation . You need to unassign first. click(ok) to unassign or cancel for no action")) {
            var next = resp.nextaction;
            var callback = eval(next.callback);
            var queryString = "user_id=" + next.user_id + "&F_year=" + next.fyear + "&cat_id=" + next.catid;

            ajax_search_normal(queryString, next.action, callback);
            // alert(callback);
        }
    }
    else if (resp.status == 8) {
        alert(resp.Content);
        if (confirm("To change this parent designation . You need to unassign first. click(ok) to unassign or cancel for no action")) {

            var next = resp.nextaction;
            var callback = eval(next.callback);
            var queryString = "user_id=" + next.user_id;

            ajax_search_normal(queryString, next.action, callback);

        }
    }
    else
        alert(resp.Content);

}

function updateuser(catid, uid, action, callback) {

    // alert(catid+uid);
    var queryString = "catid=" + catid + "&user_id=" + uid;

    ajax_search(queryString, action, callback);
}

function showmybox(id) {


    $("#" + id).fadeIn().siblings(".commcategories").fadeOut();


}

var assignUserresults = function (data) {
    alert(data);
}


function AssignUser(SubAgId, action, callback) {

    // var AgentId =  $("input[type=radio]:checked").val();

    alert(action);

    return false;
}

var viewassignedresults = function (data) {
    $("#ShowCatBox").fadeIn();
    $("#ShowCatContent").html(data);
}

function viewAssigned(uid, uname, action, callback) {

    // alert(uid+uname+action+callback);
    var queryString = "sub_id=" + uid + "&subname=" + uname;

    ajax_search_normal(queryString, action, callback);

}

var UnassignCommPosRes = function (data) {
    // var resp = Json.parse(data);
    alert(data.msg);
    location.reload();
    // if(data.Status == 1)
}

function UnassignSubAgent(AgId, SubAgId, Head, action, callback) {

// alert(Head);

    var queryString = "agent_id=" + AgId + "&sub_agent_id=" + SubAgId + "&Head=" + Head;
    if (confirm("This user will loose its previous designation. Are you sure you want to reassign")) {
        ajax_search(queryString, action, callback);
    }

}


var ShowUserRolesResults = function (data) {

    var resp = data;
    // alert(resp.content);

    $("#ShowCatBox").fadeIn();
    $("#ShowCatContent").html(data);
    ismember("Member");
}

function ShowUserRoles(uid, action, callback) {
    // alert(uid+action+callback);
    var queryString = "user_id=" + uid;


    ajax_search_normal(queryString, action, callback);
}


var manageroleresults = function (data) {
    // var resp = Json.parse(data);
    alert(data.Content);
    // location.reload();
    // if(data.Status == 1)
}


function ManageRole(formid, action, callback) {

    var queryString = $("#" + formid).serialize();

     //alert(queryString);

    ajax_search(queryString, action, callback);

    return false;
}

function ismember(id) {
//alert(id);exit;
    var checked = $("#" + id).prop("checked");

    if (checked == true) {
        $("#Executive").prop("disabled", false);
    }
    else
        $("#Executive").prop("disabled", true);

}

var memberlistingresults = function (data) {
    var resp = data;
    alert(resp.Content);
    // location.reload();
    // if(data.Status == 1)
}


function memberlisting(elid, formid, tbl, field, val, memtype, action, callback) {

    var queryString = "eleId=" + elid + "&form=" + formid + "&table=" + tbl + "&fieldname=" + field + "&value=" + val + "&Mtype=" + memtype;
    // alert(val);


    ajax_search(queryString, action, callback);

}


var addtositeresults = function (data) {
    // var resp = data;
    // alert(resp.Content);
    alert(data);
    location.reload();
    // if(data.Status == 1)
}

function addtosite(user, val, table, field, action, callback) {

    var queryString = "value=" + val + "&table=" + table + "&fieldname=" + field + "&uid=" + user;
    // alert(queryString);

    ajax_search_normal(queryString, action, callback);
}

function findRowDataByCountryId(action, callback) {
    //alert(action);
    //console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewCountryModel').html(data);
            
           $('#myModal').modal({show: true});
                   
                
           
       // var ddd=JSON.parse(data);
            //console.log(ddd);
//$("#myTabContent").html(data);
            //location.reload();

        }
    });
}

function findRowDataByStateId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewStateModel').html(data);
            
           $('#myModal').modal({show: true});
                   
                
           
       // var ddd=JSON.parse(data);
            //console.log(ddd);
//$("#myTabContent").html(data);
            //location.reload();

        }
    });
}

//for member view dashboard...

function findRowDataByMemberId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            //alert(data);
            
            $('#viewMemberModel').html(data);
            
           $('#myModal').modal({show: true});
                   
                
           
       // var ddd=JSON.parse(data);
            //console.log(ddd);
//$("#myTabContent").html(data);
            //location.reload();

        }
    });
}

//for matrimonial view dashboard...

function findRowDataByMatrimonialId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            //alert(data);
            
            $('#viewMatrimonialModel').html(data);
            
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

//added by amir

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
        var val =   data.data;
        var post_img = val.split("/");
        $("#post_photo").attr("src", data.data);
        $("#image").val(post_img[2]);
        $("#post_image_flag").val('1');
        $("#avatar-modalpost_image").removeClass("in")
        $("#avatar-modalpost_image").attr("aria-hidden","true");
        $("#avatar-modalpost_image").css("display","none");
        $("div").removeClass("modal-backdrop fade in");
        $("body").removeClass("modal-open");
    }else{
    
        alert(data.message);
    }
    //location.reload();
//  console.log(data)	;
}

var croppostimageresults2 = function (data) {
     //alert(data.Status);
    if (data.Status == 1) {
        var val =   data.data;
        var post_img = val.split("/");
        $("#post_photo").attr("src", data.data);
        $("#spons_image").val(post_img[2]);
        $("#post_image_flag").val('1');
        $("#avatar-modalpost_image").removeClass("in")
        $("#avatar-modalpost_image").attr("aria-hidden","true");
        $("#avatar-modalpost_image").css("display","none");
        $("div").removeClass("modal-backdrop fade in");
        $("body").removeClass("modal-open");
    }else{
    
        alert(data.message);
    }
    //location.reload();
//  console.log(data)   ;
}
