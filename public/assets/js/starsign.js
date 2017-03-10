
function findRowDataByStarsignId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewStarsignModel').html(data);
            
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

var radioSearchResult4 = function (data, textStatus, xhr)
{
    
    $("#starsign_data_list").html(data);
    
}

function grabvalues4(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='star_sign_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#star_sign_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var starsignsearchresp = function (data) {
    $("#starsignsearchresults").fadeIn();
    $("#starsignsearchresults").html(data);
}

function starsignsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues4(rname) {

    $("#search_starsignName").val(rname);    
    $("#starsignsearchresults").fadeOut();

}