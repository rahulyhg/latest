<?php

namespace Common\Form\Entity\User;

class User {
    protected $profile;
    protected $credentials;
    protected $id;
    protected $baz;
    
    function getBaz() {
        return $this->baz;
    }

    function setBaz($baz) {
        $this->baz = $baz;
    }

                
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

       
    function getProfile() {
        return $this->profile;
    }

    function getCredentials() {
        return $this->credentials;
    }

    function setProfile(\Common\Entity\Profile\Profile $profile) {
        $this->profile = $profile;
    }

    function setCredentials(\Common\Entity\Credentials\Credentials $credentials) {
        $this->credentials = $credentials;
    }





}
