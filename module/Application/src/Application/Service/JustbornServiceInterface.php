<?php

namespace Application\Service;

interface JustbornServiceInterface {

   public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\JustbornInterface $data);

    public function deletePost(\Application\Model\Entity\JustbornInterface $data);
}
