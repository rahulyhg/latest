<?php
namespace Application\Mapper;

interface IndexMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\IndexInterface $commonObject);

    public function delete(\Application\Model\Entity\IndexInterface $commonObject);
}
