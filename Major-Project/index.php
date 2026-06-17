<?php
$title = "Home";
include('includes/header.inc');
include('includes/nav.inc');
require('includes/db_connect.inc'); // Connect to the database
?>
<body class="index-page"></body>

<main>
<?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
        <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert" style="font-size: 1rem; margin-top: 1rem;">
            <i class="fa fa-check me-2" aria-hidden="true"></i>
            Login successful! Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>.
        </div>
    
    <?php endif; ?>
    <!-- Top Section with Background Color -->
    <div class="top-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Carousel Section -->
                <div class="col-md-6 text-center">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="images/cat1.jpeg" class="d-block w-100" alt="Playful kitten" style="border-radius: 8px;">
                            </div>
                            <div class="carousel-item">
                                <img src="images/dog1.jpeg" class="d-block w-100" alt="Loyal dog" style="border-radius: 8px;">
                            </div>
                            <div class="carousel-item">
                                <img src="images/cat2.jpeg" class="d-block w-100" alt="Calm cat" style="border-radius: 8px;">
                            </div>
                            <div class="carousel-item">
                                <img src="images/dog2.jpeg" class="d-block w-100" alt="Playful puppy" style="border-radius: 8px;">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Title Section -->
                <div class="col-md-6">
                    <h1 class="title-text">PETS VICTORIA</h1>
                    <h2 class="subtitle-text">WELCOME TO PET ADOPTION</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section with White Background -->
    <div class="container">
        <!-- Search Bar and Pet Type Filter -->
        <div class="search-section my-4">
            <form action="search.php" method="GET" class="d-flex justify-content-center">
                <input type="text" name="keyword" class="form-control me-2" placeholder="I am looking for ..." style="max-width: 250px;">
                <select name="type" class="form-select me-2" style="max-width: 250px;">
                    <option value="">Select your pet type</option>
                    <option value="Cat">Cat</option>
                    <option value="Dog">Dog</option>
                </select>
                <button type="submit" class="btn btn-primary" style="max-width: 100px;">Search</button>
            </form>
        </div>

        <!-- Description Section -->
        <div class="description-section mt-4">
            <h3>Discover Pets Victoria</h3>
            <p>Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds.</p>
            <p>The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.</p>
        </div>
    </div>
</main>

<?php
include('includes/footer.inc');
?>
