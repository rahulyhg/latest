<?php
namespace Application\Form;

use Zend\Form\Form;

class ContactForm extends Form {
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
		$this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
				
		$this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'class' => 'form-control',
                'id'=>'email'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
            'name' => 'phone_no',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'id'=>'phone_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        )); 
		
		$this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'message',
            'attributes' => array(                
                'id'=>'message',
				'class'=>'form-control',
				'cols'=>25,
				'rows'=>4
            ),
            'options' => array(
                'label' => NULL,
            ),
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
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Cancel',
                'id' => 'cancelButton',
                'class' => 'btn btn-default'
            ),
        ));
    }

}
?>