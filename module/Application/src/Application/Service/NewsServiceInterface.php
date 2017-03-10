<?php

namespace Application\Service;

interface NewsServiceInterface {

  public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\NewsInterface $data);

    public function deletePost(\Application\Model\Entity\NewsInterface $data);
}
