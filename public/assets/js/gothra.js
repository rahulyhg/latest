
function findRowDataByGothraId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewGothraModel').html(data);
            
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

var radioSearchResult3 = function (data, textStatus, xhr)
{
    
    $("#gothra_data_list").html(data);
    
}

function grabvalues3(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='gothra_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#gothra_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var gothrasearchresp = function (data) {
    $("#gothrasearchresults").fadeIn();
    $("#gothrasearchresults").html(data);
}

function gothrasearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues3(rname) {

    $("#search_gothraName").val(rname);    
    $("#gothrasearchresults").fadeOut();

}