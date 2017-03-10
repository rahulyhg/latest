<?php

namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Education{

    public $id;
    public $education_level;
    public $education_level_other;
    public $education_field;
    public $education_field_other;
    public $specialization_major;
    public $employment_status;
    public $employment_status_other;
    public $profession;
    public $profession_other;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->education_level = (isset($data['education_level'])) ? $data['education_level'] : null;
        $this->education_level_other = (isset($data['education_level_other'])) ? $data['education_level_other'] : null;
        $this->education_field = (isset($data['education_field'])) ? $data['education_field'] : null;
        $this->education_field_other = (isset($data['education_field_other'])) ? $data['education_field_other'] : null;
        $this->specialization_major = (isset($data['specialization_major'])) ? $data['specialization_major'] : null;
        $this->employment_status = (isset($data['employment_status'])) ? $data['employment_status'] : null;
        $this->employment_status_other = (isset($data['employment_status_other'])) ? $data['employment_status_other'] : null;
        $this->profession = (isset($data['profession'])) ? $data['profession'] : null;
        $this->profession_other = (isset($data['profession_other'])) ? $data['profession_other'] : null;
        return $this;
    }
    
     public function exchangeArrayTable($data) {
        //left is table field and right is form field
        $educationData['id'] = (null !== $data->id) ? $data->id : null;
        $educationData['education_level'] = (null !== $data->education_level) ? $data->education_level : null;
        $educationData['education_level_other'] = (null !== $data->education_level_other) ? $data->education_level_other : null;
        $educationData['education_field'] = (null !== $data->education_field) ? $data->education_field : null;
        $educationData['education_field_other'] = (null !== $data->education_field_other) ? $data->education_field_other : null;
        $educationData['specialization_major'] = (null !== $data->specialization_major) ? $data->specialization_major : null;
        $educationData['employment_status'] = (null !== $data->employment_status) ? $data->employment_status : null;
        $educationData['employment_status_other'] = (null !== $data->employment_status_other) ? $data->employment_status_other : null;
        $educationData['profession'] = (null !== $data->profession) ? $data->profession : null;
        $educationData['profession_other'] = (null !== $data->profession_other) ? $data->profession_other : null;

        return $educationData;

    }

    public function exchangeArrayView($data) {
         //left is display field and right is table field
        $data['id'] = (isset($data['id'])) ? $data['id'] : null;
        $data['education_level'] = (isset($data['education_level'])) ? $data['education_level'] : null;
        $data['education_level_other'] = (isset($data['education_level_other'])) ? $data['education_level_other'] : null;
        $data['education_field'] = (isset($data['education_field'])) ? $data['education_field'] : null;
        $data['education_field_other'] = (isset($data['education_field_other'])) ? $data['education_field_other'] : null;
        $data['specialization_major'] = (isset($data['specialization_major'])) ? $data['specialization_major'] : null;
        $data['employment_status'] = (isset($data['employment_status'])) ? $data['employment_status'] : null;
        $data['employment_status_other'] = (isset($data['employment_status_other'])) ? $data['employment_status_other'] : null;
        $data['profession'] = (isset($data['profession'])) ? $data['profession'] : null;
        $data['profession_other'] = (isset($data['profession_other'])) ? $data['profession_other'] : null;

        return $data;

    }

   

   

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
