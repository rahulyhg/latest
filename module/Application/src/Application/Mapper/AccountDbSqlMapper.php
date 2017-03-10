<?php

namespace Application\Mapper;

use Application\Model\Entity\AccountInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AccountDbSqlMapper implements AccountMapperInterface {

    protected $dbAdapter;
    protected $hydrator;
    protected $blogPrototype;
    protected $resultSet;

    public function __construct(
    AdapterInterface $dbAdapter, HydratorInterface $hydrator = null, AccountInterface $postPrototype = null
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
        $this->resultSet = new ResultSet();
    }

    public function delete(AccountInterface $object) {
        
    }

    public function find($id) {
        return $id;
    }

    public function findAll() {
        
    }

    public function save(AccountInterface $object) {
        
    }

}
