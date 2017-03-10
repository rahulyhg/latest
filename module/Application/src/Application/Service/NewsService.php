<?php

namespace Application\Service;

use Application\Service\NewsServiceInterface;

class NewsService implements NewsServiceInterface{

    protected $commonMapper;

    public function __construct(\Application\Mapper\NewsMapperInterface $commonMapper) {
        $this->commonMapper = $commonMapper;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\NewsInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\NewsInterface $data) {
        return $this->commonMapper->delete($data);
    }

}
