<?php
namespace Admin\Form;

use Admin\Model\Entity\Designations;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class DesignationForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Designations');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Designations());
            
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'designation',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'designation'
            ),
            'options' => array(
                'label' => 'Designation Name',
            ),
        ));

        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'is_active',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'is_active'
        ),
        'options' => array(
            'label' => 'Status',
        'value_options' =>  array(
            '1'=>'Active',
            '0'=>'In Active'),
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
