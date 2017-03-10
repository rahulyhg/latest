<?php
namespace Admin\Form;

use Admin\Model\Entity\Branchs;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class BranchForm extends Form {

    public static $country_nameList = array();
    public static $state_nameList = array();
    public static $city_nameList = array();
    
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Branchs');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Branchs());
        	
		$this->add(array(
            'name' => 'branch_id',
            'type' => 'Hidden',
        ));
                
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'country',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'country'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$country_nameList,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'state',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'state'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$state_nameList,
                'disable_inarray_validator' => true,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'branch_city_id',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'branch_city_id'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$city_nameList,
                'disable_inarray_validator' => true,
            )
        ));

        $this->add(array(
            'name' => 'branch_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'branch_name'
            ),
            'options' => array(
                'label' => 'Branch Name',
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
