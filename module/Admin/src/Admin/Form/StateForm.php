<?php
namespace Admin\Form;

use Admin\Model\Entity\States;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class StateForm extends Form {

    public static $country_nameList = array();
    public static $actionName = "";


    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('States');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new States());
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

         $this->add(array(
            'name' => 'master_state_id',
            'type' => 'Hidden',
            'attributes' => array(
                'id'=>'master_state_id'
            ),
        ));

        $this->add(array(
            'name' => 'state_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                //'onkeyup' => 'keyupresults($(this).val(),searchboxresults,$(this).parent().attr("Cname"),"'.self::$actionName.'")',
                'id'=>'state_name',
                'size'=>"20"
            ),
            'options' => array(
                'label' => 'State Name',
            ),
        ));

        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'country_id',
        'attributes' => array(
                'class' => 'form-control',
                //'onchange' => 'keyupresults($(this).val(),searchboxresults,$(this).parent().attr("id"),"' . self::$actionName . '")',
                'id'=>'country_id',
                

        ),
        'options' => array(
            'label' => 'Country Name',
        'empty_option' => 'Please Select Country Name',
        'value_options' =>  self::$country_nameList,
        )
        ));
        
        $this->add(array(
            'name' => 'state_code',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'state_code'
            ),
            'options' => array(
                'label' => 'State Code',
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