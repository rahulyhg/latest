<?php
namespace Application\Service;

use Application\Service\PostsServiceInterface;

class PostsService implements PostsServiceInterface{

    protected $commonMapper;

    public function __construct(\Application\Mapper\PostsMapperInterface $commonMapper) {
        $this->commonMapper = $commonMapper;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\PostsInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\PostsInterface $data) {
        return $this->commonMapper->delete($data);
    }

}
