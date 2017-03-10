<?php

namespace Application\Form;

use Application\Form\Entity\SignUpFormEntity;
use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class SignupForm extends Form {

    public static $countryNameList = array();
    public static $nameTitleList = array();
    public static $userTypeList = array();
    public static $gothraGothramList = array();
    public static $professionTypeList = array();
    public static $checkAlreadyExist = "/user/checkAlreadyExist";
    protected $commonService;

    //public static $rustagi_branchList=array(); 
    public function __construct(CommonServiceInterface $commonService) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'signUpForm');
        $this->setAttribute('class', 'custom_error');
        $this->commonService = $commonService;
        self::$gothraGothramList = $this->commonService->getGothraList();
        self::$countryNameList = $this->commonService->getCountryList();
        self::$userTypeList = $this->commonService->getUserType();
        self::$professionTypeList = $this->commonService->getProfessionList();
        self::$nameTitleList = $this->commonService->getNameTitleList();
        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new SignUpFormEntity());


        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'father_id',
            'attributes' => array(
                'type' => 'hidden',
                'id'   => 'father_id',
            ),
        ));
        
        $this->add(array(
            'name' => 'user_new_id',
            'attributes' => array(
                'type' => 'hidden',
                'id'   => 'user_new_id',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'user_type_id',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'user_type_id'
            ),
            'options' => array(
                'empty_option' => 'Please Select UserType',
                'value_options' => self::$userTypeList,
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_user',
            'attributes' => array(
                'class' => 'form-control fomrtitlen tileF',
                'id' => 'name_title_user'
            ),
            'options' => array(
                'value_options' => self::$nameTitleList,
            )
        ));

        $this->add(array(
            'name' => 'full_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control fomrnamen',
                'id' => 'full_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_father',
            'attributes' => array(
                'class' => 'form-control fomrtitlen tileF',
                'id' => 'name_title_father'
            ),
            'options' => array(
                'value_options' => array("Mr" => "Mr",
                    "Dr" => "Dr",
                    "Prof" => "Prof",
                    "Retd" => "Retd",
                    "Major" => "Major",
                    "Sh" => "Sh",
                    "Late Sh" => "Late Sh", 
                ),
            )
        ));
        $this->add(array(
            'name' => 'father_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control1 fomrnamen',
                'id' => 'father_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gender',
            'attributes' => array(
                'class' => 'form-control1',
                'id' => 'gender'
            ),
            'options' => array(
                'empty_option' => 'Please Select Your Gender',
                'value_options' => array(
                    'Male' => 'Male',
                    'Female' => 'Female'
                ),
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'address',
            'attributes' => array(
                'id' => 'address',
                'class' => 'form-control1'
            ),
            'options' => array(
                'label' => NULL,
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
                'empty_option' => 'Select Country',
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
                'empty_option' => 'Select State',
                //'value_options' =>  self::$state_nameList,
                'disable_inarray_validator' => true
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
                'empty_option' => 'Select City',
                //'value_options' =>  self::$city_nameList,
                'disable_inarray_validator' => true
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'rustagi_branch',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'rustagi_branch'
            ),
            'options' => array(
                'empty_option' => 'Select Branch',
                //'value_options' =>  self::$rustagi_branchList,
                'disable_inarray_validator' => true
            )
        ));

        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"' . self::$checkAlreadyExist . '",chkduplicateresults);',
                'class' => 'form-control',
                'id' => 'username'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'referral_key',
            'attributes' => array(
                'type' => 'text',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"' . self::$checkAlreadyExist . '",chkduplicateresults);',
                'class' => 'form-control1',
                'id' => 'referral_key'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
                'id' => 'password'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"' . self::$checkAlreadyExist . '",chkduplicateresults);',
                'class' => 'form-control',
                'id' => 'email'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'dob',
                
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'mobile_no',
            'attributes' => array(
                //'type' => 'number',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"' . self::$checkAlreadyExist . '",chkduplicateresults);',
                'class' => 'form-control error',
                'id' => 'mobile_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'profession',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'profession'
            ),
            'options' => array(
                'empty_option' => 'Please Select Profession',
                'value_options' => self::$professionTypeList,
            )
        ));

        $this->add(array(
            'name' => 'native_place',
            'attributes' => array(
                'type' => 'text',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"' . self::$checkAlreadyExist . '",chkduplicateresults);',
                'class' => 'form-control1',
                'id' => 'native_place'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));



        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gothra_gothram',
            'attributes' => array(
                'class' => 'form-control1',
                'id' => 'gothra_gothram'
            ),
            'options' => array(
                'empty_option' => 'Please Select Gothra',
                'value_options' => self::$gothraGothramList,
                 'allow_empty' => true,
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'gothra_gothram_other',
            'attributes' => array(
                'id' => 'gothra_gothram_other',
                'placeholder' => 'Please Specify Others',
            ),
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'profession_other',
            'attributes' => array(
                'id' => 'profession_other',
                'placeholder' => 'Please Specify Others',
            ),
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'rustagi_branch_other',
            'attributes' => array(
                'id' => 'rustagi_branch_other',
                'placeholder' => 'Please Specify Others',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Signup',
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