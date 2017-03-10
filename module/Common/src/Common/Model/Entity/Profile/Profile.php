<?php

namespace Common\Model\Entity\Profile;

class Profile {
    protected $text;
   
    function getText() {
        return $this->text;
    }

    function setText($text) {
        $this->text = $text;
    }




}
