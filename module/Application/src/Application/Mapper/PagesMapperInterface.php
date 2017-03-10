<?php

namespace Application\Mapper;

interface PagesMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\PagesInterface $commonObject);

    public function delete(\Application\Model\Entity\PagesInterface $commonObject);
}
