
function findRowDataByEducationfieldId(action, callback) {
//    alert(action);
//    console.log(action);

    $.ajax({
        url: action,
        type: "post",
        dataType:'html',
        success: function (data) {
            
            $('#vieweducationfieldModel').html(data);
            
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

var  radioSearchResult6= function (data, textStatus, xhr)
{
    
    $("#educationfield_data_list").html(data);
    
}

function grabvalues8(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='education_field']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#education_field").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var educationfieldsearchresp = function (data) {
    $("#educationfieldsearchresults").fadeIn();
    $("#educationfieldsearchresults").html(data);
}

function educationfieldsearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues8(rname) {

    $("#search_educationfieldName").val(rname);    
    $("#educationfieldsearchresults").fadeOut();

}