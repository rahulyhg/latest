<?php

namespace Admin\Controller;

use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {
    
    protected $commonService;
    protected $adminService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
    }

    public function indexAction() {
        $auth = new AuthenticationService();
         if (!$auth->hasIdentity()) {
                return $this->redirect()->toRoute('admin/login');
            }else{
                return $this->redirect()->toRoute('admin/dashboard');
            }
//        $session = new Container('admin');
//        if (!isset($_SESSION['admin'])) {
//            return $this->redirect()->toRoute('admin/login');
//        } else {
//            return $this->redirect()->toRoute('admin/dashboard');
//        }
    }

    public function loginAction() {
        $messages = null;
        if ($this->getRequest()->isPost()) {
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $request = $this->getRequest();
            
            
            $username = $request->getPost('email');
            $password = $request->getPost('password');
            $authAdapter = new AuthAdapter($dbAdapter, 'tbl_admin_login', 'email', 'password', 'md5(?)');

            // get select object (by reference)
            //$select = $authAdapter->getDbSelect();
            //$select->where('IsActive = "1"');

            $authAdapter->setIdentity($username)->setCredential($password);
            $auth = new AuthenticationService();
            $result = $auth->authenticate($authAdapter);
            
            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    // do stuff for nonexistent identity
                   
                    break;

                case Result::FAILURE_CREDENTIAL_INVALID:
                    // do stuff for invalid credential
                    break;

                case Result::SUCCESS:
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                                    null, 'password'
                    ));
                    
                    $userSession = $this->getUser()->session();
                    $userSession->user = $storage->read();
                    foreach ($storage->read() as $u => $v) {
                        $userSession->offsetSet($u, $v);
                    }
                    //Debug::dump($storage->read());
                    //exit;
                    $time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//						if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session
                    if ($request->getPost('rememberme')) {
                        $sessionManager = new SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                    break;

                default:
                    // do stuff for other failure
                    break;
            }
            foreach ($result->getMessages() as $message) {
                $messages .= "$message\n";
            }
            
            
            if($auth->getIdentity()){
               return $this->redirect()->toRoute('admin/dashboard');
            }
            
            
        }
        //return $this->redirect()->toRoute('admin/dashboard');
        //return $this->redirect()->toRoute('admin/login');
        $viewModel = new ViewModel(array('messages'=>$messages));
        return $viewModel;
    }

    public function logoutAction() {
        $auth = new AuthenticationService();
        $auth->clearIdentity();
        
        $session = new Container('admin');
        $session->getManager()->getStorage()->clear('admin');
        //\Zend\Debug\Debug::dump($session->getManager()->getStorage()->clear('admin'));
        //var_dump(isset($_SESSION['admin']));
        //exit;
        return $this->redirect()->toRoute('admin/login');
    }

    public function dashboardAction() {
        
    }

}
