<?php
namespace Admin\Form;

use Admin\Model\Entity\Sponsermasters;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class SponsermasterForm extends Form {
    
    public static $designation_nameList = array();
    public static $country_nameList = array();
    public static $state_nameList = array();
    public static $city_nameList = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Sponsermasters');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Sponsermasters());
        	
		$this->add(array(
            'name' => 'spons_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'spons_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'spons_name'
            ),
            'options' => array(
                'label' => 'Sponser Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'spons_poc_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'spons_poc_name'
            ),
            'options' => array(
                'label' => 'Sponser Poc Name',
            ),
        ));
        
//        $this->add(array(
//            'name' => 'spons_desig',
//            'attributes' => array(
//                'type' => 'text',
//                'class' => 'form-control',
//                'id'=>'spons_desig'
//            ),
//            'options' => array(
//                'label' => 'Sponser Designation',
//            ),
//        ));
        
        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'spons_desig_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'spons_desig_id'
        ),
        'options' => array(
            'label' => 'Sponser Designation',
        'empty_option' => '--Please Select--',
        'value_options' =>  self::$designation_nameList,
        )
        ));
        
        $this->add(array(
            'name' => 'spons_phone_no',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'spons_phone_no'
            ),
            'options' => array(
                'label' => 'Sponser Contact',
            ),
        ));
        
        $this->add(array(
            'name' => 'spons_alt_phone_no',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'spons_alt_phone_no'
            ),
            'options' => array(
                'label' => 'Sponser Alt Contact',
            ),
        ));
        
         $this->add(array(
            'name' => 'spons_image',
            'attributes' => array(
                'type' => 'file',
                'class' => 'thisnot',
                'id'=>'image'
            ),
            'options' => array(
                'label' => 'Sponser Photo',
            ),
        ));
         
         $this->add(array(
        'type' => 'Hidden',
        'name' => 'spons_desc',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'spons_desc'
        ),
        'options' => array(
            'label' => 'Sponser Description',
        )
        ));
         
         $this->add(array(
            'name' => 'spons_email',
            'attributes' => array(
                'type' => 'email',
                'class' => 'form-control',
                'id'=>'spons_email'
            ),
            'options' => array(
                'label' => 'Sponser Email',
            ),
        ));
         
         $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'spons_country',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'spons_country'
        ),
        'options' => array(
            'label' => 'Country Name',
        'empty_option' => '--Please Select Country--',
        'value_options' =>  self::$country_nameList,
        )
        ));
         
         $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'spons_state',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'spons_state'
        ),
        'options' => array(
            'label' => 'State Name',
        'empty_option' => '--Please Select State--',
        'value_options' =>  self::$state_nameList,
        )
        ));
         
         $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'spons_city',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'spons_city'
        ),
        'options' => array(
            'label' => 'City Name',
        'empty_option' => '--Please Select City--',
        'value_options' =>  self::$city_nameList,
        )
        ));
         
         $this->add(array(
        'type' => 'textarea',
        'name' => 'spons_address',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'spons_address'
        ),
        'options' => array(
            'label' => 'Sponser Address',
        )
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
