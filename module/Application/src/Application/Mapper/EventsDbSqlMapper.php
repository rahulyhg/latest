<?php

namespace Application\Mapper;

use Application\Model\Entity\EventsInterface;
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
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\HydratorInterface;

class EventsDbSqlMapper implements EventsMapperInterface {

    protected $dbAdapter;
    protected $hydrator;
    protected $blogPrototype;
    protected $resultSet;

    public function __construct(
    AdapterInterface $dbAdapter, HydratorInterface $hydrator = null, EventsInterface $postPrototype = null
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
        $this->resultSet = new ResultSet();
    }

    public function find($id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('posts');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->postPrototype);
        }

        throw new InvalidArgumentException("Blog with given ID:{$id} not found.");
    }

    public function findAll() {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('posts');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function save(CommonInterface $postObject) {
        $postData = $this->hydrator->extract($postObject);
        unset($postData['id']); // Neither Insert nor Update needs the ID in the array

        if ($postObject->getId()) {
            // ID present, it's an Update
            $action = new Update('posts');
            $action->set($postData);
            $action->where(array('id = ?' => $postObject->getId()));
        } else {
            // ID NOT present, it's an Insert
            $action = new Insert('posts');
            $action->values($postData);
        }

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                $postObject->setId($newId);
            }

            return $postObject;
        }

        throw new Exception("Database error");
    }

    public function delete(CommonInterface $postObject) {
        $action = new Delete('posts');
        $action->where(array('id = ?' => $postObject->getId()));

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }

    public function getUser($id) {



        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new User());
        }

        throw new InvalidArgumentException("Blog with given ID:{$id} not found.");
    }

    public function getUserType($columns = array('id', 'user_type')) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_type');
        $select->columns($columns);
        $select->where(array('IsActive != ?' => '0'));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            return $this->resultSet->initialize($result);
        }

        throw new InvalidArgumentException("Blog with given ID:{$id} not found.");
    }

    public function getAnnualIncomeList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {

            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $this->resultSet->initialize($result);
        }

        return array();
    }

    public function getCountryList() {

        $table = new TableGateway('tbl_country', $this->dbAdapter, null, new HydratingResultSet());
        $rowset = $table->select();
        return $rowset->toArray();
    }

    public function getCountryListById() {
        
    }

    public function getStateList() {
        $table = new TableGateway('tbl_state', $this->dbAdapter, null, new HydratingResultSet());
        $rowset = $table->select();
        return $rowset->toArray();
    }

    public function getStateByCountryCode() {
        
    }

    public function getCityList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_city');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function getCityListByStateCode($stateId) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_city');
        $select->where(array('state_id = ?' => $stateId));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            return $result->current();
            if (count($result->current())) {
                return $result->current();
            } else {
                return NULL;
            }
        }
    }

    public function getDesignationList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function getEducationFieldList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function getGotraList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function getHeightList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function getProfessionList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function getReligionList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    public function getEducationLevelList() {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            //$resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

}
