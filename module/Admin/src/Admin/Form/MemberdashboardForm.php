<?php
namespace Admin\Form;

use Admin\Model\Entity\Memberdashboards;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class MemberdashboardForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Memberdashboards');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Memberdashboards());
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'full_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'full_name'
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'image'
            ),
            'options' => array(
                'label' => 'Image',
            ),
        ));
        
        $this->add(array(
            'name' => 'native_place',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'native_place'
            ),
            'options' => array(
                'label' => 'Native Place',
            ),
        ));
        
        $this->add(array(
            'name' => 'address',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'address'
            ),
            'options' => array(
                'label' => 'Residence',
            ),
        ));
        
        $this->add(array(
            'name' => 'mobile_no',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'mobile_no'
            ),
            'options' => array(
                'label' => 'Mobile No',
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
