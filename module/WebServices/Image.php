<?php

namespace WebServices;


class Image{

    const USERPROFILEIMAGE = '1';
    const USERMEMBER='2';
    const IMAGESIZE='10000';
    const READ='1';
    const WRITE='2';
    const EXECUTE='3';
    const DELETE='4';
    const IMAGETYPEDEFAULT='0';
    const FILENOTEXIT='0';
    const SOFTDELETE= '1';
    const NOTSOFTDELETE ='0';

    public static $directoryName = array(
        self::USERPROFILEIMAGE => 'matrimonialImages/profileimages',
        self::USERMEMBER => 'tbl_user',
       
    );
    
    public static $imageType=['jpeg','jpg','png','bmp'];
    
    public static $folderPermissionMode=[
        self::READ=>0756,
        self::WRITE=>0777,
        self::EXECUTE=>0755,
        self::DELETE=>0777
    ];
}
