
function findRowDataByCommunityId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewCommunityModel').html(data);
            
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
    
    $("#community_data_list").html(data);
    
}

function grabvalues3(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='community_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#community_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var communitysearchresp = function (data) {
    $("#communitysearchresults").fadeIn();
    $("#communitysearchresults").html(data);
}

function communitysearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues3(rname) {

    $("#search_communityName").val(rname);    
    $("#communitysearchresults").fadeOut();

}