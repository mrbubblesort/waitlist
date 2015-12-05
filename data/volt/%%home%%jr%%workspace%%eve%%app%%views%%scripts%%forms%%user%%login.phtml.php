<h2>Login</h2>
<form id="user_login" method="post" class="form-horizontal well">
	<?php
		echo $form->renderCsrf();
		echo $form->renderRow('username', array('required' => 'required'));
		echo $form->renderRow('password', array('required' => 'required'));
		echo $form->renderButtonRow('submit');
	?>
</form>