<?php 
include('functions.php');
if (!isLoggedIn()) {
	$_SESSION['msg'] = "Turite prisijungti!";
	header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Užduočių sąrašas</h2>
	</div>
	<div class="content">
		<div class="infoblock">
		<!-- ispejimai -->
			<?php if (isset($_SESSION['success'])) : ?>
				<div class="error success" >
					<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
					</h3>
				</div>
			<?php endif ?>
		</div>
		<!-- vartotojo info -->
		<div>
			<img class="logo" src="images/user.png" >
			<div>
			<?php  if (isset($_SESSION['user'])) : ?>
				<strong><?php echo $_SESSION['user']['username']; ?></strong>
				<small>
					<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
					<br><br>
					<a href="index.php?logout='1'" class="logout-btn" ">- logout</a>
				</small>
				<br>
			</div>
		<br>
			<div class="success">
				<h3>Užduotys:</h3>
					<?php $newTasks = $db->query("SELECT * FROM tasks");
						$current = $_SESSION['user']['username'];
							if ($newTasks->num_rows != 0) :
								while ($rows = $newTasks->fetch_assoc()) :
									$username = $rows['username'];									
									if ($current == $username) :
										$statusas = $rows['status'];
										$taskname = $rows['taskname'];
										$location = $rows['location'];
										$id = $rows['id'];
										 ?>
									<div class="tasks">
										 <?php
										echo "<p>Užduoties ID: $id<br>
											Užduotis: $taskname <br>
											Vieta: $location <br>
											Statusas: $statusas </p>";

					?> 					<div class="floatR">
											<a class="del-btn edit-btn" href="index.php?padaryta=<?php echo $rows['id']?>">Padaryta</a>
											<a class="del-btn" href="index.php?nepadaryta=<?php echo $rows['id']?>">Nepadaryta</a>
										</div>
									</div>
									<br><br><br>
					<?php
									endif;										
								endwhile;	
							endif;
									$vardai = $db->query("SELECT username FROM tasks WHERE username = '$current'");
									if ($vardai->num_rows == 0) {
											echo "Užduočių nėra!";
									}
					?>
			</div>
			<?php endif ?>
		</div>
	</div>
</body>
</html>