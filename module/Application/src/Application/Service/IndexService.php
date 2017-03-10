<?php

namespace Application\Service;

use Application\Service\IndexServiceInterface;

class IndexService implements IndexServiceInterface {

    protected $indexMapper;

    public function __construct(\Application\Mapper\IndexMapperInterface $indexMapper) {
        $this->indexMapper = $indexMapper;
    }

    public function findAllPosts() {
        return $this->indexMapper->findAll();
    }

    public function findPost($id) {
        return $this->indexMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\IndexInterface $data) {
        return $this->indexMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\IndexInterface $data) {
        return $this->indexMapper->delete($data);
    }

    public function getGroomData() {
        return $this->indexMapper->getGroomData();
    }

    public function getExecutiveMember() {
        return $this->indexMapper->getExecutiveMember();
    }

    public function getUpcomingEvents() {
        return $this->indexMapper->getUpcomingEvents();
    }
    
    public function getMatrimonialBrideData() {
        return $this->indexMapper->getMatrimonialBrideData();
    }
    
    public function getMatrimonialGroomData() {
        return $this->indexMapper->getMatrimonialGroomData();
    }

}
