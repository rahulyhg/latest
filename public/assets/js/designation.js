
function findRowDataByDesignationId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#viewDesignationModel').html(data);
            
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
    
    $("#designation_data_list").html(data);
    
}

function grabvalues7(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='designation']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#designation").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var designationsearchresp = function (data) {
    $("#designationsearchresults").fadeIn();
    $("#designationsearchresults").html(data);
}

function designationsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues7(rname) {

    $("#search_designationName").val(rname);    
    $("#designationsearchresults").fadeOut();

}