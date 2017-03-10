<?php

namespace Admin\Model\Entity;

class Userinfos {

    public $id;
    public $ref_no;
    public $user_id;
    public $user_type_id;
    public $profile_for;
    public $profile_for_others;
    public $name_title_user;
    public $full_name;
     public $alternate_mobile_no;
    public $phone_no;
    public $gender;
    public $native_place;
    public $address;
    public $address_line2;
     public $country;
    public $state;
    public $city;
    public $zip_pin_code;
    public $about_yourself_partner_family;
    public $dob;
    public $age;
    public $blood_group;
     public $marital_status;
    public $no_of_childs;
    public $star_sign;
    public $zodiac_sign_raasi;
    public $sevvai_dosham;
    public $caste;
    public $caste_other;
    public $religion;
     public $religion_other;
    public $gothra_gothram;
    public $gothra_gothram_other;
    public $meal_preference;
    public $drink;
    public $smoke;
    public $manglik_dossam;
    public $height;
     public $color_complexion;
    public $any_disability;
    public $body_type;
    public $education_level;
    public $education_level_other;
    public $education_field;
    public $education_field_other;
    public $specialization_major;
     public $employment_status;
    public $employment_status_other;
    public $profession;
    public $profession_other;
    public $workplace_info;
    public $office_name;
    public $office_email;
    public $office_address;
     public $office_country;
    public $office_state;
    public $office_city;
    public $offfice_pincode;
    public $office_phone;
    public $office_website;
    public $working_with;
    public $working_with_other;
    public $designation;
     public $designation_other;
    public $annual_income;
    public $annual_income_status;
    public $profile_photo;
    public $no_of_brothers;
    public $no_of_brothers_married;
    public $no_of_sisters;
    public $no_of_sisters_married;
    public $branch_ids;
    public $ip;
    public $created_date;
    public $modified_date;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : '----';

        $this->ref_no = (!empty($data['ref_no'])) ? $data['ref_no'] : '----';

        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : '----';

        $this->user_type_id = (!empty($data['user_type_id'])) ? $data['user_type_id'] : '----';

        $this->profile_for = (!empty($data['profile_for'])) ? $data['profile_for'] : '----';
        
        $this->profile_for_others = (!empty($data['profile_for_others'])) ? $data['profile_for_others'] : '----';

        $this->name_title_user = (!empty($data['name_title_user'])) ? $data['name_title_user'] : '----';
        
        $this->full_name = (!empty($data['full_name'])) ? $data['full_name'] : '----';

         $this->alternate_mobile_no = (!empty($data['alternate_mobile_no'])) ? $data['alternate_mobile_no'] : '----';

        $this->phone_no = (!empty($data['phone_no'])) ? $data['phone_no'] : '----';

        $this->gender = (!empty($data['gender'])) ? $data['gender'] : '----';

        $this->native_place = (!empty($data['native_place'])) ? $data['native_place'] : '----';

        $this->address = (!empty($data['address'])) ? $data['address'] : '----';
        
        $this->address_line2 = (!empty($data['address_line2'])) ? $data['address_line2'] : '----';

        $this->country = (!empty($data['country'])) ? $data['country'] : '----';
        
        $this->state = (!empty($data['state'])) ? $data['state'] : '----';

         $this->city = (!empty($data['city'])) ? $data['city'] : '----';

        $this->city_name = (!empty($data['city_name'])) ? $data['city_name'] : '----';

        $this->zip_pin_code = (!empty($data['zip_pin_code'])) ? $data['zip_pin_code'] : '----';

        $this->about_yourself_partner_family = (!empty($data['about_yourself_partner_family'])) ? $data['about_yourself_partner_family'] : '----';

        $this->dob = (!empty($data['dob'])) ? $data['dob'] : '----';
        
        $this->age = (!empty($data['age'])) ? $data['age'] : '----';

        $this->blood_group = (!empty($data['blood_group'])) ? $data['blood_group'] : '----';
        
        $this->marital_status = (!empty($data['marital_status'])) ? $data['marital_status'] : '----';

         $this->no_of_childs = (!empty($data['no_of_childs'])) ? $data['no_of_childs'] : '----';

        $this->star_sign = (!empty($data['star_sign'])) ? $data['star_sign'] : '----';

        $this->zodiac_sign_raasi = (!empty($data['zodiac_sign_raasi'])) ? $data['zodiac_sign_raasi'] : '----';

        $this->sevvai_dosham = (!empty($data['sevvai_dosham'])) ? $data['sevvai_dosham'] : '----';

        $this->caste = (!empty($data['caste'])) ? $data['caste'] : '----';
        
        $this->caste_other = (!empty($data['caste_other'])) ? $data['caste_other'] : '----';

        $this->religion = (!empty($data['religion'])) ? $data['religion'] : '----';
        
        $this->religion_other = (!empty($data['religion_other'])) ? $data['religion_other'] : '----';

         $this->gothra_gothram = (!empty($data['gothra_gothram'])) ? $data['gothra_gothram'] : '----';

        $this->gothra_gothram_other = (!empty($data['gothra_gothram_other'])) ? $data['gothra_gothram_other'] : '----';

        $this->meal_preference = (!empty($data['meal_preference'])) ? $data['meal_preference'] : '----';

        $this->drink = (!empty($data['drink'])) ? $data['drink'] : '----';

        $this->smoke = (!empty($data['smoke'])) ? $data['smoke'] : '----';
        
        $this->manglik_dossam = (!empty($data['manglik_dossam'])) ? $data['manglik_dossam'] : '----';

        $this->height = (!empty($data['height'])) ? $data['height'] : '----';
        
        $this->color_complexion = (!empty($data['color_complexion'])) ? $data['color_complexion'] : '----';

         $this->any_disability = (!empty($data['any_disability'])) ? $data['any_disability'] : '----';

        $this->body_type = (!empty($data['body_type'])) ? $data['body_type'] : '----';

        $this->education_level = (!empty($data['education_level'])) ? $data['education_level'] : '----';

        $this->education_level_other = (!empty($data['education_level_other'])) ? $data['education_level_other'] : '----';

        $this->education_field = (!empty($data['education_field'])) ? $data['education_field'] : '----';
        
        $this->education_field_other = (!empty($data['education_field_other'])) ? $data['education_field_other'] : '----';

        $this->specialization_major = (!empty($data['specialization_major'])) ? $data['specialization_major'] : '----';
        
        $this->employment_status = (!empty($data['employment_status'])) ? $data['employment_status'] : '----';

         $this->employment_status_other = (!empty($data['employment_status_other'])) ? $data['employment_status_other'] : '----';

        $this->profession = (!empty($data['profession'])) ? $data['profession'] : '----';

        $this->profession_other = (!empty($data['profession_other'])) ? $data['profession_other'] : '----';

        $this->workplace_info = (!empty($data['workplace_info'])) ? $data['workplace_info'] : '----';

        $this->office_name = (!empty($data['office_name'])) ? $data['office_name'] : '----';
        
        $this->office_email = (!empty($data['office_email'])) ? $data['office_email'] : '----';

        $this->office_address = (!empty($data['office_address'])) ? $data['office_address'] : '----';
        
        $this->office_country = (!empty($data['office_country'])) ? $data['office_country'] : '----';

         $this->office_city = (!empty($data['office_city'])) ? $data['office_city'] : '----';

        $this->office_state = (!empty($data['office_state'])) ? $data['office_state'] : '----';

        $this->offfice_pincode = (!empty($data['offfice_pincode'])) ? $data['offfice_pincode'] : '----';

        $this->office_phone = (!empty($data['office_phone'])) ? $data['office_phone'] : '----';

        $this->office_website = (!empty($data['office_website'])) ? $data['office_website'] : '----';
        
        $this->working_with = (!empty($data['working_with'])) ? $data['working_with'] : '----';

        $this->working_with_other = (!empty($data['working_with_other'])) ? $data['working_with_other'] : '----';
        
        $this->designation = (!empty($data['designation'])) ? $data['designation'] : '----';

         $this->designation_other = (!empty($data['designation_other'])) ? $data['designation_other'] : '----';

        $this->annual_income = (!empty($data['annual_income'])) ? $data['annual_income'] : '----';

        $this->annual_income_status = (!empty($data['annual_income_status'])) ? $data['annual_income_status'] : '----';

        $this->profile_photo = (!empty($data['profile_photo'])) ? $data['profile_photo'] : '----';

        $this->no_of_brothers = (!empty($data['no_of_brothers'])) ? $data['no_of_brothers'] : '----';
        
        $this->no_of_brothers_married = (!empty($data['no_of_brothers_married'])) ? $data['no_of_brothers_married'] : '----';

        $this->no_of_sisters = (!empty($data['no_of_sisters'])) ? $data['no_of_sisters'] : '----';
        
        $this->no_of_sisters_married = (!empty($data['no_of_sisters_married'])) ? $data['no_of_sisters_married'] : '----';

         $this->branch_ids = (!empty($data['branch_ids'])) ? $data['branch_ids'] : '----';

        $this->ip = (!empty($data['ip'])) ? $data['ip'] : '----';
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : '----';

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : '----';
        
        
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   