<?php

namespace Application\Mapper;

interface ObituaryMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\ObituaryInterface $commonObject);

    public function delete(\Application\Model\Entity\ObituaryInterface $commonObject);
}
