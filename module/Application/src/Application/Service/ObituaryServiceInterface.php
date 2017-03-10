<?php

namespace Application\Service;

interface ObituaryServiceInterface {

 public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\ObituaryInterface $data);

    public function deletePost(\Application\Model\Entity\ObituaryInterface $data);
}
