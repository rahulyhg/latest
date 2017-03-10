<?php
namespace WebServices;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class WebServiceConstant{
    
   
    const USERMEMBER        ='1'; // user exit in tbl_user
    const USERMATRIMONIAL   ='2'; // user exit in tbl_user_matrimonial
    
    const USEREXCUTIVE      ='3'; // user exit in tbl_user
    
    const  USEREXITINBOTH   ='4'; // User Exitin in both table tbl_user and tbl_user_matrimonial
    
    const FATHER='1'; //  Father relationship Id with User

    const MOTHER='2'; //  Mother relationship Id with User
    
    const BROTHER='3'; // Brother relationship Id with User
    
    const SISTER='4'; // Sister relationship Id with User
    
    const SPOUSE='5'; // Spouse relationship Id with User
    
    const KID='6'; // Kid relationship Id with User
    
    const GRANDFATHER='7'; // Grand Father relationship Id with User
    
    const GRANDMOTHER='8'; // Grand Mother relationship Id with User
    
    const SPOUSEBROTHER='9'; // Spouse Brother relationship Id with User
    
    const SPOUSESISTER='10'; // Spouse Sister relationship Id with User
    
    const SPOUSEFATHER='11'; // Spouse Father relationship Id with User
    
    const SPOUSEMOTHER='12'; // Spouse Mother relationship Id with User
    
    const GREATGRANDFATHER='13'; // Great Grand Father relationship Id with User
    
    const GREATGRANDMOTHER='14'; // Great Grand Mother relationship Id with User
    
    const WIFE='15'; // Wife relationship Id with User
    
    const HUSBAND='16'; // Husband relationship Id with User
    
    const USEREXITMSG ='user exit';
    const USERINACTIVEMSG = 'user inactive';
    const USERACTIVEMSG = 'user Active';
    const USERNOTEXITMSG= 'user not exit';
    const USERNAMENOTAVILMSG='username not available';
    const MOBILENUMBEREXITMSG='Mobile already registered with us';
    const EMAILNAMENOTAVILMSG='Email id not available';
    const INVAILDARRUGMENTMSG ='Exception\InvalidArgumentException';
    const USEREXITINBOTHMSG= 'User exit in both';
    const NOTFOUNDMSG='data not found';
    const FOUNDMSG='data found';
    const DETAILEDSAVEDMSG='detials Saved ';
    const DETAILEDNOTSAVEDMSG='detials Not Saved';
    const UPDATEMSG='data updated';
    const NOTUPDATEMSG='data not updated';
    const SIGNUPINUSER='1';
    const SIGNUPINUSERINFO='2';
    const OTPVERIFYED='3';
    const FORGETPASSWORDACTION='2';
    const SIGNUPACTION='1';
    const USERIMAGE='U';
    const FAMILYIMAGE='F';
    const APPROVED='1';
    const NOTAPPROVED='0';
    const IMAGEPATHNOTSAVED='Error occur while saving the path in database, but file is uploaded';
    const INVALIDIMAGEFORMAT='Request images not in valid format.';
    const USERMEMBERDUMMY='0';
    const MALE='male';
    const FEMALE='female';

    public $userMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_user_matrimonial',
        self::USERMEMBER => 'tbl_user',
       
    );
    
    public $mobileMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_mobile_matrimonial',
        self::USERMEMBER => 'tbl_mobile',
       
    );
    
    public $userInfoMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_user_info_matrimonial',
        self::USERMEMBER => 'tbl_user_info',
       
    );
    
    public $userGallaryMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_user_gallery_matrimonial',
        self::USERMEMBER => 'tbl_user_gallery',
       
    );
    
    public $userProfessionMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_user_professional_matrimonial',
        self::USERMEMBER => 'tbl_user_info',
       
    );
    
     public $userEducationMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_user_education_matrimonial',
        self::USERMEMBER => 'tbl_user_info',
       
    );
     
     public $userFamilyInfoMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_family_info_matrimonial',
        self::USERMEMBER => 'tbl_user_info',
       
    );
     
     
      public $userReferalKeyUsedMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_user_matrimonial_referral_key_used',
        self::USERMEMBER => 'tbl_user_referral_key_used',
       
    );
     
     
     
    public $familyRelationMappedTable=array(
        'fname'=>self::FATHER,
        'mname'=>self::MOTHER,
        'brother'=>self::BROTHER,
        'sister'=>self::SISTER,
        'spouse'=>self::SPOUSE,
        'kid'=>self::KID,
        'gfname'=>self::GRANDFATHER,
        'gmname'=>self::GRANDMOTHER,
        'sbrother'=>self::SPOUSEBROTHER,
        'ssister'=>self::SPOUSESISTER,
        'sfather'=>self::SPOUSEFATHER,
        'smother'=>self::SPOUSEMOTHER,
        'ggfname'=>self::GREATGRANDFATHER,
        'ggmname'=>self::GREATGRANDMOTHER,
    );
    
    public static $profileExculdeParam=['id', "ref_no", "user_id", "user_type_id",
                                        "comm_mem_id", "comm_mem_status", "ip", 
                                        "created_date", "modified_date"];
    
}
