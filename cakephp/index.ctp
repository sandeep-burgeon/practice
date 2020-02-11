<div class="container">
<?php echo $this->Flash->render('Message'); ?>
<?php echo $this->Html->link('ADD Student',['action'=>'addstudents'],['class'=>'btn btn-sm btn-primary']);?>
	<table class="table table-bordered table-striped table-hover">
		<tr>
			<th>Name</th>
			<th>Email Id</th>
			<th>Mobile No.</th>
			<th>Address</th>
			<th>Action</th>
		</tr>
		<?php  if(!empty($students)): ?>
		<?php foreach($students as $student):?>
		<tr>
			<td><?=$student->name;?></td>
			<td><?=$student->email;?></td>
			<td><?=$student->phone;?></td>
			<td><?=$student->address;?></td>
			<td>
			<?php echo $this->Html->link('Edit',['action'=>'updatestudents',$student->id],['class'=>'btn btn-sm btn-warning']);?>|
			<?php echo $this->Html->link('View',['action'=>'viewstudents',$student->id],['class'=>'btn btn-sm btn-info']);?>|
			<button type="button" class="btn btn-sm btn-danger">Delete</button></td>
		</tr>
		<?php endforeach;?>
		<?php else: ?>
		<td>Record Not Found</td>
		<?php endif; ?>
	</table>
</div>