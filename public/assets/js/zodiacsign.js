
function findRowDataByZodiacsignId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewZodiacsignModel').html(data);
            
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
    
    $("#zodiacsign_data_list").html(data);
    
}

function grabvalues5(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='zodiac_sign_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#zodiac_sign_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var zodiacsignsearchresp = function (data) {
    $("#zodiacsignsearchresults").fadeIn();
    $("#zodiacsignsearchresults").html(data);
}

function zodiacsignsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues5(rname) {

    $("#search_zodiacsignName").val(rname);    
    $("#zodiacsignsearchresults").fadeOut();

}