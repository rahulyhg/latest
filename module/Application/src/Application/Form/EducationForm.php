<?php

namespace Application\Form;

use Application\Model\Entity\UserInfo;
use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class EducationForm extends Form {

    public static $educationLevelList = array();
    public static $educationFieldList = array();
    public static $professionTypeList = array();
    public static $EmploymentStatus = array();
    protected $commonService;

    public function __construct(CommonServiceInterface $commonService) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'EducationForm');
        $this->setAttribute('class', 'custom_error');
        /* $this->setAttribute('action', 'EditEducationInfo'); */
         $this->commonService=$commonService;
        self::$educationLevelList=$this->commonService->getEducationLevelList();
        self::$educationFieldList=$this->commonService->getEducationFieldList();
        self::$professionTypeList=$this->commonService->getProfessionList();
        self::$EmploymentStatus=$this->commonService->getEmploymentStatusList();
        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new UserInfo());
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'education_level',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'education_level'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$educationLevelList,
            )
        ));

        $this->add(array(
            'name' => 'education_level_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'education_level_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'education_field',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'education_field'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$educationFieldList,
            )
        ));
        $this->add(array(
            'name' => 'education_field_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'education_field_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'employment_status',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'employment_status'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$EmploymentStatus,
            )
        ));
        $this->add(array(
            'name' => 'employment_status_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'employment_status_other'
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
                'empty_option' => 'Select',
                'value_options' => self::$professionTypeList,
            )
        ));
        $this->add(array(
            'name' => 'profession_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'profession_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'name' => 'specialization_major',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'specialization_major'
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