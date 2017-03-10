<?php
namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;    
use Zend\InputFilter\InputFilter;                
use Zend\InputFilter\InputFilterAwareInterface;  
use Zend\InputFilter\InputFilterInterface;       

class Matrimoni implements InputFilterAwareInterface
{
    public $id;	
	public $user_id;	
	public $blood_group; 
	public $marital_status;
	public $caste;    
    public $caste_other;   
	public $religion;
	public $religion_other;
	 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
  		$this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
  		$this->blood_group = (isset($data['blood_group'])) ? $data['blood_group'] : null;       
		$this->marital_status = (isset($data['marital_status'])) ? $data['marital_status'] : null;
        $this->caste = (isset($data['caste'])) ? $data['caste'] : null;
        $this->caste_other = (isset($data['caste_other'])) ? $data['caste_other'] : null;
        $this->religion = (isset($data['religion'])) ? $data['religion'] : null;
		$this->religion_other     = (isset($data['religion_other']))     ? $data['religion_other']     : null;
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
                'name'     => 'user_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
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