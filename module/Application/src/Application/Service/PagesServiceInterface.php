<?php

namespace Application\Service;

interface PagesServiceInterface {

   public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\PagesInterface $data);

    public function deletePost(\Application\Model\Entity\PagesInterface $data);
}
