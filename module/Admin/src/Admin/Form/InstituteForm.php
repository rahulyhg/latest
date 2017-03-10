<?php
namespace Admin\Form;

use Admin\Model\Entity\Institutes;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class InstituteForm extends Form {
    
    public static $country_nameList = array();
    public static $state_nameList = array();
    public static $city_nameList = array();
    public static $member_List = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Institutes');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Institutes());
        	
		$this->add(array(
            'name' => 'id',
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
            'name' => 'city',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'city'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$city_nameList,
                'disable_inarray_validator' => true,
            )
        ));
        
        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'member_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'member_id',
                'multiple'=>'multiple',
        ),
        'options' => array(
            //'label' => 'City Name',
        //'empty_option' => 'Select Organiser',
        'value_options' =>  self::$member_List,
        )
        ));

        $this->add(array(
            'name' => 'institute_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'institute_name'
            ),
            'options' => array(
                'label' => 'Institute Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'institute_type',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'institute_type'
            ),
            'options' => array(
                'label' => 'Institute Type',
            ),
        ));
        
        $this->add(array(
            'name' => 'institute_address',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'institute_address'
            ),
            'options' => array(
                'label' => 'Institute Address',
            ),
        ));
        
        $this->add(array(
            'name' => 'purpose',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'purpose'
            ),
            'options' => array(
                'label' => 'Purpose',
            ),
        ));
        
        $this->add(array(
            'name' => 'operated_by',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'operated_by'
            ),
            'options' => array(
                'label' => 'Operated By',
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
