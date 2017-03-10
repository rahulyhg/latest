<?php


namespace Application\Mapper;

use Zend\Db\Adapter\AdapterInterface;
use Application\Mapper\UserRestfulMapperInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserRestfulDbSqlMapper implements UserRestfulMapperInterface {

    protected $dbAdapter;
    protected $resultSet;
    protected $hydrator;

    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
        $this->hydrator =  new ClassMethods();
    }

}
