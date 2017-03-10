<?php

namespace Application\Mapper;

use Common\Model\Entity\CommonInterface;

interface CommunityMapperInterface {

    public function find($id);

    public function findAll();

    public function save(\Application\Model\Entity\CommunityInterface $commonObject);

    public function delete(\Application\Model\Entity\CommunityInterface $commonObject);
}
