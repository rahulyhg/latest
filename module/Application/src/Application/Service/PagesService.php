<?php
namespace Application\Service;

use Application\Service\PagesServiceInterface;

class PagesService implements PagesServiceInterface{

    protected $commonMapper;

    public function __construct(\Application\Mapper\PagesMapperInterface $commonMapper) {
        $this->commonMapper = $commonMapper;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\PagesInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\PagesInterface $data) {
        return $this->commonMapper->delete($data);
    }

}
