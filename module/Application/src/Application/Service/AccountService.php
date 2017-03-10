<?php

namespace Application\Service;

use Application\Mapper\AccountMapperInterface;
use Application\Service\AccountServiceInterface;

class AccountService implements AccountServiceInterface{

    protected $accountMapper;

    public function __construct(AccountMapperInterface $accountMapper) {
        $this->accountMapper = $accountMapper;
    }

    public function findAllPosts() {
        return $this->accountMapper->findAll();
    }

    public function findPost($id) {
        return $this->accountMapper->find($id);
    }

    public function savePost(\Application\Model\Entity\AccountInterface $data) {
        return $this->accountMapper->save($data);
    }

    public function deletePost(\Application\Model\Entity\AccountInterface $data) {
        return $this->accountMapper->delete($data);
    }

}
