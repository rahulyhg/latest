
function findRowDataByUsertypeId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewUsertypeModel').html(data);
            
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

var radioSearchResult21 = function (data, textStatus, xhr)
{
    
    $("#usertype_data_list").html(data);
    
}

function grabvalues21(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='user_type']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#user_type").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var usertypesearchresp = function (data) {
    $("#usertypesearchresults").fadeIn();
    $("#usertypesearchresults").html(data);
}

function usertypesearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues21(rname) {

    $("#search_usertypeName").val(rname);    
    $("#usertypesearchresults").fadeOut();

}