<?php
 // Filename: /module/Blog/src/Blog/Mapper/PostMapperInterface.php
 namespace Common\Mapper;

 use Common\Model\PostInterface;

 interface PostMapperInterface
 {
     /**
      * @param int|string $id
      * @return PostInterface
      * @throws \InvalidArgumentException
      */
     public function find($id);

     /**
      * @return array|PostInterface[]
      */
     public function findAll();

     /**
      * @param PostInterface $postObject
      *
      * @param PostInterface $postObject
      * @return PostInterface
      * @throws \Exception
      */
     public function save(PostInterface $postObject);
     /**
      * @param PostInterface $postObject
      *
      * @return bool
      * @throws \Exception
      */
     public function delete(PostInterface $postObject);
     
 }