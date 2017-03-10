<?php

namespace Admin\Form;

use Admin\Model\Entity\Userinfo;
use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class LocationDetailForm extends Form {


    public static $countryNameList = array();
    public static $stateNameList = array();
    public static $cityNameList = array();

    public static $countryNameList2 = array();
    public static $stateNameList2 = array();
    public static $cityNameList2 = array();

    protected $commonService;

    public function __construct(CommonServiceInterface $commonService) {
        // we want to ignore the name passed
        parent::__construct('memberbasicform');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'Memberbasicform');
        $this->setAttribute('class', 'custom_error');
        //$this->setAttribute('action', 'EditPersonalInfo');
        $this->commonService=$commonService;

        self::$countryNameList=$this->commonService->getCountryList();
        self::$stateNameList=$this->commonService->getStateList();
        self::$cityNameList=$this->commonService->getCityList();
       
        self::$countryNameList2=$this->commonService->getCountryList();
        self::$stateNameList2=$this->commonService->getStateList();
        self::$cityNameList2=$this->commonService->getCityList();
       
        
        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new Userinfo());
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
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
                'value_options' => self::$countryNameList,
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
                'value_options' => self::$stateNameList,
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
                'value_options' => self::$cityNameList,
                'disable_inarray_validator' => true,
            )
        ));
        
        $this->add(array(
            'name' => 'address',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'address'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        
        $this->add(array(
            'name' => 'zip_pin_code',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'zip_pin_code'
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
                'id' => 'office_name'
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
                'id' => 'office_email'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'native_place',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'native_place'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'office_address',
            'attributes' => array(
                'id' => 'office_address',
                'class' => 'form-control',
                'cols' => 25,
                'rows' => 2
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
                'id' => 'office_country'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$countryNameList2,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'office_state',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'office_state'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$stateNameList2,
                'disable_inarray_validator' => true,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'office_city',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'office_city'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$cityNameList2,
                'disable_inarray_validator' => true,
            )
        ));
        
        $this->add(array(
            'name' => 'office_pincode',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'office_pincode'
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
                'id' => 'office_phone'
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
                'id' => 'office_website'
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
//        $this->add(array(
//            'name' => 'cancel',
//            'attributes' => array(
//                'type' => 'reset',
//                'value' => 'Cancel',
//                'id' => 'cancelButton',
//                'class' => 'btn btn-primary'
//            ),
//        ));
    }

}

?>