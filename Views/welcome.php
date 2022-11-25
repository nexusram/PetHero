<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main>
	<div class="container mt-5">
		<h1 class="alert alert-success" style="text-align: center;">WELCOME "<?php echo strtoupper($_SESSION["loggedUser"]->getName()) ?>" TO PET HERO!</h2>
	</div>
</main>