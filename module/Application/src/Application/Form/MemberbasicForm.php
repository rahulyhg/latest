<?php

namespace Application\Form;

use Application\Model\Entity\PersonalDetails;
use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class MemberbasicForm extends Form {

    public static $gothraNameList = array();
    public static $religionNameList = array();
    public static $bloodGroup = array();
    public static $maritalStatus = array();
    public static $countryNameList = array();
    public static $stateNameList = array();
    public static $cityNameList = array();
    public static $heightList = array();
    public static $ageList = array();
    public static $nameTitle = array();
    public static $gender = array();
    public static $disability = array();
    public static $profileFor = array();
    public static $bodyType = array();
    public static $skinTone = array();
    protected $commonService;

    public function __construct(CommonServiceInterface $commonService) {
        // we want to ignore the name passed
        parent::__construct('memberbasicform');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'MemberbasicForm');
        $this->setAttribute('class', 'custom_error');
        //$this->setAttribute('action', 'EditPersonalInfo');
        $this->commonService=$commonService;
        self::$gothraNameList=$this->commonService->getGothraList();
        self::$religionNameList=$this->commonService->getReligionList();
        self::$bloodGroup=$this->commonService->getBloodGroupList();
        self::$maritalStatus=$this->commonService->getMeritalStatusList();
        self::$countryNameList=$this->commonService->getCountryList();
        self::$stateNameList=$this->commonService->getStateList();
        self::$cityNameList=$this->commonService->getCityList();
        self::$heightList=$this->commonService->getHeightList();
        self::$ageList=$this->commonService->getAge();
        self::$nameTitle=$this->commonService->getNameTitleList();
        self::$gender=$this->commonService->genderList();
        self::$disability=$this->commonService->disabilityList();
        self::$profileFor=$this->commonService->profileForList();
        self::$bodyType=$this->commonService->bodyTypeList();
        self::$skinTone=$this->commonService->skinToneList();
                
       
        //$this->setHydrator(new ClassMethods(true));
        //$this->setObject(new PersonalDetails());
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        /* $this->add(array(
          'type' => 'Zend\Form\Element\Select',
          'name' => 'marital_status',
          'attributes' => array(
          'class' => 'form-control',
          'id'=>'marital_status'
          ),
          'options' => array(
          'empty_option' => 'Select',
          'value_options' =>  self::$maritalStatus,
          )
          )); */
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'profile_for',
            'attributes' => array(
                'id' => 'profile_for',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Select User',
                'value_options' => self::$profileFor,
            )
        ));
        $this->add(array(
            'name' => 'profile_for_others',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'profile_for_others'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_user',
            'attributes' => array(
                'id' => 'name_title_user',
                'class' => 'form-control tileF'
            ),
            'options' => array(
                'empty_option' => 'Select User',
                'value_options' => self::$nameTitle,
            )
        ));
        $this->add(array(
            'name' => 'full_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'full_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'name' => 'alternate_mobile_no',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'alternate_mobile_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'name' => 'phone_no',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'phone_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gender',
            'attributes' => array(
                'id' => 'gender',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Select Your Gender',
                'value_options' => self::$gender,
            )
        ));
        $this->add(array(
            'name' => 'dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control inputDate',
                'id' => 'dob',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'age',
            'attributes' => array(
                'id' => 'age',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Select Your Age',
                'value_options' => self::$ageList,
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'blood_group',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'blood_group'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$bloodGroup,
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gothra_gothram',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'gothra_gothram'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$gothraNameList,
            )
        ));
        $this->add(array(
            'name' => 'gothra_gothram_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'gothra_gothram_other'
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
                'id' => 'religion'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$religionNameList,
            )
        ));
        $this->add(array(
            'name' => 'religion_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control error',
                'id' => 'religion_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'height',
            'attributes' => array(
                'id' => 'height',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Select Your Height',
                'value_options' => self::$heightList,
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'body_type',
            'attributes' => array(
                'id' => 'body_type',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Select Your Body Type',
                'value_options' => self::$bodyType,
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'color_complexion',
            'attributes' => array(
                'id' => 'color_complexion',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Select Skin Tone',
                'value_options' => self::$skinTone,
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'any_disability',
            'attributes' => array(
                'id' => 'any_disability',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Are you Disabled',
                'value_options' => self::$disability,
            )
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
            'name' => 'address_line2',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'address_line2'
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