<?php

namespace Application\Service;

use Application\Service\EventsServiceInterface;

class EventsService implements EventsServiceInterface{

    protected $commonMapper;

    public function __construct(\Application\Mapper\EventsMapperInterface $commonMapper) {
        $this->commonMapper = $commonMapper;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\EventsInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\EventsInterface $data) {
        return $this->commonMapper->delete($data);
    }

}
