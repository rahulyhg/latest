<?php

namespace Common\Form\Fieldset;

use Zend\Form\Fieldset;

class PostFieldset extends Fieldset {

    public function __construct($name = null, $options = array())
     {
         parent::__construct($name, $options);
         
        $this->add(array(
            'type' => 'hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'text',
            'options' => array(
                'label' => 'The Text'
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'title',
            'options' => array(
                'label' => 'Blog Title'
            )
        ));
    }

}
