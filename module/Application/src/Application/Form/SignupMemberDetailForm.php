<?php

namespace Application\Form;

use Application\Form\Entity\SignUpFormEntity;
use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class SignupMemberDetailForm extends Form {

    public static $countryNameList = array();
    public static $nameTitleList = array();
    public static $userTypeList = array();
    public static $gothraGothramList = array();
    public static $professionTypeList = array();
    public static $checkAlreadyExist = "/user/checkAlreadyExist";
    public static $castList=array();
    public static $religionList=[];
    protected $commonService;

    //public static $rustagi_branchList=array(); 
    public function __construct(CommonServiceInterface $commonService) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'signUpMemberDetailForm');
        $this->setAttribute('class', 'custom_error');
        $this->commonService = $commonService;
        self::$gothraGothramList = $this->commonService->getGothraList();
        self::$countryNameList = $this->commonService->getCountryList();
        self::$userTypeList = $this->commonService->getUserType();
        self::$professionTypeList = $this->commonService->getProfessionList();
        self::$nameTitleList = $this->commonService->getNameTitleList();
        //self::$castList = $this->commonService->getCastList();
        $this->setHydrator(new ClassMethods(true));
       // $this->setObject(new SignUpFormEntity());
      //  $castArray=$this->commonService->getCastList()+array('0'=>'Other');
       // $currentArray=array('Rustagi','Gupta','Rohatagi','Rustogi','Other');
        //$tableArray= array_merge($castArray, array('15'=>'Other'));
        self::$castList=array_intersect($castArray,$currentArray);
        self::$religionList = $this->commonService->getReligionList();
        //echo '<pre>';print_r(array_intersect($castArray,$currentArray));
       //\Zend\Debug\Debug::dump($tableArray);
        

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
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
                'empty_option' => 'Select Religion',
                'value_options' => self::$religionList,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'community',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'community'
            ),
            'options' => array(
                'empty_option' => 'Select Community',
                //'value_options' =>  self::$state_nameList,
                'disable_inarray_validator' => true
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'caste',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'caste'
            ),
            'options' => array(
                'empty_option' => 'Select Sub-Community/Caste',
                //'value_options' => self::$castList,
                'disable_inarray_validator' => true
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
                'empty_option' => 'Select Gothra',
                'disable_inarray_validator' => true
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'cast_other',
            'attributes' => array(
                'id' => 'cast_other',
                'placeholder' => 'Please Specify Others',
            ),
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
            'name' => 'last_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control fomrnamen',
                'id' => 'last_name',
                'placeholder' => 'Last Name'
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
            'name' => 'father_last_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control fomrnamen',
                'id' => 'father_last_name',
                'placeholder' => 'Last Name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        
        $this->add(array(
            'name' => 'father_id',
            'attributes' => array(
                'type' => 'hidden',
                'class' => 'form-control1 fomrnamen',
                'id' => 'father_id'
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
            'type' => 'text',
            'name' => 'rustagi_branch_other',
            'attributes' => array(
                'id' => 'rustagi_branch_other',
                'placeholder' => 'Please Specify Others',
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
                'onkeyup' => 'checkMemberduplicate($(this).val(),this.id,"' . self::$checkAlreadyExist . '",checkMemberDuplicateResults);',
                'class' => 'form-control1',
                'id' => 'native_place'
            ),
            'options' => array(
                'label' => NULL,
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
            'name' => 'referral_key',
            'attributes' => array(
                'type' => 'text',
                'onkeyup' => 'checkMemberduplicate($(this).val(),this.id,"' . self::$checkAlreadyExist . '",checkMemberDuplicateResults);',
                'class' => 'form-control1',
                'id' => 'referral_key'
            ),
            'options' => array(
                'label' => NULL,
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
    }

}

?>