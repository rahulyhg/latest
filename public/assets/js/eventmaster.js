
function findRowDataByEventmasterId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewEventmasterModel').html(data);
            
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
    
    $("#eventmaster_data_list").html(data);
    
}

function grabvalues2(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='event_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#event_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var eventmastersearchresp = function (data) {
    $("#eventmastersearchresults").fadeIn();
    $("#eventmastersearchresults").html(data);
}

function eventmastersearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues2(rname) {

    $("#search_eventmasterName").val(rname);    
    $("#eventmastersearchresults").fadeOut();

}