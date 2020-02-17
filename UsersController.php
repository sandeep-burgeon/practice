<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Validation\Validation;
use Cake\Event\Event;
use Cake\Utility\Security;


class UsersController extends AppController
{
    public $components = array('Auth');

    public function index()
    {
        $users = $this->Paginate($this->Users);
        $this->set(compact('users'));
        
    }
    // public function beforeFilter(Event $event)
    // {
    //     parent::beforeFilter($event);
    //     // Allow users to register and logout.
    //     // You should not add the "login" action to allow list. Doing so would
    //     // cause problems with normal functioning of AuthComponent.
    //     $this->Auth->allow(['add', 'logout']);
    // }
    public function add(){
        $users="";
        if ($this->request->is('post')) {
            /*$password = $this->request->data['password'];
            $key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';
            $encriptPass = Security::encrypt($password, $key);*/
            $this->request->data['password'] = md5(md5($this->request->data['password']));
            $users = $this->Users->newEntity();
            $users = $this->Users->patchEntity($users, $this->request->data);
            if ($this->Users->save($users)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('users', $users);

        // Just added the categories list to be able to choose
        // one category for an article
        //$categories = $this->Users->Categories->find('treeList');
        //$this->set(compact('categories'));



        // $user = $this->Users->newEntity();
        // if ($this->request->is('post')) {
        //     $user = $this->Users->patchEntity($user, $this->request->getData());

        //     // Changed: Set the user_id from the session.
        //    // $user->user_id = $this->Auth->user('id');

        //     if ($this->Users->save($user)) {
        //         $this->Flash->success(__('Your article has been saved.'));
        //         return $this->redirect(['action' => 'index']);
        //     }
        //     $this->Flash->error(__('Unable to add your article.'));
        // }
        // $this->set('user', $user);
    }
    public function edit($id){
        $user=$this->Users->get($id);
        if($this->request->is(['post','put'])){
            $user=$this->Users->patchEntity($user,$this->request->getData());
            $user->modified = date('y-m-d H:i:s');
            $this->Users->save($user);
            return $this->redirect(['action'=>'index']);
        }
        $this->set('username',$user->username);
        $this->set('email',$user->email);
        $this->set('password',$user->password);
        $this->set('Users',$user);
    }
    public function login(){
        if($this->request->data){
            $this->loadModel('Users');
            if ($this->authUser) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $user = $this->Users->newEntity($this->request->data);
            if ($this->request->is('post')){
                $user = $this->Auth->identify();
                if($user) {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }else {
                    $this->Flash->error(__('Invalid username or password.'));
                    $this->request->data['email'] = '';
                    $this->request->data['password'] = '';
                }
            }
        }
    }
    // public function logout(){
    //      $this->Flash->success('You successfully have loged out'); 
    //      return $this->redirect($this->Auth->logout());
    //      }
    public function delete($id){
        $this->request->allowMethod(['post','delete']);
        $user=$this->Users->get($id);
        $this->Users->delete($user);
        return $this->redirect(['action'=>'index']);
    }
}
?>