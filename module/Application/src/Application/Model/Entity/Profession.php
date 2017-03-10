<?php

namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Profession implements InputFilterAwareInterface {

    public $id;
    public $workplace_info;
    public $office_name;
    public $office_email;
    public $office_address;
    public $office_country;
    public $office_state;
    public $office_city;
    public $office_pincode;
    public $office_phone;
    public $office_website;
    public $working_with;
    public $working_with_other;
    public $designation;
    public $designation_other;
    public $annual_income;
    public $annual_income_status;
    public $specialize_profession;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->workplace_info = (isset($data['workplace_info'])) ? $data['workplace_info'] : null;
        $this->office_name = (isset($data['office_name'])) ? $data['office_name'] : null;
        $this->office_email = (isset($data['office_email'])) ? $data['office_email'] : null;
        $this->office_address = (isset($data['office_address'])) ? $data['office_address'] : null;
        $this->office_country = (isset($data['office_country'])) ? $data['office_country'] : null;
        $this->office_state = (isset($data['office_state'])) ? $data['office_state'] : null;
        $this->office_city = (isset($data['office_city'])) ? $data['office_city'] : null;
        $this->office_pincode = (isset($data['office_pincode'])) ? $data['office_pincode'] : null;
        $this->office_phone = (isset($data['office_phone'])) ? $data['office_phone'] : null;
        $this->office_website = (isset($data['office_website'])) ? $data['office_website'] : null;
        $this->working_with = (isset($data['working_with'])) ? $data['working_with'] : null;
        $this->working_with_other = (isset($data['working_with_other'])) ? $data['working_with_other'] : null;
        $this->designation = (isset($data['designation'])) ? $data['designation'] : null;
        $this->designation_other = (isset($data['designation_other'])) ? $data['designation_other'] : null;
        $this->annual_income = (isset($data['annual_income'])) ? $data['annual_income'] : null;
        $this->annual_income_status = (isset($data['annual_income_status'])) ? $data['annual_income_status'] : null;
        $this->specialize_profession = (isset($data['specialize_profession'])) ? $data['specialize_profession'] : null;
        return $this;
    }

    public function getInputFilter() {
        //if (!$this->inputFilter) {
        $inputFilter = new InputFilter();
        $factory = new InputFactory();

        $inputFilter->add($factory->createInput(array(
                    'name' => 'id',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Int'),
                    ),
        )));

        /* $inputFilter->add($factory->createInput(array(
          'name'     => 'workplace_info',
          'required' => true,
          'filters'  => array(
          array('name' => 'StringTrim'),
          ),
          )));

          $inputFilter->add($factory->createInput(array(
          'name'     => 'designation',
          'required' => true,
          'filters'  => array(
          array('name' => 'StringTrim'),
          ),
          )));

          $inputFilter->add($factory->createInput(array(
          'name'     => 'office_address',
          'required' => true,
          'filters'  => array(
          array('name' => 'StringTrim'),
          ),
          )));
          $inputFilter->add($factory->createInput(array(
          'name'     => 'office_phone',
          'required' => true,
          'filters'  => array(
          array('name' => 'StringTrim'),
          ),
          ))); */
        $this->inputFilter = $inputFilter;
        //}

        return $this->inputFilter;
    }

    // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
