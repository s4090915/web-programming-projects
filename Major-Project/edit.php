<?php
include('includes/header.inc');
include('includes/nav.inc');
require('includes/db_connect.inc');

// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if pet ID is set in the URL
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

// Update pet details upon form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petname = $_POST['petname'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $caption = $_POST['caption'];
    $age = $_POST['age'];
    $location = $_POST['location'];

    // Update query
    $stmt = $pdo->prepare("UPDATE pets SET petname = ?, type = ?, description = ?, caption = ?, age = ?, location = ? WHERE petid = ?");
    if ($stmt->execute([$petname, $type, $description, $caption, $age, $location, $petid])) {
        header("Location: edit.php?petid=$petid&edit=success");
        exit();
    } else {
        echo "Failed to update pet details.";
    }
}
?>

<main>
    <?php if (isset($_GET['edit']) && $_GET['edit'] === 'success'): ?>
        <div class="alert alert-success text-center" role="alert">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            Pet details updated successfully!
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
                <p>Image not found. Please check the file path and file extension.</p>
            <?php endif; ?>
        </div>

        <div class="card p-4 shadow-sm">
            <h2 class="text-center">Edit Pet</h2>
            <form action="edit.php?petid=<?php echo $petid; ?>" method="POST">
                <div class="mb-3">
                    <label for="petname" class="form-label">Pet Name:</label>
                    <input type="text" id="petname" name="petname" class="form-control" value="<?php echo htmlspecialchars($pet['petname']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <select id="type" name="type" class="form-select" required>
                        <option value="Dog" <?php echo $pet['type'] == 'Dog' ? 'selected' : ''; ?>>Dog</option>
                        <option value="Cat" <?php echo $pet['type'] == 'Cat' ? 'selected' : ''; ?>>Cat</option>
                        <option value="Other" <?php echo $pet['type'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" rows="4" class="form-control" required><?php echo htmlspecialchars($pet['description']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="caption" class="form-label">Caption:</label>
                    <input type="text" id="caption" name="caption" class="form-control" value="<?php echo htmlspecialchars($pet['caption']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Age (months):</label>
                    <input type="number" id="age" name="age" class="form-control" value="<?php echo htmlspecialchars($pet['age']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location:</label>
                    <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($pet['location']); ?>" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3">Update Pet</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
