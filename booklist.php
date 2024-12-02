<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Initialize cart in session if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding books to cart
if (isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id'];
    if (!in_array($book_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $book_id;
    }
}

// Sample book data
$books = [
    ['id' => 1, 'title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen', 'category' => 'Computer Science', 'availability' => 5],
    ['id' => 2, 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'category' => 'Programming', 'availability' => 3],
    ['id' => 3, 'title' => 'The Psychology of Money', 'author' => 'Morgan Housel', 'category' => 'Finance', 'availability' => 7],
    ['id' => 4, 'title' => 'Sapiens: A Brief History of Humankind', 'author' => 'Yuval Noah Harari', 'category' => 'History', 'availability' => 4],
    ['id' => 5, 'title' => 'Deep Work', 'author' => 'Cal Newport', 'category' => 'Productivity', 'availability' => 6]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book List - Chitkara University Library</title>
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
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
<div class="sidebar-nav" id="sidebar">
        <div class="sidebar-content">
            <div class="sidebar-section">
                <h3>Current Page</h3>
                <p id="current-page">Book List</p>
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
    <style>
        .book-row {
            position: relative;
        }
        #book-hover-tooltip {
            position: fixed;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 15px;
            z-index: 1000;
            width: 300px;
            border-radius: 10px;
            display: none;
            pointer-events: none;
        }
        #book-hover-tooltip img {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltip = document.getElementById('book-hover-tooltip');
        const bookTitles = document.querySelectorAll('.book-row');

        bookTitles.forEach(row => {
            const title = row.querySelector('td:first-child');
            const bookDetails = row.querySelector('.book-hover-details');

            if (bookDetails) {
                title.addEventListener('mousemove', function(e) {
                    // Copy book details to tooltip
                    tooltip.innerHTML = bookDetails.innerHTML;
                    
                    // Position tooltip near cursor
                    tooltip.style.display = 'block';
                    tooltip.style.left = (e.clientX + 10) + 'px';
                    tooltip.style.top = (e.clientY + 10) + 'px';
                });

                title.addEventListener('mouseleave', function() {
                    tooltip.style.display = 'none';
                });
            }
        });
    });
    </script>
    <section class="blist">
        <h1>Book List</h1>
        <div style="background-color: rgba(5, 5, 5, 0.6); padding: 20px; border-radius: 10px; color: white; outline: 2px solid white">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                    <tr class="book-row">
                        <td>
                            <?php echo htmlspecialchars($book['title']); ?>
                            <div id="book-hover-tooltip">
                                <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Book Cover">
                                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                                <p><?php echo htmlspecialchars($book['synopsis']); ?></p>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['category']); ?></td>
                        <td><?php echo $book['availability']; ?> copies</td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <button type="submit" name="add_to_cart" class="cart-button">Add to Cart</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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

</body>
</html>
