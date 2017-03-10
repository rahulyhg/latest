<?php

namespace Application\Form;

use Application\Model\Entity\Post;
use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class PostForm extends Form {

    public static $postCategoryList = array();
    protected $commonService;

    public function __construct(CommonServiceInterface $commonService) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->commonService = $commonService;
        self::$postCategoryList=$this->commonService->getPostCategoryList();
        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new Post());
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'post_category',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'post_category'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'value_options' => self::$postCategoryList,
            )
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'title'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type' => 'file',
                // 'class' => 'form-control',
                'id' => 'image'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'language',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'language'
            ),
            'options' => array(
                'empty_option' => 'Select',
                'label' => "Language of Article",
                'value_options' => array(
                    "1" => "Hindi",
                    "2" => "English",
                ),
            )
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'attributes' => array(
                'id' => 'description',
                'class' => 'form-control',
                'cols' => 25,
                'rows' => 4
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'keywords',
            'attributes' => array(
                'type' => 'hidden',
                'value' => 1,
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'id' => 'submit',
                'class' => 'btn btn-default'
            ),
        ));
    }

}

?>