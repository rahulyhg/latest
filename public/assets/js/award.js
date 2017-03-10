
function findRowDataByAwardId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewAwardModel').html(data);
            
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
    
    $("#award_data_list").html(data);
    
}

function grabvalues2(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='award_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#award_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var awardsearchresp = function (data) {
    $("#awardsearchresults").fadeIn();
    $("#awardsearchresults").html(data);
}

function awardsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues2(rname) {

    $("#search_awardName").val(rname);    
    $("#awardsearchresults").fadeOut();

}