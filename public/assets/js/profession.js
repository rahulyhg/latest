
function findRowDataByProfessionId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewProfessionModel').html(data);
            
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
    
    $("#profession_data_list").html(data);
    
}

function grabvalues6(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='profession']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#profession").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var professionsearchresp = function (data) {
    $("#professionsearchresults").fadeIn();
    $("#professionsearchresults").html(data);
}

function professionsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues6(rname) {

    $("#search_professionName").val(rname);    
    $("#professionsearchresults").fadeOut();

}