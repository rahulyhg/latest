<?php
namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;    
use Zend\InputFilter\InputFilter;                
use Zend\InputFilter\InputFilterAwareInterface;  
use Zend\InputFilter\InputFilterInterface;       

class Contact implements InputFilterAwareInterface
{
    public $id;
    public $name;
	public $email;
    public $phone_no;
	public $message;   
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->name = (isset($data['name'])) ? $data['name'] : null; 
  		$this->email = (isset($data['email'])) ? $data['email'] : null;
		$this->phone_no = (isset($data['phone_no'])) ? $data['phone_no'] : null; 
  		$this->message = (isset($data['message'])) ? $data['message'] : null;    
        return $this;
    }
    public function getInputFilter()
    {
        //if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ))); 
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            ))); 
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'phone_no',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'message',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            ))); 
            
            $this->inputFilter = $inputFilter;
        //}

        return $this->inputFilter;
    }
     // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}