<?php
namespace Application\Form;

use Zend\Form\Form;

class CareerForm extends Form { 
	 
	    public static $professionTypeList=array();
		public static $country_nameList=array();
		public static $state_nameList=array();
		public static $city_nameList=array();
		public static $annual_incomeList=array();       
		public static $Employment_status=array();
		public static $designationList=array();
		public static $workingWith=array();
        public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
		$this->setAttribute('id', 'CareerForm');
        $this->setAttribute('class', 'custom_error');		
		$this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));	
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'employment_status',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'employment_status'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$Employment_status,
		)
		));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'profession',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'profession'
        ),
		'options' => array(
		'empty_option' => 'Please Select Profession',
		'value_options' =>  self::$professionTypeList,
		)
		));
		$this->add(array(
            'name' => 'workplace_info',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control error',
                'id'=>'workplace_info'
            ),
            'options' => array(
                'label' => NULL,
            ),
        )); 
		$this->add(array(
            'name' => 'office_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'office_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'specialize_profession',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'specialize_profession'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
            'name' => 'office_email',
            'attributes' => array(
                'type' => 'email',
                'class' => 'form-control',
                'id'=>'office_email'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'office_address',
            'attributes' => array(                
                'id'=>'office_address',
				'class'=>'form-control',
				'cols'=>25,
				'rows'=>2
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'office_country',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'office_country'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$country_nameList,
		)
		));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'office_state',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'office_state'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$state_nameList,
		'disable_inarray_validator' => true,
		)
		));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'office_city',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'office_city'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$city_nameList,
		'disable_inarray_validator' => true,
		)
		));
		$this->add(array(
            'name' => 'office_pincode',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'office_pincode'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
            'name' => 'office_phone',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'office_phone'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
            'name' => 'office_website',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'office_website'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'working_with',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'working_with'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$workingWith,
		)
		));
		$this->add(array(
            'name' => 'working_with_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control error',
                'id'=>'working_with_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        )); 
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'designation',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'designation'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$designationList,
		)
		));
		$this->add(array(
            'name' => 'designation_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control error',
                'id'=>'designation_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        )); 
		$this->add(array(
            'name' => 'annual_income',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'annual_income'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		/* $this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'annual_income',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'annual_income'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$annual_incomeList,
		)
		)); */
		
		$this->add(array(
		'type' => 'Zend\Form\Element\Checkbox',
		'name' => 'annual_income_status',
		'attributes' => array(
                'class' => 'incomecbx',
                'id'=>'annual_income_status'
        )
		));
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submit',
                'class' => 'btn btn-default'
            ),
        ));    
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Cancel',
                'id' => 'cancelButton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

}
?>