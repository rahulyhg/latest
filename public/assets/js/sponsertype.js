
function findRowDataBySponsertypeId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewSponsertypeModel').html(data);
            
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
    
    $("#sponsertype_data_list").html(data);
    
}

function grabvalues2(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='spons_type_title']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#spons_type_title").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var sponsertypesearchresp = function (data) {
    $("#sponsertypesearchresults").fadeIn();
    $("#sponsertypesearchresults").html(data);
}

function sponsertypesearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues2(rname) {

    $("#search_sponsertypeTitle").val(rname);    
    $("#sponsertypesearchresults").fadeOut();

}