<?php
include 'includes/db_connect.inc';
include 'includes/header.inc';
include 'includes/nav.inc';

// Fetch pets information from the database
$query = "SELECT petid, petname, image FROM pets";
$result = $pdo->query($query);
?>

<main>
    <div class="gallery-container">
        <h2>Pets Victoria has a lot to offer!</h2>
        <p>For almost two decades, Pets Victoria has helped in creating true social change by bringing pet adoption into the mainstream. Our work has helped make a difference to the Victorian rescue community and thousands of pets in need of rescue and rehabilitation. But, until every pet is safe, respected, and loved, we all still have big, hairy work to do.</p>
        
        <div class="gallery">
            <?php while ($row = $result->fetch()): ?>
            <div class="gallery-item">
                <a href="details.php?id=<?php echo $row['petid']; ?>">
                    <img src="images/<?php echo str_replace('.jpg', '.jpeg', $row['image']); ?>" alt="<?php echo $row['petname']; ?>">
                    <div class="name"><?php echo $row['petname']; ?></div>
                    <div class="overlay">
                        <i class="material-icons">search</i>
                        <span class="discover">Discover more!</span>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php
include 'includes/footer.inc';
?>
