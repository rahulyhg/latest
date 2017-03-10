<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class ContactTable extends AbstractTableGateway {

    protected $table = 'tbl_contact';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function saveContact(Entity\Contact $address) {	
        $data = $address->getArrayCopy();
        $id = (int) $address->id;
		$data['ip'] = $_SERVER["REMOTE_ADDR"];
		$data['created_date'] = date("Y-m-d H:i:s");
        if ($id == 0) {
            if (!$this->insert($data))//{
                return false;
            return $this->getLastInsertValue();
        }
        else
            return false;
    }
}