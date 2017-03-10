<?php

namespace Application\Mapper;

use Common\Model\Entity\CommonInterface;
use Common\Model\Entity\User;
use Exception;
use InvalidArgumentException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\HydratorInterface;

class MembershipDbSqlMapper implements MembershipMapperInterface {

    protected $dbAdapter;
    protected $hydrator;
    protected $blogPrototype;
    protected $resultSet;

    public function __construct(
    AdapterInterface $dbAdapter, HydratorInterface $hydrator = null, \Application\Model\Entity\MembershipInterface $postPrototype = null
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
        $this->resultSet = new ResultSet();
    }

    public function delete(\Application\Model\Entity\MembershipInterface $commonObject) {
        
    }

    public function find($id) {
        
    }

    public function findAll() {
        
    }

    public function save(\Application\Model\Entity\MembershipInterface $commonObject) {
        
    }

}
