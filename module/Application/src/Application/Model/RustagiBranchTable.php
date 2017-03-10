<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class RustagiBranchTable extends AbstractTableGateway {

    protected $table = 'tbl_rustagi_branches';

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
    public function selectList($columns=array('branch_id,branch_name')){
        $designation= $this->select(function (Select $select) use ($columns) {
            $select->order('branch_id ASC');
            $select->columns($columns);
            
        })->toArray();
        foreach($designation as $c)$list[$c[$columns[0]]]=$c[$columns[1]];
        return $list;
    }
    public function getBrachListByCity($City_ID)
    {
        $branch=$this->select(array('branch_city_id'=>$City_ID))->toArray();
        //if($branch->count())
			if(count($branch))
                        return $branch;
        else            return NULL;
    }

}