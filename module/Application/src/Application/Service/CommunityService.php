<?php

namespace Application\Service;

use Application\Service\CommunityServiceInterface;

class CommunityService implements CommunityServiceInterface{

    protected $commonMapper;

    public function __construct(\Application\Mapper\CommunityMapperInterface $commonMapper) {
        $this->commonMapper = $commonMapper;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\CommunityInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\CommunityInterface $data) {
        return $this->commonMapper->delete($data);
    }

}
