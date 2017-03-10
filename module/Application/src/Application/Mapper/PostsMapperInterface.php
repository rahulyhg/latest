<?php

namespace Application\Mapper;

interface PostsMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\PostsInterface $commonObject);

    public function delete(\Application\Model\Entity\PostsInterface $commonObject);
}
