<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class UserTypeTable extends AbstractTableGateway {

    protected $table = 'tbl_user_type';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    /*public function fetchAll() {
        $resultSet = $this->select(function (Select $select) {
                    $select->order('country_name ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Entity\Country();
            $entity->setId($row->id)
                    ->setCountryCode($row->country_code)
                    ->setCountryName($row->country_name);
            $entities[] = $entity;
        }
        return $entities;
    }
    public function getCountry($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;
        $row=(array)$row;
        $country = new Entity\Country();
            $country->setId($row['id'])->setCountryName($row['country_name'])->setCountryCode($row['country_code']);
        return $country;
    }

    public function saveCountry(Entity\Country $country) {
        $data = array(
            'country_code' => $country->getCountryCode(),
            'country_name' => $country->getCountryName(),            
        );

        $id = (int) $country->getId();

        if ($id == 0) {
//            $data['created'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getCountry($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }

    public function removeCountry($id) {
        return $this->delete(array('id' => (int) $id));
    }*/
    public function selectList($columns=array('id,user_type')){
        $userType= $this->select(function (Select $select) use ($columns) {
			$select->where('IsActive !=0');
            $select->order('id ASC');
            $select->columns($columns);
            
        })->toArray();
        foreach($userType as $c)$list[$c[$columns[0]]]=$c[$columns[1]];
        return $list;
    }
    /*public function getCountryByCode($code)
    {
        $c=$this->select(array('country_code'=>$code));
        if($c->count())
                        return $c->current();
        else            return NULL;
    }*/

}