<?php 
include('../functions.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "Turite prisijungti!";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
	.header {
		background: #269;
	}
	</style>
</head>
<body>
	<div class="header">
		<h2>Administratoriaus valdymo panelė</h2>
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
			<!-- vartotojo informacija -->
		<div>	
			<img class="logo" src="../images/admin.png">
			<div>
			<?php  if (isset($_SESSION['user'])) : ?>
				<strong><?php echo $_SESSION['user']['username'];?></strong>
				<small>
					<i  style="color: #269;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
					<br>
					<br>
					<a href="home.php?logout='1'" class="logout-btn" "> - logout</a>&nbsp;
					<a class="btn" href="create_user.php"> + add user</a>&nbsp;
					<a class="btn" href="create_task.php"> + add task</a>
				</small>
			</div>
		</div>
			<br>
			<br>
		<div class="profile_info">
			<div class="success" ">
				<h3>Vartotojai:</h3>
					<?php $newUsers = $db->query("SELECT * FROM users");
						if ($newUsers->num_rows != 0) :
							while ($rows = $newUsers->fetch_assoc()) :
								$username = $rows['username'];
								$email = $rows['email'];
								$id = $rows['id'];
								$type = $rows['user_type'];
					?>
						<div class='error users';>
						<?php
								echo "<p>ID: $id <br> Vardas: $username <br> El-paštas: $email <br> Tipas: $type </p>"; 
						?> 		
							<div class="floatR">
								<a class="del-btn" onclick="return confirm('TIKRAI IŠTRINTI?')" href="home.php?userdel=<?php echo $rows['id']?>">Trinti</a> 
							</div>
						</div>
					<?php 
							endwhile;
						endif;
					?>
			</div>
						
			<div style="float: right;" class="success">
				<h3>Užduotys:</h3>
				<?php $newTasks = $db->query("SELECT * FROM tasks");
					if ($newTasks->num_rows != 0) :
						while ($row = $newTasks->fetch_assoc()) : 
							$taskname = $row['taskname'];
							$location = $row['location'];	
							$username = $row['username'];
							$id = $row['id'];
							$statusas = $row['status'];
				?>
				<div class='error tasks';>
				<?php			
					echo "<p>Užduoties ID: $id <br> Užduotis: $taskname <br> Vieta: $location <br> Kam priskirta: $username <br> Statusas: $statusas </p>";
				?> 
					<div class="floatR">
						<a class="del-btn" onclick="return confirm('TIKRAI IŠTRINTI?')" href="home.php?idd=<?php echo $row['id']?>">Trinti</a> 
						<a class="del-btn edit-btn" onclick="return confirm('Redaguoti?')" href="edit.php?edit=<?php echo $row['id']?>">Redaguoti</a>
					</div>
				</div> 
				<?php
						endwhile;
					endif;
				?>
			</div>
			<?php endif ?>
		</div>
	</div>
</body>
</html>