<?php

namespace Application\Service;

use Application\Model\Entity\AccountInterface;

interface AccountServiceInterface {

  public function findAllPosts();

    public function findPost($id);

    public function savePost(AccountInterface $data);

    public function deletePost(AccountInterface $data);
}
