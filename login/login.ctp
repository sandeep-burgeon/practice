<div class="container">
	<div class="card">
		<div class="card-body col-md-6 offset-md-3 bg-info">
			<!-- File: src/Template/Users/login.ctp -->

			<div class="">
			<?= $this->Flash->render() ?>
			<?= $this->Form->create() ?>
			    <fieldset>
			        <legend><?= __('Please enter your username and password') ?></legend>
			        <div class="form-group">
						<?php echo $this->Form->input('email',['class'=>'form-control','placeholder'=>'Email Address']);?>
					</div>
					<div class="form-group">
						<?php echo $this->Form->input('password',['class'=>'form-control','placeholder'=>'Password']);?>
					</div>
			        <?php // $this->Form->control('username') ?>
			        <?php //$this->Form->control('password') ?>
			    </fieldset>
			<?= $this->Form->button(__('Login'),['class'=>'btn btn-sm btn-success']); ?>
			<?php echo $this->Html->link('New',['action'=>'add'],['class'=>'btn btn-sm btn-primary']);?>
			<?= $this->Form->end() ?>

			</div>
		</div>
	</div>
</div>