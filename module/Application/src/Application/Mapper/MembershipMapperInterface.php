<?php

namespace Application\Mapper;

interface MembershipMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\MembershipInterface $commonObject);

    public function delete(\Application\Model\Entity\MembershipInterface $commonObject);
}
