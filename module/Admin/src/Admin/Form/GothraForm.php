<?php
namespace Admin\Form;

use Admin\Model\Entity\Gothras;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class GothraForm extends Form {
    
    public static $caste_nameList = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Gothras');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Gothras());
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
                
        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'caste_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'caste_id'
        ),
        'options' => array(
            'label' => 'Cast Name',
        'empty_option' => '--Select Cast Name--',
        'value_options' =>  self::$caste_nameList,
        )
        ));

        $this->add(array(
            'name' => 'gothra_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'gothra_name'
            ),
            'options' => array(
                'label' => 'Gothra Name',
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
        'empty_option'=> 'Please Select Status',    
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
