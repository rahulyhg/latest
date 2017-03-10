<?php

namespace Admin\Form;

use Zend\Form\Form;
use Admin\Model\Entity\AllPages;

class PagesForm extends Form {

    // public static $state_nameList = array();
    // public static $country_nameList = array();


    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('tbl_pages');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

//        $this->add(array(
//            'name' => 'tab_id',
//            'attributes' => array(
//                'type' => 'number',
//                'class' => 'form-control',
//                'id' => 'tab_id'
//            ),
//            'options' => array(
//                'label' => 'Tab Id',
//            ),
//        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'title'
            ),
            'options' => array(
                'label' => 'Page Title',
            ),
        ));
        
        $this->add(array(
            'name' => 'page_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'page_name'
            ),
            'options' => array(
                'label' => 'Page Name',
            ),
        ));

        $this->add(array(
            'type' => 'Hidden',
            'name' => 'description',
            'attributes' => array(
                'id' => 'description',
            ),
            'options' => array(
                'label' => 'Page Content',
            )
        ));
        
        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type' => 'file',
                 
                'id'=>'image'
            ),
            'options' => array(
                'label' => 'Upload Image',
            ),
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'is_active',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'is_active'
            ),
            'options' => array(
                'label' => 'Status',
                'empty_option' => 'Please Select Status',
                'value_options' => array(
                    '1' => 'Active',
                    '0' => 'In Active'),
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Contact Us',
                'id' => 'submit',
                'class' => 'btn btn-default'
            ),
        ));
    }

}
