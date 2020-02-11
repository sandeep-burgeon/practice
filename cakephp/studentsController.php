<?php
	namespace App\Controller;
	use App\Controller\AppController;

	/**
	 * 
	 */
	class studentsController extends AppController
	{
		
		public function index()
		{
			$students = $this->Students->find('all');
			$this->set('students',$students);
		}
		public function addstudents(){
			$student=$this->Students->newEntity();
				if($this->request->is('post')){
					$student=$this->Students->patchEntity($student,$this->request->getData());
					if($this->Students->save($student))
					{
						$this->Flash->success('Students Added Successfully',['key'=>'message']);
						return $this->redirect(['action'=>'index']);
					}
				$this->set('student','$student');
				}

		}
		public function updatestudents($id=Null){
			$student = $this->Students->get($id);
			$this->set('student',$student);
			// if (!$id && emptyempty($this->Students)) {  
  	// 			$this->Session->setFlash('Invalid movie');  
			// 	$this->redirect(array('action' => 'index'));  
  
   //    		}  
   //    		if (!emptyempty($this->Students)) {  
  	// 			if ($this->Students->save($this->Students)) {  
  	// 				$this->Session->setFlash('The movie has been saved');  
  	// 				$this->redirect(array('action' => 'index'));  
  	// 			} else {  
  	// 				$this->Session->setFlash('The movie could not be saved. Please, try again.');  
  	// 				}  
 		// 	}


		}
		public function viewstudents($id=Null){
			$student = $this->Students->get($id);
			$this->set('student',$student);
			
		}
	}

?>