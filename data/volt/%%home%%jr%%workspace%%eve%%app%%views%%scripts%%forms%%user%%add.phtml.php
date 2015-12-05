<h2>Register</h2>
<form id="user_add" method="post" class="form-horizontal well">
	<?php
		echo $form->renderCsrf();
		echo $form->renderRow('username', array('required' => 'required'));
		echo $form->renderRow('username_again', array('required' => 'required'));
		echo $form->renderRow('password', array('required' => 'required'));
		echo $form->renderRow('password_again', array('required' => 'required'));
		echo $form->renderRow('name');
		echo $form->renderRow('teamspeak');
		echo $form->renderRow('character', array('required' => 'required'));
		echo $form->renderRow('game_id', array('required' => 'required'));
		echo $form->renderButtonRow('submit');
	?>
</form>