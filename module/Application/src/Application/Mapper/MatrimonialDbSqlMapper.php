<?php

namespace Application\Mapper;

use Application\Model\Entity\MatrimonialInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Stdlib\Hydrator\HydratorInterface;

class MatrimonialDbSqlMapper implements MatrimonialMapperInterface {

    protected $dbAdapter;
    protected $hydrator;
    protected $blogPrototype;
    protected $resultSet;

    public function __construct(
    AdapterInterface $dbAdapter, HydratorInterface $hydrator = null, MatrimonialInterface $postPrototype = null
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
        $this->resultSet = new ResultSet();
    }

    public function delete(MatrimonialInterface $commonObject) {
        
    }

    public function find($id) {
        
    }

    public function findAll() {
        
        return 'matrimonial';
        
    }

    public function save(MatrimonialInterface $commonObject) {
        
    }

}
