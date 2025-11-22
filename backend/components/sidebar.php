<style>
    .sidebar {
        font-family: 'Quicksand', sans-serif;
        background-color: #003366;
        color: white;
        padding: 20px;
        height: 100vh;
    }
    .sidebar h2 {
        font-family: 'Italiana', serif;
        color: #BD8C2A;
        margin-bottom: 20px;
    }
    .sidebar ul {
        list-style: none;
        padding: 0;
    }
    .sidebar li {
        margin-bottom: 10px;
    }
    .sidebar a {
        color: #BD8C2A;
        text-decoration: none;
        font-weight: bold;
    }
    .sidebar a:hover {
        color: white;
    }
    .light-mode .sidebar {
        background-color: #f8f9fa;
        color: #003366;
    }
    .light-mode .sidebar h2 {
        color: #BD8C2A;
    }
    .light-mode .sidebar a {
        color: #BD8C2A;
    }
    .light-mode .sidebar a:hover {
        color: #003366;
    }
</style>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="users.php">Users</a></li>
        <li>
            <a href="#" onclick="toggleDropdown()">Physics Terms ▼</a>
            <ul id="physicsDropdown" style="display:none; margin-left:15px;">
                <li><a href="vocabulary_categories.php">Categories</a></li>
                <li><a href="videos.php">Videos</a></li>
                <li><a href="photos.php">Photos</a></li>
                <li><a href="terms.php">Terms</a></li>
            </ul>
        </li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="audit_logs.php">Audit Logs</a></li>
        <li><a href="backend/index.php">Logout</a></li>
    </ul>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('physicsDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</div>
