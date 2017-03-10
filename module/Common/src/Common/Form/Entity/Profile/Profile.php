<?php

namespace Common\Form\Entity\Profile;

class Profile {
    protected $text;
   
    function getText() {
        return $this->text;
    }

    function setText($text) {
        $this->text = $text;
    }




}
