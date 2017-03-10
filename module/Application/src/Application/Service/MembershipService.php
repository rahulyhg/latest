<?php

namespace Application\Service;

use Application\Service\MembershipServiceInterface;
use Zend\Db\Adapter\AdapterInterface;
use WebServices\TableName;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class MembershipService implements MembershipServiceInterface{

    protected $commonMapper;
    protected $dbAdapter;
    public function __construct(\Application\Mapper\MembershipMapperInterface $commonMapper, AdapterInterface $dbAdapter) {
        $this->commonMapper = $commonMapper;
        $this->dbAdapter=$dbAdapter;
    }

    public function findAllPosts() {
        return $this->commonMapper->findAll();
    }

    public function findPost($id) {
        return $this->commonMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\MembershipInterface $data) {
        return $this->commonMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\MembershipInterface $data) {
        return $this->commonMapper->delete($data);
    }
    public function saveSendRequestMemberInvitation($userId,$type,$sendUserId){
           $flag=false;       //var_dump($flag); exit;
            $tableName= TableName::MEMBERINVITATIONTABLE;
            $sql= new Sql($this->dbAdapter);
            $insert= new Insert($tableName);
            $insert->values(['user_id'=>$userId, 'sent'=>$sendUserId,'type'=>$type]);
            $result=$sql->prepareStatementForSqlObject($insert)->execute(); 
            if($result->getGeneratedValue()){
                $flag= true;
            }
            return $flag; 

        }
}
