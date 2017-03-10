<?php
namespace Admin\Form;

use Admin\Model\Entity\Communitys;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class CommunityForm extends Form {
    
    public static $religion_nameList = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Communitys');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Communitys());
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
                
        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'religion_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'religion_id'
        ),
        'options' => array(
            'label' => 'Religion Name',
        'empty_option' => '--Select Religion Name--',
        'value_options' =>  self::$religion_nameList,
        )
        ));

        $this->add(array(
            'name' => 'community_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'community_name'
            ),
            'options' => array(
                'label' => 'Community Name',
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
