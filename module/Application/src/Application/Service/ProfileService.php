<?php

namespace Application\Service;

use Application\Mapper\ProfileMapperInterface;

class ProfileService implements ProfileServiceInterface{

    protected $profileMapper;

    public function __construct(ProfileMapperInterface $profileMapper) {
        $this->profileMapper = $profileMapper;
    }

    

}
