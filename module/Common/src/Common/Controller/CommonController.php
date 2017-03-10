<?php

namespace Common\Controller;

use Common\Form\UserForm;
use Common\Model\Entity\User\User;
use Common\Service\CommonServiceInterface;
use Exception;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;

class CommonController extends \Application\Controller\AppController {

    protected $commonService;

    public function __construct(CommonServiceInterface $commonService) {
        $this->commonService = $commonService;
    }

    public function indexAction() {
       // $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $obj=new \Common\Mapper\CommonDbSqlMapper($dbAdapter, new ClassMethods());
        Debug::dump($this->getTable()->BloodGroup());


//       $redis = $this->getServiceLocator ()->get ('Common\Cache\Redis' );
//		
//		// It will clear all keys stored in redis cache
//		$redis->flush();
//		
//		if ($redis->hasItem ('custom_key')) {
//			echo $redis->getItem('custom_key');
//		}else{
//			$redis->setItem('custom_key', 'Custom Value');
//		}
    }

    public function readAction() {
        $redis = $this->getServiceLocator()->get('Common\Cache\Redis');
        Debug::dump($redis->getItem('custom_key'));
    }

    public function addAction() {
        //var_dump($this->postService->findPost(1));
        $form = new UserForm();
        $user = new User();
        $form->bind($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                var_dump($form->getData());
            }
        }



        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editAction() {

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = new Sql($dbAdapter);
        $select = $sql->select('posts');
        //$select->columns(array('baz'=>'title'));
        $select->where(array('id = ?' => 1));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $hydrate = new ClassMethods(false);



//        $hydrator = new AggregateHydrator();
//        $hydrator->add(new Profile());
//        $hydrator->add(new Credentials());
//        
//        var_dump($result->current());
//        exit;

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //$user=new User();
            //$user->getProfile();
            $profile = $hydrate->hydrate($result->current(), new \Common\Entity\Profile\Profile());
            $credentials = $hydrate->hydrate($result->current(), new \Common\Entity\Credentials\Credentials());

            $user = new User();
            $user->setCredentials($credentials);
            $user->setProfile($profile);
            $rows = $hydrate->hydrate($result->current(), $user);
        }
//        var_dump($rows);
//        exit;

        $request = $this->getRequest();
        //$post    = $this->postService->findPost(1);

        $form = new UserForm();
        $form->bind($rows);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                var_dump($form->getData());
                exit;
                try {
                    $form->savePost($post);

                    return $this->redirect()->toRoute('blog');
                } catch (Exception $e) {
                    die($e->getMessage());
                    // Some DB Error happened, log it and let the user know
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

}
