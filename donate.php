<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Handle book donation submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $isbn = $_POST['isbn'];
    $publication_year = $_POST['publication_year'];

    // Validate input
    $errors = [];
    if (empty($title)) $errors[] = "Title is required";
    if (empty($author)) $errors[] = "Author is required";
    if (empty($category)) $errors[] = "Category is required";

    // If no errors, insert book
    if (empty($errors)) {
        $query = "INSERT INTO books (title, author, category, isbn, publication_year, availability) 
                  VALUES ('$title', '$author', '$category', '$isbn', '$publication_year', 1)";
        
        if (mysqli_query($con, $query)) {
            $success_message = "Book donated successfully!";
        } else {
            $error_message = "Error donating book: " . mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Donation - Chitkara University Library</title>
    <link rel="stylesheet" href="Project.css">
</head>
<body class="donate">
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
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
<div class="sidebar-nav" id="sidebar">
        <div class="sidebar-content">
            <div class="sidebar-section">
                <h3>Current Page</h3>
                <p id="current-page">Book Donation</p>
            </div>

            <div class="sidebar-section">
                <h3>Quick Access</h3>
                <ul>
                    <li><a href="booklist.php">Book List</a></li>
                    <br>
                    <li><a href="cart.php">Cart</a></li>
					<br>
					<li><a href="logout.php">Log Out</a></li>
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
<div>
    <section>
        <h2 class="donate-head">Donate a Book</h2>
        <div class="dono-form">
            <?php 
            if (!empty($errors)) {
                echo "<div class='error'>";
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
                echo "</div>";
            }
            
            if (isset($success_message)) {
                echo "<div class='success'>$success_message</div>";
            }
            ?>

            <form method="post" action="">
                <div>
                    <label>Book Title:</label>
                    <input type="text" name="title" required>
                </div>
                <div>
                    <label>Author:</label>
                    <input type="text" name="author" required>
                </div>
                <div>
                    <label>Category:</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Fiction">Fiction</option>
                        <option value="Non-Fiction">Non-Fiction</option>
                        <option value="Science">Science</option>
                        <option value="History">History</option>
                    </select>
                </div>
                <div>
                    <label>ISBN:</label>
                    <input type="text" name="isbn">
                </div>
                <div>
                    <label>Publication Year:</label>
                    <input type="number" name="publication_year" min="1800" max="2024">
                </div>
                <button type="submit" class="dono-button">Donate Book</button>
            </form>
        </div>
    </section>
</div>
</body>
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

</html>
