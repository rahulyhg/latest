<?php

namespace Application\Service;

use Application\Service\MatrimonialServiceInterface;
use Zend\Db\Adapter\AdapterInterface;
use WebServices\TableName;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;


class MatrimonialService implements MatrimonialServiceInterface{

    protected $commonMapper;
    protected $dbAdatpter;

    public function __construct(\Application\Mapper\MatrimonialMapperInterface $commonMapper, AdapterInterface $dbAdapter) {
        $this->commonMapper = $commonMapper;
        $this->dbAdatpter=$dbAdapter;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\MatrimonialInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\MatrimonialInterface $data) {
        return $this->commonMapper->delete($data);
    }
    
    public function saveSendRequestMatriMonialInvitation($userId,$type,$sendUserId){
       $flag=false;      // var_dump($flag); exit;
        $tableName= TableName::MATRIMONIALINVITATIONTABLE;
        $sql= new Sql($this->dbAdatpter);
        $insert= new Insert($tableName);
        $insert->values(['user_id'=>$userId, 'sent'=>$sendUserId,'type'=>$type]);
        $result=$sql->prepareStatementForSqlObject($insert)->execute();        //var_dump($result->getSql()); exit;
               // $result->execute();
        if($result->getGeneratedValue()){
            $flag= true;
        }
       // var_dump($flag);
        return $flag; 
        
    }
}
