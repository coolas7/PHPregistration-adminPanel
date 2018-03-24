<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sukurkti naują vartotoją</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #003366;
		}
	</style>
</head>
<body>
	<div class="header">
		<h2>Sukurkite naują vartotoją</h2>
	</div>
	<form method="post" action="create_user.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Vardas:</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>El. paštas</label>
			<input type="email" name="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>Vartotojo lygis:</label>
			<select name="user_type" id="user_type" >
				<option value=""></option>
				<option value="admin">Adminas</option>
				<option value="vartotojas">Vartotojas</option>
			</select>
		</div>
		<div class="input-group">
			<label>Slaptažodis:</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>Pakartokite slaptažodį:</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn"> + Sukurti vartotoją</button>
		</div>
	</form>
</body>
</html>