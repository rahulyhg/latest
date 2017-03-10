<?php

namespace Application\Mapper;

use Application\Model\Entity\AccountInterface;

interface AccountMapperInterface {

     public function find($id);

    public function findAll();

    public function save(AccountInterface $object);

    public function delete(AccountInterface $object);
}
