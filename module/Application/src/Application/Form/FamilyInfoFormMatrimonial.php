<?php

namespace Application\Form;

use Application\Model\Entity\Family;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class FamilyInfoFormMatrimonial extends Form {

    public static $Employment_status = array('1'=>'Alive','2'=>'Passed Away');
    public static $Family_Values = array();
    public static $Name_Title = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'FamilyInfoForm');
        $this->setAttribute('class', 'custom_error');
        $this->setHydrator(new ClassMethods());
        //$this->setObject(new Family());

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Radio',
//            'name' => 'marital_status',
//            'attributes' => array(
//            // 'id' => 'body_weight_type'
//            //'value' => 'yes',
//            ),
//            'options' => array(
//                'value_options' => array(
//                    array('value' => 'Never Married',
//                        'label' => 'Never Married',
//                        'attributes' => array(
//                            'class' => 'mrtlrd',
//                        ),
//                    ),
////                    array('value' => 'Married',
////                        'label' => 'Married',
////                        'attributes' => array(
////                            'class' => 'mrtlrd',
////                        ),
////                    ),
//                    array('value' => 'Divorced',
//                        'label' => 'Divorced',
//                        'attributes' => array(
//                            'class' => 'mrtlrd',
//                        ),
//                    ),
//                    array('value' => 'Separated',
//                        'label' => 'Separated',
//                        'attributes' => array(
//                            'class' => 'mrtlrd',
//                        ),
//                    )
//                ),
//            ),
//        ));

        $this->add(array(
            'name' => 'spouse_id',
            'attributes' => array(
                'type' => 'hidden',
                'id'   => 'spouse_id',
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
            'name' => 'mother_id',
            'attributes' => array(
                'type' => 'hidden',
                'id'   => 'mother_id',
                'value'=>0
            ),
        ));
   
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'family_values',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'family_values'
            ),
            'options' => array(
                'empty_option' => 'Select Family Value',
                'value_options' => self::$Family_Values,
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_spouse',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'name_title_spouse'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'spouse_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'spouse_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'spouse_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'spouse_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'spouse_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'spouse_dob',
                'value'=> '00-00-0000',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'spouse_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'spouse_photo'
            ),
        ));
        $this->add(array(
            'name' => 'spouse_dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'spouse_dod',
                'value'=> '00-00-0000',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'about_spouse',
            'attributes' => array(
                'type' => 'Textarea',
                'class' => 'form-control',
                'id' => 'about_spouse',
                'style'=>"height:50px",
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_father',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'name_title_father'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => array(
                    'Mr' => 'Mr',
                    'Dr' => 'Dr',
                    'Prof' => 'Prof',
                    'Retd' => 'Retd',
                    'Late Sh' => 'Late Sh',
                    'Sh' => 'Sh',
                    'Major' => 'Major',
                    )
            )
        ));
        $this->add(array(
            'name' => 'father_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
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
                'class' => 'form-control',
                'id' => 'father_last_name',
                'placeholder' => 'Last Name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
                
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'father_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'father_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'father_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'father_dob',
                //'readonly' => 'readonly'
                'value'=> '00-00-0000',
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'father_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'father_photo'
            ),
        ));
        $this->add(array(
            'name' => 'father_dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'father_dod',
                'value'=> '00-00-0000',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'about_father',
            'attributes' => array(
                'type' => 'Textarea',
                'class' => 'form-control',
                'id' => 'about_father',
                'style'=>"height:50px",
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_mother',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'name_title_mother'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'mother_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'mother_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'mother_last_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'mother_last_name',
                'placeholder' => 'Last Name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'mother_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'mother_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'mother_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'mother_dob',
                'value'=> '00-00-0000',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'mother_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'mother_photo'
            ),
        ));
        $this->add(array(
            'name' => 'mother_dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1 dod',
                'id' => 'mother_dod',
                'value'=> '00-00-0000',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'about_mother',
            'attributes' => array(
                'type' => 'Textarea',
                'class' => 'form-control',
                'id' => 'about_mother',
                'style'=>"height:50px",
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_grand_father',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'name_title_gFather'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'grand_father_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'grand_father_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'grand_father_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'grand_father_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'grand_father_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'grand_father_dob',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'grand_father_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'grand_father_photo'
            ),
        ));
        $this->add(array(
            'name' => 'grand_father_dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1 dod',
                'id' => 'grand_father_dod',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_grand_mother',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'name_title_g_mother'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'grand_mother_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'grand_mother_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'grand_mother_status',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'grand_mother_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'grand_mother_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'grand_mother_dob',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'grand_mother_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'grand_mother_photo'
            ),
        ));
        $this->add(array(
            'name' => 'grand_mother_dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1 dod',
                'id' => 'grand_mother_dod',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_grand_grand_father',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'name_title_g_gfather'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'grand_grand_father_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'g_grand_father_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'grand_grand_father_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'grand_grand_father_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'grand_grand_father_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'grand_grand_father_dob',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'grand_grand_father_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'grand_grand_father_photo'
            ),
        ));
        $this->add(array(
            'name' => 'grand_grand_father_dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1 dod',
                'id' => 'g_grand_father_dod',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_grand_grand_mother',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'name_title_g_gmother'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'grand_grand_mother_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'g_grand_mother_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'grand_grand_mother_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'grand_grand_mother_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'grand_grand_mother_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'g_grand_mother_dob',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'grand_grand_mother_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'g_grand_mother_photo'
            ),
        ));
        $this->add(array(
            'name' => 'grand_grand_mother_dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1 dod',
                'id' => 'g_grand_mother_dod',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
//*********spouse family elements
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'spouse_father_name_title',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'spouse_fName_title'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'spouse_father_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'spouse_fatherName'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'spouse_father_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'spouse_fatherStatus'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'spouse_father_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'spouse_fatherDOB',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'spouse_father_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'spouse_fatherPhoto'
            ),
        ));
        $this->add(array(
            'name' => 'spouse_father_died_on',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1 dod',
                'id' => 'spouse_fatherDiedOn',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'spouse_mother_name_title',
            'attributes' => array(
                'class' => 'form-control tileF',
                'id' => 'spouse_mName_title'
            ),
            'options' => array(
                //'empty_option' => '',
                'value_options' => self::$Name_Title,
            )
        ));
        $this->add(array(
            'name' => 'spouse_mother_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'spouse_motherName'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'spouse_mother_status',
            'attributes' => array(
                'class' => 'form-control status_live',
                'id' => 'spouse_motherStatus'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$Employment_status,
            )
        ));
        $this->add(array(
            'name' => 'spouse_mother_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1',
                'id' => 'spouse_motherDOB',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'spouse_mother_photo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'spouse_motherPhoto'
            ),
        ));
        $this->add(array(
            'name' => 'spouse_mother_died_on',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control datepicker1 dod',
                'id' => 'spouse_motherDiedOn',
                //'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        //***spouse family elements end here*********
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