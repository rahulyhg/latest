
function findRowDataByUsertypemasterId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewUsertypemasterModel').html(data);
            
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
    
    $("#usertypemaster_data_list").html(data);
    
}

function grabvalues2(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='user_type']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#user_type").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var usertypemastersearchresp = function (data) {
    $("#usertypemastersearchresults").fadeIn();
    $("#usertypemastersearchresults").html(data);
}

function usertypemastersearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues2(rname) {

    $("#search_usertypemasterName").val(rname);    
    $("#usertypemastersearchresults").fadeOut();

}