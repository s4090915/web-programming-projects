<?php
session_start(); // Start the session

include('includes/header.inc');
include('includes/nav.inc');
require('includes/db_connect.inc');

// Initialize search variables
$keyword = '';
$typeFilter = '';
$pets = [];

// Check if search is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
    $typeFilter = $_GET['type'] ?? ''; // Optional filter

    // Prepare the search query
    $query = "SELECT * FROM pets WHERE (petname LIKE ? OR description LIKE ?)";
    $params = ["%$keyword%", "%$keyword%"];

    if (!empty($typeFilter)) {
        $query .= " AND type = ?";
        $params[] = $typeFilter;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $pets = $stmt->fetchAll();
}
?>

<main>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Search Pets</h2>
        <form action="search.php" method="GET" class="d-flex mb-4">
            <input type="text" name="keyword" class="form-control me-2" placeholder="I am looking for ..." value="<?php echo htmlspecialchars($keyword); ?>" required>
            <select name="type" class="form-select me-2">
                <option value="">All Types</option>
                <option value="Dog" <?php echo $typeFilter === 'Dog' ? 'selected' : ''; ?>>Dog</option>
                <option value="Cat" <?php echo $typeFilter === 'Cat' ? 'selected' : ''; ?>>Cat</option>
                <option value="Other" <?php echo $typeFilter === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="row">
            <?php if ($pets): ?>
                <?php foreach ($pets as $pet): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <?php
                            // Define paths for the images
                            $imageFileName = pathinfo($pet['image'], PATHINFO_FILENAME);
                            $imagePathJpeg = 'images/' . $imageFileName . '.jpeg';
                            $imagePathJpg = 'images/' . $imageFileName . '.jpg';

                            // Check which image format exists
                            if (file_exists($imagePathJpeg)) {
                                $imagePath = $imagePathJpeg;
                            } elseif (file_exists($imagePathJpg)) {
                                $imagePath = $imagePathJpg;
                            } else {
                                $imagePath = 'images/default.jpg'; // Default image if none found
                            }
                            ?>
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($pet['petname']); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($pet['petname']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($pet['description']); ?></p>
                                <a href="details.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-info">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No pets found matching your search criteria.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
