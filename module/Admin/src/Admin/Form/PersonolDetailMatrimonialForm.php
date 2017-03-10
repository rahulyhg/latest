<?php

namespace Admin\Form;

use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class PersonolDetailMatrimonialForm extends Form {

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
    public static $casteNameList = array();
    public static $starSignNameList = array();
    public static $motherTongueNameList = array();
    public static $manglikDossamList = array();
    public static $mealPreferenceList= array();
    public static $drinkSmokeList=array();
    public static $branchNameList=array();
    public static $zodiacSignRaasiList=array();
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
        self::$casteNameList=$this->commonService->getCasteList();
        self::$starSignNameList=$this->commonService->getStarSignList();
        self::$motherTongueNameList=  $this->commonService->getMotherTongueList();
        self::$manglikDossamList= $this->commonService->getManglikDossamlist();
        self::$mealPreferenceList=  $this->commonService->getMealPreferenceList();
        self::$drinkSmokeList=  $this->commonService->getDrinkSmokeList();
        self::$branchNameList= $this->commonService->getRustagiBranchList();
        self::$zodiacSignRaasiList=$this->commonService->getZodiacSignRaasiList();
                
       
        $this->setHydrator(new ClassMethods(true));
        //$this->setObject(new UserInfo());
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        
             $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'marital_status',
            'attributes' => array(
            // 'id' => 'body_weight_type'
            //'value' => 'yes',
            ),
            'options' => array(
                'value_options' => array(
                    array('value' => 'Never Married',
                        'label' => 'Never Married',
                        'attributes' => array(
                            'class' => 'mrtlrd',
                        ),
                    ),
//                    array('value' => 'Married',
//                        'label' => 'Married',
//                        'attributes' => array(
//                            'class' => 'mrtlrd',
//                        ),
//                    ),
                    array('value' => 'Divorced',
                        'label' => 'Divorced',
                        'attributes' => array(
                            'class' => 'mrtlrd',
                        ),
                    ),
                    array('value' => 'Awaiting Divorce',
                        'label' => 'Awaiting Divorce',
                        'attributes' => array(
                            'class' => 'mrtlrd',
                        ),
                    )
                ),
            ),
        ));
        
        
        
//        $this->add(array(
//          'type' => 'Zend\Form\Element\Select',
//          'name' => 'marital_status',
//          'attributes' => array(
//          'class' => 'form-control',
//          'id'=>'marital_status'
//          ),
//          'options' => array(
//         
//          'value_options' =>  array('Never Married'=>'Never Married', 'Divorced'=>'Divorced','Awaiting Divorce'=>'Awaiting Divorce'),
//          )
//          )); 
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'children',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'children',
                'value'=>'No'
            ),
            'options' => array(
                'value_options' => array('Yes. Living together' => 'Yes. Living together', 'No' => 'No', 'Yes. Not living together' => 'Yes. Not living together'),
            )
        ));
        
        $this->add(array(
            'name' => 'no_of_kids',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'no_of_kids'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'profile_for',
            'attributes' => array(
                'id' => 'profile_for',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select User',
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
                //'empty_option' => 'Select User',
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
                //'empty_option' => 'Select Gender',
                'value_options' => self::$gender,
            )
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
            'type' => 'Zend\Form\Element\Select',
            'name' => 'age',
            'attributes' => array(
                'id' => 'age',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select Age',
                'value_options' => self::$ageList,
            )
        ));
        
        $this->add(array(
            'name' => 'birth_time',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control timepicker1',
                'id' => 'birth_time'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'birth_place',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'birth_place'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'mother_tongue_id',
            'attributes' => array(
                'id' => 'mother_tongue_id',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select Mother Tongue',
                'value_options' => self::$motherTongueNameList,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'star_sign',
            'attributes' => array(
                'id' => 'star_sign',
                'class' => 'form-control'
            ),
            'options' => array(
                'empty_option' => 'Select Nakshtra',
                'value_options' => self::$starSignNameList,
                'is_empty' => false,
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
                //'empty_option' => 'Select',
                'value_options' => self::$bloodGroup,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'zodiac_sign_raasi',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'zodiac_sign_raasi'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$zodiacSignRaasiList,
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
                //'empty_option' => 'Select',
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
                'empty_option' => 'Select Height',
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
                //'empty_option' => 'Select Body Type',
                'value_options' => self::$bodyType,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'caste',
            'attributes' => array(
                'id' => 'caste',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select Caste',
                'value_options' => self::$casteNameList,
            )
        ));
        
        $this->add(array(
            'name' => 'sub_caste',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'sub_caste'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'manglik_dossam',
            'attributes' => array(
                'id' => 'manglik_dossam',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select',
                'value_options' => self::$manglikDossamList,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'meal_preference',
            'attributes' => array(
                'id' => 'meal_preference',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select',
                'value_options' => self::$mealPreferenceList,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'drink',
            'attributes' => array(
                'id' => 'drink',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select',
                'value_options' => self::$drinkSmokeList,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'smoke',
            'attributes' => array(
                'id' => 'smoke',
                'class' => 'form-control'
            ),
            'options' => array(
                //'empty_option' => 'Select',
                'value_options' => self::$drinkSmokeList,
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
                //'empty_option' => 'Select Skin Tone',
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
                //'empty_option' => 'Are you Disabled',
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
            'name' => 'body_weight',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'body_weight'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
        'type' => 'Zend\Form\Element\Radio',
        'name' => 'body_weight_type',
        'attributes' => array(
               // 'id' => 'body_weight_type'
                  //'value' => 'yes',
            ),
        'options' => array(
            'value_options' => array(
                'kgs' => 'kgs',
                'lbs' => 'lbs',
            ),
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
        
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Select',
//            'name' => 'branch_ids',
//            'attributes' => array(
//                'class' => 'form-control',
//                'id' => 'branch_ids'
//            ),
//            'options' => array(
//                'empty_option' => 'Select',
//                'value_options' => self::$branchNameList,
//                'disable_inarray_validator' => true,
//            )
//        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'branch_ids_other',
            'attributes' => array(
                'id' => 'branch_ids_other',
                'placeholder' => 'Please Specify Others',
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