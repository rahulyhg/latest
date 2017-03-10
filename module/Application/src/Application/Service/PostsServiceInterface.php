<?php
namespace Application\Service;

interface PostsServiceInterface
 {
    public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\PostsInterface $data);

    public function deletePost(\Application\Model\Entity\PostsInterface $data);
     
 }