<?php

namespace Application\Service;

interface MatrimonialServiceInterface {

  public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\MatrimonialInterface $data);

    public function deletePost(\Application\Model\Entity\MatrimonialInterface $data);
    
    public function saveSendRequestMatriMonialInvitation($userId,$type,$sendUserId);
}
