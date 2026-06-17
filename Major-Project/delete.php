<?php
include('includes/header.inc');
include('includes/nav.inc');
require('includes/db_connect.inc');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['petid'])) {
    $petid = $_GET['petid'];
    
    // Fetch pet details
    $stmt = $pdo->prepare("SELECT * FROM pets WHERE petid = ?");
    $stmt->execute([$petid]);
    $pet = $stmt->fetch();

    if (!$pet) {
        echo "Pet not found!";
        exit();
    }
} else {
    echo "No pet ID specified.";
    exit();
}

// Handle deletion if the user confirms
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    $stmt = $pdo->prepare("DELETE FROM pets WHERE petid = ?");
    if ($stmt->execute([$petid])) {
        header("Location: pets.php?delete=success");
        exit();
    } else {
        echo "Failed to delete pet.";
    }
}
?>

<main>
    <?php if (isset($_GET['delete']) && $_GET['delete'] === 'success'): ?>
        <div class="alert alert-success text-center" role="alert">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            Pet deleted successfully!
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="mb-4 d-flex justify-content-start align-items-center">
            <!-- Display Pet Image with .jpeg and .jpg Extensions -->
            <?php
            $imageFileName = pathinfo($pet['image'], PATHINFO_FILENAME); // Get filename without extension
            $imagePathJpeg = 'images/' . $imageFileName . '.jpeg'; // Check for .jpeg
            $imagePathJpg = 'images/' . $imageFileName . '.jpg'; // Check for .jpg
            
            // Determine which file exists
            if (file_exists($imagePathJpeg)) {
                $imagePath = $imagePathJpeg;
            } elseif (file_exists($imagePathJpg)) {
                $imagePath = $imagePathJpg;
            } else {
                $imagePath = null; // No valid image file found
            }

            if ($imagePath): ?>
                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>" class="img-fluid rounded" style="max-width: 500px; margin-right: 20px;">
            <?php else: ?>
                <p>Image not found. Please check that the file exists with either a .jpeg or .jpg extension.</p>
            <?php endif; ?>
        </div>

        <div class="card p-4 shadow-sm">
            <h2 class="text-center">Delete Pet</h2>
            <p>Are you sure you want to delete the following pet?</p>
            <ul>
                <li><strong>Pet Name:</strong> <?php echo htmlspecialchars($pet['petname']); ?></li>
                <li><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></li>
                <li><strong>Description:</strong> <?php echo htmlspecialchars($pet['description']); ?></li>
                <li><strong>Caption:</strong> <?php echo htmlspecialchars($pet['caption']); ?></li>
                <li><strong>Age (months):</strong> <?php echo htmlspecialchars($pet['age']); ?></li>
                <li><strong>Location:</strong> <?php echo htmlspecialchars($pet['location']); ?></li>
            </ul>
            
            <form action="delete.php?petid=<?php echo $petid; ?>" method="POST" class="text-center mt-4">
                <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete Pet</button>
                <a href="pets.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
