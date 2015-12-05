<h2>Profile</h2>
<form id="user_edit" method="post" class="form-horizontal well">
	<?php
		echo $form->renderCsrf();
		echo $form->renderRow('name');
		echo $form->renderRow('teamspeak');
		echo $form->renderButtonRow('submit');
	?>
</form>