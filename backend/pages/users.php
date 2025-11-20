<?php
session_start();
include '../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="../styles/logo.png">
	<title>Users - TermoPhysics</title>
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../styles/quicksand.css">
	<!-- AdminLTE CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<!-- Material Icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style>
		body { font-family: 'Quicksand', sans-serif; }
		h1, h2, h3, h4, h5, h6 { font-family: 'Italiana', serif; }
		.sidebar-dark-primary { background-color: #003366 !important; }
		.brand-link { background-color: #003366 !important; }
		.nav-link { color: #BD8C2A !important; }
		.nav-link:hover { background-color: #BD8C2A !important; color: #003366 !important; }
		.material-icons.nav-icon { color: #BD8C2A; }
	</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="logout.php">
					<i class="fas fa-sign-out-alt"></i> Logout
				</a>
			</li>
		</ul>
	</nav>
	<!-- Sidebar -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<a href="#" class="brand-link">
			<img src="../styles/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			<span class="brand-text font-weight-light">TermoPhysics</span>
		</a>
		<div class="sidebar-user-panel text-center py-3" style="background:#003366;color:#BD8C2A;">
			<div style="font-size:1.1em;font-weight:bold;">
				<?php echo htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : ''); ?>
			</div>
			<div style="font-size:0.95em;">Role: <?php echo htmlspecialchars(isset($_SESSION['role']) ? $_SESSION['role'] : ''); ?></div>
		</div>
		<div class="sidebar">
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
					<li class="nav-item">
						<a href="dashboard.php" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="users.php" class="nav-link active">
							<i class="nav-icon fas fa-users"></i>
							<p>Users</p>
						</a>
					</li>
					<li class="nav-item has-treeview">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-atom"></i>
							<p>
								Physics Terms
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview" style="margin-left:20px;">
							<li class="nav-item">
								<a href="vocabulary_categories.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">category</span>
									<p style="display:inline; margin-left:8px;">Categories</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="videos.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">video_library</span>
									<p style="display:inline; margin-left:8px;">Videos</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="photos.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">photo_library</span>
									<p style="display:inline; margin-left:8px;">Photos</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="terms.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">description</span>
									<p style="display:inline; margin-left:8px;">Terms</p>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a href="settings.php" class="nav-link">
							<i class="nav-icon fas fa-cogs"></i>
							<p>Settings</p>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</aside>
	<!-- Content -->
	<div class="content-wrapper">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Users</h1>
					</div>
				</div>
			</div>
		</div>
		<section class="content">
			<div class="container-fluid">
				<!-- ...existing code... -->
<?php


// Handle Add User
if (isset($_POST['addUser'])) {
	$username = trim($_POST['userName']);
	$password = $_POST['userPassword'];
	$role = $_POST['userRole'];
	if ($username !== '' && $password !== '' && $role !== '') {
		$hashed = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $username, $hashed, $role);
		if ($stmt->execute()) {
			echo '<div class="alert alert-success">User added successfully.</div>';
		} else {
			echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
		}
		$stmt->close();
	}
}

// Handle Edit User
if (isset($_POST['editUser'])) {
	$id = intval($_POST['editId']);
	$username = trim($_POST['editName']);
	$role = $_POST['editRole'];
	$password = $_POST['editPassword'];
	if ($username !== '' && $role !== '') {
		if ($password !== '') {
			$hashed = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
			$stmt->bind_param("sssi", $username, $hashed, $role, $id);
		} else {
			$stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
			$stmt->bind_param("ssi", $username, $role, $id);
		}
		if ($stmt->execute()) {
			echo '<div class="alert alert-success">User updated successfully.</div>';
		} else {
			echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
		}
		$stmt->close();
	}
}

// Handle Delete User
if (isset($_POST['deleteUser'])) {
	$id = intval($_POST['deleteId']);
	$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
	$stmt->bind_param("i", $id);
	if ($stmt->execute()) {
		echo '<div class="alert alert-success">User deleted successfully.</div>';
	} else {
		echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
	}
	$stmt->close();
}

?>
<div style="margin-left:220px; padding:20px;">
	<h1>Users</h1>
	<p>Manage users here.</p>
	<!-- Add User Button -->
	<button class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#addUserModal">
		<span class="material-icons" style="vertical-align:middle;">person_add</span> Add User
	</button>

	<!-- Add User Modal -->
	<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="post" action="">
					<div class="modal-header">
						<h5 class="modal-title" id="addUserModalLabel">Add User</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="userName">Username</label>
							<input type="text" class="form-control" id="userName" name="userName" required>
						</div>
						<div class="form-group">
							<label for="userPassword">Password</label>
							<input type="password" class="form-control" id="userPassword" name="userPassword" required>
						</div>
						<div class="form-group">
							<label for="userRole">Role</label>
							<select class="form-control" id="userRole" name="userRole" required>
								<option value="">Select Role</option>
								<option value="admin">Admin</option>
								<option value="user">User</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" name="addUser">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	// Fetch users
	$result = $conn->query("SELECT id, username, role FROM users ORDER BY id DESC");
	if ($result && $result->num_rows > 0) {
		echo '<table class="table table-bordered" style="background:#fff; margin-top:20px;">';
		echo '<thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></thead><tbody>';
		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
			echo '<td>' . htmlspecialchars($row['id']) . '</td>';
			echo '<td>' . htmlspecialchars($row['username']) . '</td>';
			echo '<td>' . htmlspecialchars($row['role']) . '</td>';
			echo '<td>';
			// Edit button
			echo '<button class="btn btn-sm btn-warning mr-1" data-toggle="modal" data-target="#editUserModal' . $row['id'] . '"><span class="material-icons" style="font-size:16px;vertical-align:middle;">edit</span></button> ';
			// Delete button
			echo '<form method="post" action="" style="display:inline;">';
			echo '<input type="hidden" name="deleteId" value="' . $row['id'] . '">';
			echo '<button type="submit" name="deleteUser" class="btn btn-sm btn-danger ml-1" onclick="return confirm(\'Are you sure you want to delete this user?\');"><span class="material-icons" style="font-size:16px;vertical-align:middle;">delete</span></button>';
			echo '</form>';
			// Edit Modal
			echo '<div class="modal fade" id="editUserModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel' . $row['id'] . '" aria-hidden="true">';
			echo '<div class="modal-dialog" role="document">';
			echo '<div class="modal-content">';
			echo '<form method="post" action="">';
			echo '<div class="modal-header bg-primary text-white">';
			echo '<h5 class="modal-title" id="editUserModalLabel' . $row['id'] . '">Edit User</h5>';
			echo '<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">';
			echo '<span aria-hidden="true">&times;</span>';
			echo '</button>';
			echo '</div>';
			echo '<div class="modal-body">';
			echo '<div class="form-group">';
			echo '<label for="editName' . $row['id'] . '">Username</label>';
			echo '<input type="text" class="form-control" id="editName' . $row['id'] . '" name="editName" value="' . htmlspecialchars($row['username']) . '" required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="editPassword' . $row['id'] . '">Password (leave blank to keep unchanged)</label>';
			echo '<input type="password" class="form-control" id="editPassword' . $row['id'] . '" name="editPassword">';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="editRole' . $row['id'] . '">Role</label>';
			echo '<select class="form-control" id="editRole' . $row['id'] . '" name="editRole" required>';
			echo '<option value="admin"' . ($row['role']=='admin'?' selected':'') . '>Admin</option>';
			echo '<option value="user"' . ($row['role']=='user'?' selected':'') . '>User</option>';
			echo '</select>';
			echo '</div>';
			echo '<input type="hidden" name="editId" value="' . $row['id'] . '">';
			echo '</div>';
			echo '<div class="modal-footer">';
			echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
			echo '<button type="submit" class="btn btn-primary" name="editUser">Save Changes</button>';
			echo '</div>';
			echo '</form>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	} else {
		echo '<p style="margin-top:20px;">No users found.</p>';
	}
	$conn->close();
	?>
</div>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="../styles/logo.png">
	<title>Users - TermoPhysics</title>
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../styles/quicksand.css">
	<!-- AdminLTE CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<!-- Material Icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style>
		body { font-family: 'Quicksand', sans-serif; }
		h1, h2, h3, h4, h5, h6 { font-family: 'Italiana', serif; }
		.sidebar-dark-primary { background-color: #003366 !important; }
		.brand-link { background-color: #003366 !important; }
		.nav-link { color: #BD8C2A !important; }
		.nav-link:hover { background-color: #BD8C2A !important; color: #003366 !important; }
		.material-icons.nav-icon { color: #BD8C2A; }
	</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="logout.php">
					<i class="fas fa-sign-out-alt"></i> Logout
				</a>
			</li>
		</ul>
	</nav>
	<!-- Sidebar -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<a href="#" class="brand-link">
			<img src="../styles/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			<span class="brand-text font-weight-light">TermoPhysics</span>
		</a>
		<div class="sidebar-user-panel text-center py-3" style="background:#003366;color:#BD8C2A;">
			<div style="font-size:1.1em;font-weight:bold;">
				<?php echo htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : ''); ?>
			</div>
			<div style="font-size:0.95em;">Role: <?php echo htmlspecialchars(isset($_SESSION['role']) ? $_SESSION['role'] : ''); ?></div>
		</div>
		<div class="sidebar">
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
					<li class="nav-item">
						<a href="dashboard.php" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="users.php" class="nav-link active">
							<i class="nav-icon fas fa-users"></i>
							<p>Users</p>
						</a>
					</li>
					<li class="nav-item has-treeview">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-atom"></i>
							<p>
								Physics Terms
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview" style="margin-left:20px;">
							<li class="nav-item">
								<a href="vocabulary_categories.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">category</span>
									<p style="display:inline; margin-left:8px;">Categories</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="videos.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">video_library</span>
									<p style="display:inline; margin-left:8px;">Videos</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="photos.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">photo_library</span>
									<p style="display:inline; margin-left:8px;">Photos</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="terms.php" class="nav-link">
									<span class="material-icons nav-icon" style="vertical-align:middle;">description</span>
									<p style="display:inline; margin-left:8px;">Terms</p>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a href="settings.php" class="nav-link">
							<i class="nav-icon fas fa-cogs"></i>
							<p>Settings</p>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</aside>
	<!-- Content -->
	<div class="content-wrapper">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Users</h1>
					</div>
				</div>
			</div>
		</div>
		<section class="content">
			<div class="container-fluid">
				<!-- ...existing code... -->

<?php
include '../config.php';

// Handle Add User
if (isset($_POST['addUser'])) {
	$username = trim($_POST['userName']);
	$password = $_POST['userPassword'];
	$role = $_POST['userRole'];
	if ($username !== '' && $password !== '' && $role !== '') {
		$hashed = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $username, $hashed, $role);
		if ($stmt->execute()) {
			echo '<div class="alert alert-success">User added successfully.</div>';
		} else {
			echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
		}
		$stmt->close();
	}
}

// Handle Edit User
if (isset($_POST['editUser'])) {
	$id = intval($_POST['editId']);
	$username = trim($_POST['editName']);
	$role = $_POST['editRole'];
	$password = $_POST['editPassword'];
	if ($username !== '' && $role !== '') {
		if ($password !== '') {
			$hashed = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
			$stmt->bind_param("sssi", $username, $hashed, $role, $id);
		} else {
			$stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
			$stmt->bind_param("ssi", $username, $role, $id);
		}
		if ($stmt->execute()) {
			echo '<div class="alert alert-success">User updated successfully.</div>';
		} else {
			echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
		}
		$stmt->close();
	}
}

// Handle Delete User
if (isset($_POST['deleteUser'])) {
	$id = intval($_POST['deleteId']);
	$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
	$stmt->bind_param("i", $id);
	if ($stmt->execute()) {
		echo '<div class="alert alert-success">User deleted successfully.</div>';
	} else {
		echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
	}
	$stmt->close();
}

?>
<div style="margin-left:220px; padding:20px;">
	<h1>Users</h1>
	<p>Manage users here.</p>
	<!-- Add User Button -->
	<button class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#addUserModal">
		<span class="material-icons" style="vertical-align:middle;">person_add</span> Add User
	</button>

	<!-- Add User Modal -->
	<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="post" action="">
					<div class="modal-header">
						<h5 class="modal-title" id="addUserModalLabel">Add User</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="userName">Username</label>
							<input type="text" class="form-control" id="userName" name="userName" required>
						</div>
						<div class="form-group">
							<label for="userPassword">Password</label>
							<input type="password" class="form-control" id="userPassword" name="userPassword" required>
						</div>
						<div class="form-group">
							<label for="userRole">Role</label>
							<select class="form-control" id="userRole" name="userRole" required>
								<option value="">Select Role</option>
								<option value="admin">Admin</option>
								<option value="user">User</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" name="addUser">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	// Fetch users
	$result = $conn->query("SELECT id, username, role FROM users ORDER BY id DESC");
	if ($result && $result->num_rows > 0) {
		echo '<table class="table table-bordered" style="background:#fff; margin-top:20px;">';
		echo '<thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></thead><tbody>';
		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
			echo '<td>' . htmlspecialchars($row['id']) . '</td>';
			echo '<td>' . htmlspecialchars($row['username']) . '</td>';
			echo '<td>' . htmlspecialchars($row['role']) . '</td>';
			echo '<td>';
			// Edit button
			echo '<button class="btn btn-sm btn-warning mr-1" data-toggle="modal" data-target="#editUserModal' . $row['id'] . '"><span class="material-icons" style="font-size:16px;vertical-align:middle;">edit</span></button> ';
			// Delete button
			echo '<form method="post" action="" style="display:inline;">';
			echo '<input type="hidden" name="deleteId" value="' . $row['id'] . '">';
			echo '<button type="submit" name="deleteUser" class="btn btn-sm btn-danger ml-1" onclick="return confirm(\'Are you sure you want to delete this user?\');"><span class="material-icons" style="font-size:16px;vertical-align:middle;">delete</span></button>';
			echo '</form>';
			// Edit Modal
			echo '<div class="modal fade" id="editUserModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel' . $row['id'] . '" aria-hidden="true">';
			echo '<div class="modal-dialog" role="document">';
			echo '<div class="modal-content">';
			echo '<form method="post" action="">';
			echo '<div class="modal-header bg-primary text-white">';
			echo '<h5 class="modal-title" id="editUserModalLabel' . $row['id'] . '">Edit User</h5>';
			echo '<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">';
			echo '<span aria-hidden="true">&times;</span>';
			echo '</button>';
			echo '</div>';
			echo '<div class="modal-body">';
			echo '<div class="form-group">';
			echo '<label for="editName' . $row['id'] . '">Username</label>';
			echo '<input type="text" class="form-control" id="editName' . $row['id'] . '" name="editName" value="' . htmlspecialchars($row['username']) . '" required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="editPassword' . $row['id'] . '">Password (leave blank to keep unchanged)</label>';
			echo '<input type="password" class="form-control" id="editPassword' . $row['id'] . '" name="editPassword">';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="editRole' . $row['id'] . '">Role</label>';
			echo '<select class="form-control" id="editRole' . $row['id'] . '" name="editRole" required>';
			echo '<option value="admin"' . ($row['role']=='admin'?' selected':'') . '>Admin</option>';
			echo '<option value="user"' . ($row['role']=='user'?' selected':'') . '>User</option>';
			echo '</select>';
			echo '</div>';
			echo '<input type="hidden" name="editId" value="' . $row['id'] . '">';
			echo '</div>';
			echo '<div class="modal-footer">';
			echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
			echo '<button type="submit" class="btn btn-primary" name="editUser">Save Changes</button>';
			echo '</div>';
			echo '</form>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	} else {
		echo '<p style="margin-top:20px;">No users found.</p>';
	}
	$conn->close();
	?>
</div>
<!-- JS dependencies for Bootstrap modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
