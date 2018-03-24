<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create task</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #005596;
		}
	</style>
</head>
<body>
	<div class="header">
		<h2>Redaguoti užduotį</h2>
	</div>
	<form method="get" action="edit.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Užduotis:</label>
			<input type="text" name="newTaskname" value="<?php echo $row[1]; ?>">
			<input type="hidden" name="id" value="<?php echo $row[0]; ?>">
		</div>
		<div class="input-group">
			<label>Vieta:</label>
			<input type="text" name="newLocation" value="<?php echo $row[2]; ?>">
		</div>
		<div class="input-group">
			<label>Priskirti vartotojui:</label>
			<select name="newUsername" id="userame" >
				<?php $selectUser = $db->query("SELECT * FROM users");
					if ($selectUser->num_rows != 0) {
						while ($row = $selectUser->fetch_assoc()) {
								$username = $row['username'];
								$id = $row['id'];
								echo "<option value='$username'>$id. $username<br></option>";
						}
					}
				?>
			</select>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="edit_btn">+ Redaguoti užduotį</button>
		</div>
	</form>
</body>
</html>