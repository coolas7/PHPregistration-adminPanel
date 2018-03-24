<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sukurti užduotį</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #005596;
		}
	</style>
</head>
<body>
	<div class="header">
		<h2>Sukurkite naują užduotį</h2>
	</div>
	
	<form method="get" action="create_task.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Užduotis:</label>
			<input type="text" name="taskname" value="<?php echo $taskname; ?>">
		</div>
		<div class="input-group">
			<label>Vieta:</label>
			<input type="text" name="location" value="<?php echo $location; ?>">
		</div>
		<div class="input-group">
			<label>Priskirti vartotojui:</label>
			<select name="username" id="userame" >
				<?php $selectUser = $db->query("SELECT * FROM users");
					if ($selectUser->num_rows != 0) {
						while ($rows = $selectUser->fetch_assoc()) {
							$username = $rows['username'];
							$id = $rows['id'];
							echo "<option value='$username'>$id. $username<br></option>";
						}
					}
				?>
			</select>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="task_btn"> + Sukurti užduotį</button>
		</div>
	</form>
</body>
</html>