<?php

namespace Application\Mapper;

interface EventsMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\EventsInterface $commonObject);

    public function delete(\Application\Model\Entity\EventsInterface $commonObject);
}
