

    function sendInterest(uid,type){
     if(USERAUTH === false){
              $('#loginPopUpModal').modal('show');
              return false;
          }else if((USERAUTH === 1) &&(USERTYPEID!=2)){
              $('#confirmPopUpModal').modal('show');
              return false;
              }
     $.ajax({
      url: '/matrimonial/sendRequest',
      data: {
         uid: uid,type: type
      },
     error: function (request, status, error) {
        console.log(status);
    },
     
      success: function(data) {
         console.log(data);
      },
      type: 'POST'
   });
    }
    
    
    function sendInterestToMember(uid,type){ 
     if(USERAUTH === false){
              $('#loginPopUpModal').modal('show');
              return false;
          }else if((USERAUTH===1) &&(USERTYPEID!=1)){ 
              $('#confirmMemberPopUpModal').modal('show');
              return false;
              }
     $.ajax({
      url: '/membership/sendRequest',
      data: {
         uid: uid,type: type
      },
     error: function (request, status, error) {
        console.log(status);
    },
     
      success: function(data) {
         console.log(data);
      },
      type: 'POST'
   });
    }
  
    /*************Get Communuty on Select Religion*************************************************/
    $("#religion").on('change', function () {
        var religionId = this.value;
        $.ajax({
            url: '/user/getCommunityName',
            type: "POST",
            dataType: "json",
            data: {Religion_ID: religionId},
            beforeSend: function () {
                $('#Loading_Request').show();
            },
            complete: function () {
                $('#Loading_Request').hide();
            },
            success: function (resp) {
                if (resp.Status == 'Success') {
                    $("#community").empty();
                    $("#community").append("<option value=''>Select Community</option>"); 
                    $.each(resp.communitylist, function (idx, obj) { 
                        $("#community").append("<option value='" + obj["id"] + "'>" + obj["community_name"] + "</option>");
                    });
                } else {
                    $("#community").empty();
                 
                    $("#community").append("<option value=''>Select Community</option>");
                    $("#caste").empty();
                
                    $("#caste").append("<option value=''>Select Sub-Community/Caste</option>");
                    $("#gothra_gothram").empty();
                    $("#gothra_gothram").append("<option value=''>Select Gothra</option>");
                    alert("No Community are Available");
                }
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });
    });
    /*******************End******************/
    
    
    /*************Get Sub-Community/Cast on Select Communuty*************************************************/
    $("#community").on('change', function () {
        var communityId = this.value;
        $.ajax({
            url:  '/user/getCasteName',
            type: "POST",
            dataType: "json",
            data: {Community_ID: communityId},
            beforeSend: function () {
                $('#Loading_Request').show();
            },
            complete: function () {
                $('#Loading_Request').hide();
            },
            success: function (resp) {
                if (resp.Status == 'Success') {
                    $("#caste").empty();
                    $("#caste").append("<option value=''>Select Sub-Community/Caste</option>");
                    $.each(resp.castelist, function (idx, obj) {
                        $("#caste").append("<option value='" + obj["id"] + "'>" + obj["caste_name"] + "</option>");
                    });
                } else {
                    $("#caste").empty();
                    $("#caste").append("<option value=''>Select Sub-Community/Caste</option>");
                    $("#gothra_gothram").empty();
                    $("#gothra_gothram").append("<option value=''>Select Gothra</option>");
                    alert("No Sub-Community/Caste are Available");
                }
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });
    });
    /*******************End******************/
    
        /*************Get Gothra on Select Communuty*************************************************/
    $("#caste").on('change', function () {
        var casteId = this.value;
        $.ajax({
            url:  '/user/getGothraList',
            type: "POST",
            dataType: "json",
            data: {Caste_ID: casteId},
            beforeSend: function () {
                $('#Loading_Request').show();
            },
            complete: function () {
                $('#Loading_Request').hide();
            },
            success: function (resp) {
                if (resp.Status == 'Success') {
                    $("#gothra_gothram").empty();
                    $("#gothra_gothram").append("<option value=''>Select Gothra</option>");
                    $.each(resp.gothralist, function (idx, obj) {
                        $("#gothra_gothram").append("<option value='" + obj["id"] + "'>" + obj["gothra_name"] + "</option>");
                    });
                } else {
                    $("#gothra_gothram").empty();
                    $("#gothra_gothram").append("<option value=''>Select Gothra</option>");
                    alert("No Gothra are Available");
                }
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });
    });
    /*******************End******************/