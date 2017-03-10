<?php

namespace Application\Mapper;

interface NewsMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\NewsInterface $commonObject);

    public function delete(\Application\Model\Entity\NewsInterface $commonObject);
}
