<div class="container" style="background:#f1f1de;">
	<?php  echo $this->Form->create($student);?>
		<div class="form-group">
		    <?php echo $this->Form->input('name',['class'=>'form-control','placeholder'=>'Name']); ?>
		    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
		  </div>
		  <div class="form-group">
		    <?php echo $this->Form->input('email',['class'=>'form-control','placeholder'=>'Email Id']); ?>
		  </div>
		  <div class="form-group">
		    <?php echo $this->Form->input('phone',['class'=>'form-control','placeholder'=>'Mobile No.']); ?>
		  </div>
		  <div class="form-group">
		    <?php echo $this->Form->input('address',['class'=>'form-control','placeholder'=>'Address']); ?>
		  </div>
		  <?php echo $this->Form->button(__('Update'),['class'=>'btn btn-info']); ?>
		  <?php echo $this->Html->link('Back',['action'=>'index'],['class'=>'btn btn-warning']);?>
	<?php echo $this->Form->end(); ?>
</div>