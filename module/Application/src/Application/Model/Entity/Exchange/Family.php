<?php

namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Family implements InputFilterAwareInterface {

    public $id;
    public $user_id;
    public $family_values;
    public $name_title_spouse;
    public $spouse_name;
    public $spouse_last_name;
    public $spouse_status;
    public $spouse_dob;
    public $spouse_photo;
    public $spouse_died_on;
    public $name_title_father;
    public $father_name;
    public $father_last_name;
    public $father_status;
    public $father_dob;
    public $father_photo;
    public $father_dod;
    public $name_title_mother;
    public $mother_name;
    public $mother_last_name;
    public $mother_status;
    public $mother_dob;
    public $mother_photo;
    public $mother_dod;
    public $name_title_g_father;
    public $grand_father_name;
    public $grand_father_last_name;
    public $grand_father_status;
    public $grand_father_dob;
    public $grand_father_photo;
    public $grand_father_dod;
    public $name_title_g_mother;
    public $grand_mother_name;
    public $grand_mother_last_name;
    public $grand_mother_status;
    public $grand_mother_dob;
    public $grand_mother_photo;
    public $grand_mother_dod;
    public $name_title_g_gfather;
    public $g_grand_father_name;
    public $g_grand_father_last_name;
    public $g_grand_father_status;
    public $g_grand_father_dob;
    public $g_grand_father_photo;
    public $g_grand_father_dod;
    public $name_title_g_gmother;
    public $g_grand_mother_name;
    public $g_grand_mother_last_name;
    public $g_grand_mother_status;
    public $g_grand_mother_dob;
    public $g_grand_mother_photo;
    public $g_grand_mother_dod;
    public $spouse_fName_title;
    public $spouse_fatherName;
    public $spouse_father_last_name;
    public $spouse_fatherStatus;
    public $spouse_fatherDOB;
    public $spouse_fatherPhoto;
    public $spouse_fatherDiedOn;
    public $spouse_mName_title;
    public $spouse_motherName;
    public $spouse_mother_last_name;
    public $spouse_motherStatus;
    public $spouse_motherDOB;
    public $spouse_motherPhoto;
    public $spouse_motherDiedOn;
    public $name_title_kids;
    public $kids_name;
    public $kids_last_name;
    public $kids_status;
    public $kids_dob;
    public $kids_photo;
    public $name_title_brother;
    public $brother_name;
    public $brother_last_name;
    public $brother_status;
    public $brother_dob;
    public $brother_photo;
    public $name_title_sister;
    public $sister_name;
    public $sister_last_name;
    public $sister_status;
    public $sister_dob;
    public $sister_photo;
    public $name_title_S_sister;
    public $S_sister_name;
    public $spouse_sister_last_name;
    public $S_sister_status;
    public $S_sister_dob;
    public $S_sister_photo;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->family_values = (isset($data['family_values'])) ? $data['family_values'] : null;
        $this->name_title_spouse = (isset($data['name_title_spouse'])) ? $data['name_title_spouse'] : null;
        $this->spouse_name = (isset($data['spouse_name'])) ? $data['spouse_name'] : null;
        $this->spouse_last_name = (isset($data['spouse_last_name'])) ? $data['spouse_last_name'] : null;
        $this->spouse_status = (isset($data['spouse_status'])) ? $data['spouse_status'] : null;
        $this->spouse_dob = (isset($data['spouse_dob'])) ? $data['spouse_dob'] : null;
        $this->spouse_photo = (isset($data['spouse_photo'])) ? $data['spouse_photo'] : null;
        $this->spouse_died_on = (isset($data['spouse_died_on'])) ? $data['spouse_died_on'] : null;
        $this->name_title_father = (isset($data['name_title_father'])) ? $data['name_title_father'] : null;
        $this->father_name = (isset($data['father_name'])) ? $data['father_name'] : null;
        $this->father_last_name = (isset($data['father_last_name'])) ? $data['father_last_name'] : null;
        $this->father_status = (isset($data['father_status'])) ? $data['father_status'] : null;
        $this->father_dob = (isset($data['father_dob'])) ? $data['father_dob'] : null;
        $this->father_photo = (isset($data['father_photo'])) ? $data['father_photo'] : null;
        $this->father_dod = (isset($data['father_dod'])) ? $data['father_dod'] : null;
        $this->name_title_mother = (isset($data['name_title_mother'])) ? $data['name_title_mother'] : null;
        $this->mother_name = (isset($data['mother_name'])) ? $data['mother_name'] : null;
        $this->mother_last_name = (isset($data['mother_last_name'])) ? $data['mother_last_name'] : null;
        $this->mother_status = (isset($data['mother_status'])) ? $data['mother_status'] : null;
        $this->mother_dob = (isset($data['mother_dob'])) ? $data['mother_dob'] : null;
        $this->mother_photo = (isset($data['mother_photo'])) ? $data['mother_photo'] : null;
        $this->mother_dod = (isset($data['mother_dod'])) ? $data['mother_dod'] : null;
        $this->name_title_g_father = (isset($data['name_title_g_father'])) ? $data['name_title_g_father'] : null;
        $this->grand_father_name = (isset($data['grand_father_name'])) ? $data['grand_father_name'] : null;
        $this->grand_father_last_name = (isset($data['grand_father_last_name'])) ? $data['grand_father_last_name'] : null;
        $this->grand_father_status = (isset($data['grand_father_status'])) ? $data['grand_father_status'] : null;
        $this->grand_father_dob = (isset($data['grand_father_dob'])) ? $data['grand_father_dob'] : null;
        $this->grand_father_photo = (isset($data['grand_father_photo'])) ? $data['grand_father_photo'] : null;
        $this->grand_father_dod = (isset($data['grand_father_dod'])) ? $data['grand_father_dod'] : null;
        $this->name_title_g_mother = (isset($data['name_title_g_mother'])) ? $data['name_title_g_mother'] : null;
        $this->grand_mother_name = (isset($data['grand_mother_name'])) ? $data['grand_mother_name'] : null;
        $this->grand_mother_name = (isset($data['grand_mother_last_name'])) ? $data['grand_mother_last_name'] : null;
        $this->grand_mother_status = (isset($data['grand_mother_status'])) ? $data['grand_mother_status'] : null;
        $this->grand_mother_dob = (isset($data['grand_mother_dob'])) ? $data['grand_mother_dob'] : null;
        $this->grand_mother_photo = (isset($data['grand_mother_photo'])) ? $data['grand_mother_photo'] : null;
        $this->grand_mother_dod = (isset($data['grand_mother_dod'])) ? $data['grand_mother_dod'] : null;
        $this->name_title_g_gfather = (isset($data['name_title_g_gfather'])) ? $data['name_title_g_gfather'] : null;
        $this->g_grand_father_name = (isset($data['g_grand_father_name'])) ? $data['g_grand_father_name'] : null;
        $this->g_grand_father_last_name = (isset($data['g_grand_father_last_name'])) ? $data['g_grand_father_last_name'] : null;
        $this->g_grand_father_status = (isset($data['g_grand_father_status'])) ? $data['g_grand_father_status'] : null;
        $this->g_grand_father_dob = (isset($data['g_grand_father_dob'])) ? $data['g_grand_father_dob'] : null;
        $this->g_grand_father_photo = (isset($data['g_grand_father_photo'])) ? $data['g_grand_father_photo'] : null;
        $this->g_grand_father_dod = (isset($data['g_grand_father_dod'])) ? $data['g_grand_father_dod'] : null;
        $this->name_title_g_gmother = (isset($data['name_title_g_gmother'])) ? $data['name_title_g_gmother'] : null;
        $this->g_grand_mother_name = (isset($data['g_grand_mother_name'])) ? $data['g_grand_mother_name'] : null;
        $this->g_grand_mother_last_name = (isset($data['g_grand_mother_last_name'])) ? $data['g_grand_mother_last_name'] : null;
        $this->g_grand_mother_status = (isset($data['g_grand_mother_status'])) ? $data['g_grand_mother_status'] : null;
        $this->g_grand_mother_dob = (isset($data['g_grand_mother_dob'])) ? $data['g_grand_mother_dob'] : null;
        $this->g_grand_mother_photo = (isset($data['g_grand_mother_photo'])) ? $data['g_grand_mother_photo'] : null;
        $this->g_grand_mother_dod = (isset($data['g_grand_mother_dod'])) ? $data['g_grand_mother_dod'] : null;
        $this->spouse_fName_title = (isset($data['spouse_fName_title'])) ? $data['spouse_fName_title'] : null;
        $this->spouse_fatherName = (isset($data['spouse_fatherName'])) ? $data['spouse_fatherName'] : null;
        $this->spouse_father_last_name = (isset($data['spouse_father_last_name'])) ? $data['spouse_father_last_ame'] : null;
        $this->spouse_fatherStatus = (isset($data['spouse_fatherStatus'])) ? $data['spouse_fatherStatus'] : null;
        $this->spouse_fatherDOB = (isset($data['spouse_fatherDOB'])) ? $data['spouse_fatherDOB'] : null;
        $this->spouse_fatherPhoto = (isset($data['spouse_fatherPhoto'])) ? $data['spouse_fatherPhoto'] : null;
        $this->spouse_fatherDiedOn = (isset($data['spouse_fatherDiedOn'])) ? $data['spouse_fatherDiedOn'] : null;
        $this->spouse_mName_title = (isset($data['spouse_mName_title'])) ? $data['spouse_mName_title'] : null;
        $this->spouse_motherName = (isset($data['spouse_motherName'])) ? $data['spouse_motherName'] : null;
        $this->spouse_mother_last_name = (isset($data['spouse_mother_last_name'])) ? $data['spouse_mother_last_name'] : null;
        $this->spouse_motherStatus = (isset($data['spouse_motherStatus'])) ? $data['spouse_motherStatus'] : null;
        $this->spouse_motherDOB = (isset($data['spouse_motherDOB'])) ? $data['spouse_motherDOB'] : null;
        $this->spouse_motherPhoto = (isset($data['spouse_motherPhoto'])) ? $data['spouse_motherPhoto'] : null;
        $this->spouse_motherDiedOn = (isset($data['spouse_motherDiedOn'])) ? $data['spouse_motherDiedOn'] : null;

        $this->name_title_brother = (isset($data['name_title_brother'])) ? $data['name_title_brother'] : null;
        $this->brother_name = (isset($data['brother_name'])) ? $data['brother_name'] : null;
        $this->brother_last_name = (isset($data['brother_last_name'])) ? $data['brother_last_name'] : null;
        $this->brother_status = (isset($data['brother_status'])) ? $data['brother_status'] : null;
        $this->brother_dob = (isset($data['brother_dob'])) ? $data['brother_dob'] : null;
        $this->brother_photo = (isset($data['brother_photo'])) ? $data['brother_photo'] : null;

        $this->name_title_sister = (isset($data['name_title_sister'])) ? $data['name_title_sister'] : null;
        $this->sister_name = (isset($data['sister_name'])) ? $data['sister_name'] : null;
        $this->sister_last_name = (isset($data['sister_last_name'])) ? $data['sister_last_name'] : null;
        $this->sister_status = (isset($data['sister_status'])) ? $data['sister_status'] : null;
        $this->sister_dob = (isset($data['sister_dob'])) ? $data['sister_dob'] : null;
        $this->sister_photo = (isset($data['sister_photo'])) ? $data['sister_photo'] : null;

        $this->name_title_S_sister = (isset($data['name_title_S_sister'])) ? $data['name_title_S_sister'] : null;
        $this->S_sister_name = (isset($data['S_sister_name'])) ? $data['S_sister_name'] : null;
        $this->spouse_sister_last_name = (isset($data['spouse_sister_last_name'])) ? $data['spouse_sister_last_name'] : null;
        $this->S_sister_status = (isset($data['S_sister_status'])) ? $data['S_sister_status'] : null;
        $this->S_sister_dob = (isset($data['S_sister_dob'])) ? $data['S_sister_dob'] : null;
        $this->S_sister_photo = (isset($data['S_sister_photo'])) ? $data['S_sister_photo'] : null;


        $this->name_title_kids = (isset($data['name_title_kids'])) ? $data['name_title_kids'] : null;
        $this->kids_name = (isset($data['kids_name'])) ? $data['kids_name'] : null;
        $this->kids_last_name = (isset($data['kids_last_name'])) ? $data['kids_last_name'] : null;
        $this->kids_status = (isset($data['kids_status'])) ? $data['kids_status'] : null;
        $this->kids_dob = (isset($data['kids_dob'])) ? $data['kids_dob'] : null;
        $this->kids_photo = (isset($data['kids_photo'])) ? $data['kids_photo'] : null;


        return $this;
    }

    public function getInputFilter() {
        //if (!$this->inputFilter) {
        $inputFilter = new InputFilter();
        $factory = new InputFactory();

        $inputFilter->add($factory->createInput(array(
                    'name' => 'id',
                    'required' => false,
                    'filters' => array(
                        array('name' => 'Int'),
                    ),
        )));

        $inputFilter->add($factory->createInput(array(
                    'name' => 'user_id',
                    'required' => false,
                    'filters' => array(
                        array('name' => 'StringTrim'),
                    ),
        )));
        /* $inputFilter->add($factory->createInput(array(
          'name'     => 'father_name',
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
