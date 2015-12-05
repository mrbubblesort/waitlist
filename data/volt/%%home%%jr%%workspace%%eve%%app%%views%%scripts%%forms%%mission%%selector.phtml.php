<h2>Choose a Mission</h2>
<div class="form btn-multiple pull-left">
	<?php
        echo $form->renderSelectBtnGroup('mission', array(
            'please_select_txt' => 'Choose a Mission',
            'base_url' => 'mission/list/',
        ));
	?>
</div>