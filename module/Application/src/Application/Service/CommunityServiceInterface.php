<?php

namespace Application\Service;

interface CommunityServiceInterface {

     public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\CommunityInterface $data);

    public function deletePost(\Application\Model\Entity\CommunityInterface $data);
}
