<?php
namespace Application\Form;

use Zend\Form\Form;

class MetrimoniForm extends Form { 	 
	    
		public static $gothra_nameList=array();
		public static $religion_nameList=array();
		public static $blood_group=array();
		public static $marital_status=array();
		
        public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
		$this->setAttribute('id', 'MatrimonialForm');
        $this->setAttribute('class', 'custom_error');		
		
		$this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
		$this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
		
		 
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'blood_group',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'blood_group'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$blood_group,
		)
		));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'marital_status',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'marital_status'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$marital_status,
		)
		));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'caste',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'caste'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$gothra_nameList,
		)
		));
		$this->add(array(
            'name' => 'caste_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'caste_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'religion',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'religion'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$religion_nameList,
		)
		));
		$this->add(array(
            'name' => 'religion_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control error',
                'id'=>'religion_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
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