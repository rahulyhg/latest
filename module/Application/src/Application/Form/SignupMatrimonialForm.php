<?php

namespace Application\Form;

use Application\Form\Entity\SignUpFormEntity;
use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class SignupMatrimonialForm extends Form {

    public static $nameTitleList = array();
    public static $checkAlreadyExist = "/user/checkAlreadyExistUserMatrimonial";
    protected $commonService;

    public function __construct(CommonServiceInterface $commonService) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'signupMatrimonialForm');
        $this->setAttribute('class', 'custom_error');
        $this->commonService = $commonService;
        self::$nameTitleList = $this->commonService->getNameTitleList();
        $this->setHydrator(new ClassMethods(true));
        //$this->setObject(new SignUpFormEntity());


        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        
     
      


        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
                'onkeyup' => 'chkduplicateMatrimonial($(this).val(),this.id, "' . self::$checkAlreadyExist . '");',
                'class' => 'form-control',
                'id' => 'username'
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
                'onkeyup' => 'chkduplicateMatrimonial($(this).val(),this.id, "' . self::$checkAlreadyExist . '");',
                'class' => 'form-control',
                'id' => 'email'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
      

        $this->add(array(
            'name' => 'mobile_no',
            'attributes' => array(
                //'type' => 'number',
                'onkeyup' => 'chkduplicateMatrimonial($(this).val(),this.id, "' . self::$checkAlreadyExist . '");',
                'class' => 'form-control error',
                'id' => 'mobile_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

      
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'id' => 'submitButton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

}

?>