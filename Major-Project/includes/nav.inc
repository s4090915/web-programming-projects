<?php session_start(); ?>

<nav class="navbar">
    <!-- Left Side Navigation -->
    <div class="left-nav">
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo" width="70" height="70"></a>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Select an Option!</button>
            <div class="dropdown-content">
                <a href="index.php">Home</a>
                <a href="pets.php">Pets</a>
                <a href="add.php">Add/Edit/Delete</a>
                <a href="gallery.php">Gallery</a>
                <a href="search.php">Search Pets</a> <!-- Link to Search Page -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="user.php">My Pets</a> <!-- Link to User Page for logged-in users -->
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Side Navigation -->
    <div class="right-nav">
        <!-- Search Bar -->
        <form class="form-inline">
            <div class="search">
                <input type="text" placeholder="Search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>

        <!-- Authentication Links with White Box Styling -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="welcome-message">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            </div>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="register.php" class="nav-link box-link">Register</a>
            <a href="login.php" class="nav-link box-link">Login</a>
        <?php endif; ?>
    </div>
</nav>
