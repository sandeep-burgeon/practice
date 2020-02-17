<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\Auth\DefaultPasswordHasher;


class UsersTable extends Table
{
	/*
	  * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsTo('UserGroups', [
			'className'=>'UserGroups',
            'foreignKey' => 'user_group_id',
        ]);
        $this->addBehavior('Captcha', [
					'field' => 'captcha',
					'message' => 'Entered security does not match.'
				]);

    }
    
     public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('email',[
					'valid'=>[
						'rule' => 'email',
						'message'=>'Please enter valid email address.'
						],
						/*'unique' => [
							'rule' =>['validateUnique', ['scope' => 'email']],
							'provider' => 'table',
							'message'=>'This email has already been registered.'
						],*/
						'unique_check' => [
							'rule' =>'UniqueEmail',
							'provider' => 'table',
							'message'=>'This email has already been registered.'
						]
					])
            ->notEmpty('email','Please enter email address.');
        $validator
			->notEmpty('name','Please enter name.')
			->add('name', 'validFormat',[
					'rule' => array('custom', '/^[A-Za-z ]*$/'),
					'message' => 'Please enter name in alphabet.'
			]);
		 $validator
			->notEmpty('lname','Please enter last name.')
			->add('lname', 'validFormat',[
					'rule' => array('custom', '/^[A-Za-z ]*$/'),
					'message' => 'Please enter last name in alphabet.'
			]);
		$validator
			->allowEmpty('image')
			->add('image',
					[
					'file'=>[
						'rule' => ['mimeType', ['image/jpeg','image/png','image/gif','image/jpg']],
						'on' => function ($context) {
							return !empty($context['data']['site_front_logo']);
						},
						'message' => 'Pleaser upload valid image.'
					]
				]);
		$validator
			->notEmpty('username','Please enter username.');
		
        $validator
            ->notEmpty('password','Please enter password.');

        $validator
            ->notEmpty('new_password','Please enter new password.');
		$validator
			->add('new_password', 'minLength', [
			'rule' => ['minLength', 5],
			'message' => 'Password should be at least 6 digit long.',
			]);
		
		 $validator
            ->notEmpty('oldpassword','Please enter old password.')
            ->add('oldpassword',
						['checkcurrentpasswords'=>[
							'rule' =>function($value, $context) {
								$query = $this->find()
										->where([
											'id' =>$context['data']['id'],
										])
										->first();

								$data = $query->toArray();
								
								return (new DefaultPasswordHasher)->check($value, $data['password']);
							},
							'message' => 'Current password is invalid.'
						],
					]);
        $validator
            ->notEmpty('confirm_password','Confirm your password here.');

        $validator
            ->add('confirm_password', 'custom', ['rule' => function ($value, $context) {
                if (!array_key_exists('new_password', $context['data'])) {
                    return false;
                }
                if ($value !== $context['data']['new_password']) {
                    return false;
                }
                return true;
            },
                'message' => 'Your new password and confirm password does not match.']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
   public function buildRules(RulesChecker $rules){
		$rules->add($rules->isUnique(['email']));
		return $rules;
	}

     /**
     * beforeSave event
     *
     * @param \Cake\Event\Event $event Event.
     * @param \Cake\ORM\Entity $entity Entity.
     * @param array $options Options.
     * @return void
     */
    public function beforeSave($event, $entity, $options)
    {
        $newPassword = $entity->get('new_password');
        if (!empty($newPassword)) {
            $entity->set('password', $entity->new_password); // set for password-changes
        }
    }

	public function UniqueEmail($value,$context){
		if(!empty($context['data']['id'])){
			$query = $this->find('all',['conditions'=>['id !='=>$context['data']['id'],'email'=>$value]])->toArray();
			if(!empty($query)){
				return false;
			}else{
				return true;
			}
		}
		return true;
	}

    /**
     * generateRequestKey
     *
     * This method generates a request key for an user.
     * It returns a generated string.
     *
     * @return string
     */
    public function generateRequestKey()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $requestKey = '';
        for ($i = 0; $i < 40; $i++) {
            $requestKey .= $characters[rand(0, $charactersLength - 1)];
        }
        return $requestKey;
    }
    

    /**
     * validateRequestKey
     *
     * Checks if an user is allowed to do an action with a required activation-key
     *
     * @param string $email E-mailaddress of the user.
     * @param string $requestKey Activation key of the user.
     * @return bool
     */
    public function validateRequestKey($email, $requestKey = null)
    {
        if (!$requestKey) {
            return false;
        }
        $query = $this->find('all')->where([
            'email' => $email,
            'passwordurl' => $requestKey
        ]);

        if ($query->Count() > 0) {
            return true;
        }
        return false;
    }
    
    public function findAuth(\Cake\ORM\Query $query, array $options)
{
    $query
        ->select(['id', 'username','password','name','lname','email','photo','user_group_id','UserGroups.name','UserGroups.permissions','UserGroups.is_access_settings'])
        ->where(['Users.status' => 1,'UserGroups.status'=>1])->contain(['UserGroups']);

    return $query;
}

}
