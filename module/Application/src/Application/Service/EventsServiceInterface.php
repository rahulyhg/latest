<?php

namespace Application\Service;

interface EventsServiceInterface {

   public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\EventsInterface $data);

    public function deletePost(\Application\Model\Entity\EventsInterface $data);
}
