
function findRowDataByEducationlevelId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#vieweducationlevelModel').html(data);
            
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

var  radioSearchResult6 = function (data, textStatus, xhr)
{
    //$("#educationlevel_data_list").html("");
    $("#educationlevel_data_list").html(data);
    
}

function grabvalues9(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='education_level']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#education_level").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var educationlevelsearchresp = function (data) {
    $("#educationlevelsearchresults").fadeIn();
    $("#educationlevelsearchresults").html(data);
}

function educationlevelsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues9(rname) {

    $("#search_educationlevelName").val(rname);    
    $("#educationlevelsearchresults").fadeOut();

}

var searchboxresultslevel = function (data) {

    $(".searchboxresultslevel").fadeIn();
    $(".searchboxresultslevel").html(data);
    // alert(data);

}