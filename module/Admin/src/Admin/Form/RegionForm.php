<?php
namespace Admin\Form;

use Admin\Model\Entity\Regions;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class RegionForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Regions');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Regions());
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'region_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'region_name'
            ),
            'options' => array(
                'label' => 'Region Name',
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
