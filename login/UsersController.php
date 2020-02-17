<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Error\Debugger;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\Table;
use App\Model\Entity\Role;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
//use Cake\Auth\DefaultPasswordHasher;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{

    public $uses = array('Users');

public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('add', 'logout');
    }

     public function index()
     {
       $users = $this->Paginate($this->Users);
        $this->set(compact('users'));
    }

    public function view($id)
    {
       $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function edit($id = 0)
    {
        if($id == 0)
        {
            return $this->redirect(array('action' => 'index'));
        } else {

            $user = TableRegistry::get('Users');
            

            $user = $this->Users->get($id);
            if ($this->request->is(['post', 'put'])) {
              $this->Users->patchEntity($user, $this->request->data);
              if ($this->Users->save($user)) {
                $this->Flash->success(__('Your account has been edited'));
                return $this->redirect(['controller' => 'Users', 'action' => 'edit']);
              }
              $this->Flash->error(__('Your account could not be edited. Please fix errors below.'));
            }
            $this->set('roles', $role);
            $this->set(compact('user'));
            $aRow = $this->request->data = $user;
            $this->set('aRow', $aRow);
        }

    }


    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $password = $this->request->data['password'];
            //$password = (new DefaultPasswordHasher)->hash($password);
            
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->password = $password;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('users', $user);
    }
   
    public function delete($id = 0) {
        if($id == 0)
        {
            return $this->redirect(array('action' => 'index'));
        }
        $entity = $this->Users->get($id);
        if ($this->Users->delete($entity))
        {
            $this->Flash->error(__('Admin deleted successfully.'),'default',array('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'index'));
        }
    }





    public function login()
    {

        //  $this->viewBuilder()->layout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);
                

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'),array('class' => 'alert alert-danger'));
         }
    }
      public function logout(){
        return $this->redirect($this->Auth->logout());
    }
    public function changepassword($id = 0) {
        if($id == 0)
        {
            return $this->redirect(array('action' => 'index'));
        }
     
        $user = TableRegistry::get('Users');
        $userdata = $user->get($id);
        $user = $this->Users->get($id);
        //$aUser = $this->User->find('first', array('conditions' => $aCon));
         if ($this->request->is('post')) {
           
            $aVals = $this->Users->patchEntity($user, $this->request->data);

             $user = $this->Users->patchEntity($user, [
                    'password' => $this->request->data['new_password'],
                    ]
            );

            if($aVals['new_password'] == $aVals['confirm_password'])
            {              
                $password = $aVals['new_password'];
               if ($usertable->save($user)) {
                 $this->Flash->success(__('Password change successfully'),'default',array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'changepassword'));
                }
            }
            else
            {
                 $this->Flash->error(__('Both password must be same.'),'default',array('class' => 'alert alert-danger'));
                return $this->redirect(array('action' => 'changepassword'));
            }          
        }
       
        $this->set('pageMainHeading', 'Change Password');
        $this->set('title_for_layout','Change Password');
       
    }
   
   
   
    public function status($id = 0,$active,$action) {
        if($id == 0)
        {
            return $this->redirect(array('action' => $action));
        }  
        $users = TableRegistry::get('Users');
        $query = $users->query(); 
        $query->update()
        ->set(['status' => $active])
        ->where(['id' => $id])
        ->execute();
       
        if($active)
        {   
        $msg = 'Admin successfully activated';
        } else {
        $msg = 'Admin successfully deactivated';
        }
        $this->Flash->success(__($msg),'default',array('class' => 'alert alert-success'));
        return $this->redirect(array('action' => $action));
    }

 


}