<?php

namespace Admin\Model\Entity;

class AllPages {

    public $id;
    public $page_category;
    public $user_id;
    public $language;
    public $keywords;
    public $title;
    public $page_name;
    public $image;
    public $description;
    public $is_active;    
    public $created_date;
    public $modified_date;
    public $modified_by;
    public $created_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->page_category = (!empty($data['page_category'])) ? $data['page_category'] : null;

        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;

        $this->language = (!empty($data['language'])) ? $data['language'] : null;
        
        $this->keywords = (!empty($data['keywords'])) ? $data['keywords'] : null;
        
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        
        $this->page_name = (!empty($data['page_name'])) ? $data['page_name'] : null;
        
        $this->image = (!empty($data['image'])) ? $data['image'] : null;
        
        $this->description = (!empty($data['description'])) ? $data['description'] : null;

        $this->is_active = (!empty($data['is_active'])) ? $data['is_active'] : null;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
        
        $this->created_by = (!empty($data['created_by'])) ? $data['created_by'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   