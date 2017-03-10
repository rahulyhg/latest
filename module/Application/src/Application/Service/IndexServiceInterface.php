<?php

namespace Application\Service;

interface IndexServiceInterface {

    public function findAllPosts();

    public function findPost($id);

    public function savePost(\Application\Model\Entity\IndexInterface $data);

    public function deletePost(\Application\Model\Entity\IndexInterface $data);

    public function getGroomData();

    public function getExecutiveMember();
    
    public function getMatrimonialBrideData();
    
    public function getMatrimonialGroomData();

    public function getUpcomingEvents();
}
