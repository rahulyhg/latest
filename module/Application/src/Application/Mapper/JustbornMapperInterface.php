<?php

namespace Application\Mapper;

interface JustbornMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\JustbornInterface $commonObject);

    public function delete(\Application\Model\Entity\JustbornInterface $commonObject);
}
