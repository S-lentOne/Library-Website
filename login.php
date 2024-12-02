<?php
session_start();
include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Use prepared statement to prevent SQL injection
        $query = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $user_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            
            // Note: In a real application, use password_hash() and password_verify()
            if($user_data['password'] === $password) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: Resources.php");
                die;
            }
        }
        $error_message = "Invalid username or password";
    } else {
        $error_message = "Please enter valid information";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Chitkara University Library</title>
    <link rel="stylesheet" href="Project.css">
</head>
<body>
    <nav class="navbar">
        <a href="Home.html" class="navbar-brand">
            <img src="logo.jpg" alt="Chitkara University" class="nav-logo">
            Library
        </a>
        <ul class="nav-links">
            <li><a href="resources.php">My Library</a></li>
            <li><a href="About.html">About</a></li>
            <li><a href="Gallery.html">Gallery</a></li>
            <li><a href="https://course.testpad.chitkarauniversity.edu.in/user-dashboard">Testpad</a></li>
            <li><a href="signup.php">Sign Up</a></li>
        </ul>
    </nav>

    <section class="login">
        <form method="post">
            <img src="Chitkara.png" alt="Chitkara logo">
            <h2>Log into your account</h2>
            
            <?php if(isset($error_message)): ?>
                <div style="color: red; text-align: center;"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <div class="form-login">
                <a href="#">Forgot Password</a>
                <button type="submit">Login</button>
				<br>
				<br>
				<p>
					New? <a href="signup.php">Create Account</a>
				</p>
            </div>
        </form>
    </section>
	<div class="row-link-row">
		<div class="menu-footer-container">			
		
			<img src="logo-mn.jpg" alt="Chitkara University" class="ql-logo" />
			<p class="contact"> 
				<span class="bold">Support & Assistance</span>
				<br>
				<br>
				Pinjore-Barotiwala National Highway (NH-21A)
				<br>
				Himachal Pradesh – 174 103
				<br>
				<br>
				Email: librarian@chitkarauniversity.edu.in
				<br>
				Phone: +91.01795-661028
			</p>
			<div class="link-footer"> 
				<ul>
					<li>
						<p class="bold">Explore<p>
					</li>
					
					<li>
						<a class="cta-button" href="#">About</a>
					</li>
	
					<li>
						<a class="cta-button" href="#">Testpad</a>
					</li>
	
					<li>
						<a class="cta-button" href="donate.php">Donate</a>
					</li>
	
					<li>
						<a class="cta-button" href="resources.php">Resources</a>
					</li>
	
					<li>
						<a class="cta-button" href="About.html"> Hours &amp; Timings </a>
					</li>
				</ul>
			</div>

			<div class="social-footer">
				<ul><li><p class="bold">Socials<p></li>
					<li><a class="cta-button" href="#">Newsletter</a></li>
					<li><a class="cta-button" href="#">Facebook</a></li>
					<li><a class="cta-button" href="#">Twitter</a></li>
					<li><a class="cta-button" href="#">GMaps Location</a></li>
					<li><a class="cta-button" href="#">Instagram</a></li>
				</ul>
			</div>
		</div>
	</div>
<div class="sidebar-nav" id="sidebar">
        <div class="sidebar-content">
            <div class="sidebar-section">
                <h3>Current Page</h3>
                <p id="current-page">Log In</p>
            </div>

            <div class="sidebar-section">
                <h3>Quick Access</h3>
                <ul>
                    <li><a href="booklist.php">Book List</a></li>
                    <br>
                    <li><a href="cart.php">Cart</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="Home.html">Home</a></li>
					<br>
                    <li><a href="resources.php">My Library</a></li>
                    <br>
					<li><a href="donate.php">Donate Books</a></li>
                    <br>
					<li><strong>Help Center</strong></li>
						<ul style="list-style-type:none;">
							<li>Email: librarian@chitkarauniversity.edu.in</li>
							<li>Phone: +91.01795-661028</li>
						</ul>
                </ul>
            </div>
        </div>
    </div>

    <button class="sidebar-toggle" id="sidebarToggle" title="Quick Access">▶</button>

    <div class="mobile-footer-nav">
        <button onclick="toggleSidebar()">📍 Location</button>
        <button>🔍 Search</button>
        <button>⚙️ Menu</button>
    </div>
<script>
		function toggleSidebar() {
			const sidebar = document.getElementById('sidebar');
			sidebar.classList.toggle('active');
		}

		document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);

		// Optional: Close sidebar when clicking outside
		document.addEventListener('click', function(event) {
			const sidebar = document.getElementById('sidebar');
			const sidebarToggle = document.getElementById('sidebarToggle');
			
			if (!sidebar.contains(event.target) && 
				!sidebarToggle.contains(event.target) && 
				sidebar.classList.contains('active')) {
				toggleSidebar();
			}
		});
</script>	
</body>
</html>
