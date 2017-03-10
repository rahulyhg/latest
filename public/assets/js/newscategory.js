
//function findRowDataByReligionId(action, callback) {
////    alert(action);
////    console.log(action);
//
//    $.ajax({
//        url: action,
//        type: "post",
//        dataType:'html',
//        success: function (data) {
//            
//            $('#viewReligionModel').html(data);
//            
//           $('#myModal').modal({show: true});
//                   
//                
//           
//       // var ddd=JSON.parse(data);
//            //console.log(ddd);
////$("#myTabContent").html(data);
//            //location.reload();
//
//        }
//    });
//}
//
//function viewRowDataById(){
//    
//}

var radioSearchResult12 = function (data, textStatus, xhr)
{
    
    $("#newscategory_data_list").html(data);
    
}

function grabvalues12(rname, element) {



    if (element == "editparent") {
        $("form[name=editform] input[name='category_name']").val(cname);        
        $(".searchboxresults").fadeOut();

    }
    else {

        $("#category_name").val(rname);        
        $("#searchresults").fadeOut();
    }
}

var newscategorysearchresp = function (data) {
    $("#newscategorysearchresults").fadeIn();
    $("#newscategorysearchresults").html(data);
}

function newscategorysearchactions(val, action, callback, field) {

// alert(val+action+callback+field);
    var queryString = "value=" + val + "&fieldname=" + field;

    ajax_search_normal(queryString, action, callback);


}

function putvalues12(rname) {

    $("#search_newscategoryName").val(rname);    
    $("#newscategorysearchresults").fadeOut();

}