<?php

namespace WebServices\Service;

interface ImageServicesInterface{
    
    public function userImageUpload(array $data, $imageType);
    public function userMultipleImageUpload(array $data, $imageType);
    public function userProfileImageHardDelete(array $data, $loginType);
    public function userProfileImageSoftDelete(array $data, $loginType);
    public function getUserImages($id, $loginType);
}
