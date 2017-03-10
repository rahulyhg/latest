<?php

namespace Application\Mapper;

interface MatrimonialMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\MatrimonialInterface $commonObject);

    public function delete(\Application\Model\Entity\MatrimonialInterface $commonObject);
}
