<?php

namespace Application\Service;

use Application\Service\ApplicationServiceInterface;

class ObituaryService implements ObituaryServiceInterface{

    protected $commonMapper;

    public function __construct(\Application\Mapper\ObituaryMapperInterface $commonMapper) {
        $this->commonMapper = $commonMapper;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\ObituaryInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\ObituaryInterface $data) {
        return $this->commonMapper->delete($data);
    }

}
