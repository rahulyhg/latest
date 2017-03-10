<?php

namespace Application\Service;

interface MembershipServiceInterface {

   public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\MembershipInterface $data);

    public function deletePost(\Application\Model\Entity\MembershipInterface $data);
    
    public function saveSendRequestMemberInvitation($userId,$type,$sendUserId);
}
