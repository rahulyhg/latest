<?php

namespace Application\Service;

use Application\Service\JustbornServiceInterface;

class JustbornService implements JustbornServiceInterface{

    protected $commonMapper;

    public function __construct(\Application\Mapper\JustbornMapperInterface $commonMapper) {
        $this->commonMapper = $commonMapper;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\JustbornInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\JustbornInterface $data) {
        return $this->commonMapper->delete($data);
    }

}
