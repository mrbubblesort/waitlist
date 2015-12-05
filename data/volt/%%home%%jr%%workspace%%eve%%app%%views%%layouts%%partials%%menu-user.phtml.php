<?php
	if(
		$this->session->get('auth') &&
		$this->session->get('auth')->role->role == 'admin'
	) {
		?><div class="side-menu">
	<div class="nav-header side-menu-pad">
    	Admin Tools
    </div>
    <ul class="nav nav-list">
		<li>
			<?php
				echo $this->tag->linkTo(array(
					'mission',
					'Missions'
				));
			?>
		</li>
	</ul>
</div><?php
	}
?>

<div class="side-menu">
	<div class="nav-header side-menu-pad">
    	Menu
    </div>
    <ul class="nav nav-list">
		<li>
			<?php
				echo $this->tag->linkTo(array(
					'',
					'Home',
				));
			?>
		</li>
		<?php
			if($this->session->get('auth')) {
				?>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'user',
								'My Overview'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'mission/list',
								'Active Missions / Wait List'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'user/edit',
								'Edit Profile'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'user/password',
								'Edit Password'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'character/add',
								'Add Character'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'fit/add',
								'Add Fit'
							));
						?>
					</li>
				<?php
			}
		?>
	</ul>
</div>