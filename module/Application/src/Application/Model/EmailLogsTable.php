<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class EmailLogsTable extends AbstractTableGateway {

    protected $table = 'tbl_email_logs';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

	public function saveEmailLogs($id,$msg) {
			$data['user_id'] = $id;
			$data['message'] = $msg;
			$data['ip'] = $_SERVER["REMOTE_ADDR"];
			$data['created_date'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
    }
}