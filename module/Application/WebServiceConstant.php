<?php
namespace Application;
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
    
    /**
     * Error Messages
     * @var array
     */
    public $userMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_user_matrimonial',
        self::USERMEMBER => 'tbl_user',
       
    );
    
    public $mobileMappedTable = array(
        self::USERMATRIMONIAL => 'tbl_mobile_matrimonial',
        self::USERMEMBER => 'tbl_mobile',
       
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
    
}
