<?php
namespace Admin\Form;

use Admin\Model\Entity\Subcommunitys;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class SubcommunityForm extends Form {
    
    public static $community_nameList = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Subcommunitys');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Subcommunitys());
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
                
        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'community_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'community_id'
        ),
        'options' => array(
            'label' => 'Religion Name',
        'empty_option' => '--Select Community Name--',
        'value_options' =>  self::$community_nameList,
        )
        ));

        $this->add(array(
            'name' => 'caste_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'caste_name'
            ),
            'options' => array(
                'label' => 'Subcommunity Name',
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
