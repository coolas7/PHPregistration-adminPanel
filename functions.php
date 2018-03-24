<?php 
session_start();

$db = mysqli_connect('localhost', 'root', '', 'loginas');

$username = "";
$email    = "";
$errors   = array(); 
$taskname = "";
$location = "";

// registracijos mygtuko
if (isset($_POST['register_btn'])) {
	register();
}

// vartotoju registracija
function register(){
	global $db, $errors, $username, $email;
//pasiimam visas input reiksmes
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// ar formos laukai ne tusti
	if (empty($username)) { 
		array_push($errors, "Nurodykite vardą"); 
	}
	if (empty($email)) { 
		array_push($errors, "Nurodykite el.paštą"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Suveskite slaptažodį"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "Slaptažodžiai neatitinka");
	}
// registruojam jei viskas gerai
	if (count($errors) == 0) {
		$password = md5($password_1);

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "Naujas vartotojas sekmingai sukurtas!!";
			header('location: home.php');
		} else {
			$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
			mysqli_query($db, $query);

			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id);
			$_SESSION['success']  = "Prisijungėte sėkmingai";
			header('location: index.php');				
		}
	}
}

// sukurti uzduoti, jei nera klaidu  
if (isset($_GET['task_btn'])) {
	regtask();
}

function regtask() { 
	global $db, $errors, $taskname, $location, $username;
	$taskname = e($_GET['taskname']);
	$location = e($_GET['location']);
	$username = e($_GET['username']);

	if (empty($taskname)) { 
		array_push($errors, "Nurodykite užduoties aprašymą"); 
	}
	if (empty($location)) { 
		array_push($errors, "Nurodykite vieta"); 
	}
	if (empty($username)) { 
		array_push($errors, "Nepriskirta vartotojui"); 
	}

if (count($errors) == 0) {
	$query2 = "INSERT INTO tasks (taskname, location, username) VALUES ('$taskname', '$location', '$username')";
	mysqli_query($db, $query2);
			$_SESSION['success']  = "Nauja užduotis sukurta sekmingai!!";
			header('location: home.php');
	}
}

// vartotojo istrynimas
if (isset($_GET['userdel'])) {
	$userdel = $_GET['userdel'];
	$result = $db->query("DELETE FROM users WHERE id='$userdel'");
	if ($result) {
		?> <script> 
		alert ('Vartotojas ištrintas');
		window.location.href='home.php';
		</script>
		<?php 
	} else {
		?> <script> 
		alert ('Nepavyko ištrinti');
		window.location.href='home.php';
		</script>
		<?php 
	}
}

// uzduoties istrynimas
if (isset($_GET['idd'])) {
	$idd = $_GET['idd'];
	$result = $db->query("DELETE FROM tasks WHERE id='$idd'");
	if ($result) {
		?> <script> 
		alert ('Ištrinta');
		window.location.href='home.php';
		</script>
		<?php 
	} else {
		?> <script> 
		alert ('Nepavyko ištrinti');
		window.location.href='home.php';
		</script>
		<?php 
	}
}

// uzduoties redagavimas
 if(isset($_GET['edit'])) {
 	$id = $_GET['edit'];
 	$resu = $db->query("SELECT * FROM tasks WHERE id='$id'");
 	$row = mysqli_fetch_array($resu);

 }

if(isset($_GET['edit_btn'])) {
	$newTaskname = $_GET['newTaskname'];
	$newLocation = $_GET['newLocation'];
	$newUsername = $_GET['newUsername'];
	$id = $_GET['id'];
	$sql = "UPDATE tasks SET taskname='$newTaskname', location='$newLocation', username='$newUsername' WHERE id='$id'";
	$res = mysqli_query($db,$sql);
	$_SESSION['success']  = "Užduotis redaguota sėkmingai!!";
			header('location: home.php');
}

// pazymejimas, kad padaryta
if(isset($_GET['padaryta'])) {
 	$id = $_GET['padaryta'];
 	$result = $db->query("UPDATE tasks SET status ='padaryta' WHERE id='$id'");
 	if ($result) {
		?> <script> 
		alert ('Užduoties statusas nustatytas į padarytą!');
		window.location.href='index.php';
		</script>
		<?php 
	} else {
		?> <script> 
		alert ('Nepavyko nustatyti statuso!!!');
		window.location.href='index.php';
		</script>
		<?php 
	}
}
// pazymeti, kad nepadaryta
if(isset($_GET['nepadaryta'])) {
 	$id = $_GET['nepadaryta'];
 	$result = $db->query("UPDATE tasks SET status ='nepadaryta' WHERE id='$id'");
 	if ($result) {
		?> <script> 
		alert ('Užduoties statusas nustatytas į nepadarytą!');
		window.location.href='index.php';
		</script>
		<?php 
	} else {
		?> <script> 
		alert ('Nepavyko nustatyti statuso!!!');
		window.location.href='index.php';
		</script>
		<?php 
	}
}
// vartotoju ID pasiemimas
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string tipo
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}
// klaidu masyvas
function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	

// tikrinam ar buvo prisijungta
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// issiregistravimas
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// prisijungimo funkcija
if (isset($_POST['login_btn'])) {
	login();
}
function login(){
	global $db, $username, $errors;

	$username = e($_POST['username']);
	$password = e($_POST['password']);
	// ar ne tuscia
	if (empty($username)) {
		array_push($errors, "Neįvedėte vardo");
	}
	if (empty($password)) {
		array_push($errors, "Neįvedėte slaptažodžio");
	}
	// prisijungimas jei viskas gerai
	if (count($errors) == 0) {
		$password = md5($password);
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "Prisijungėte sėkmingai, kaip administratorius";
				header('location: admin/home.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "Prisijungėte sėkmingai";

				header('location: index.php');
			}
		} else {
			array_push($errors, "Neteisingi duomenys!");
		}
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}