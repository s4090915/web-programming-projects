<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

include('includes/header.inc'); 
include('includes/nav.inc'); 
require('includes/db_connect.inc'); 

// Handle the form submission when the user adds a pet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $petname = trim($_POST['petname']);
    $type = trim($_POST['type']);
    $description = trim($_POST['description']);
    $caption = trim($_POST['caption']);
    $age = trim($_POST['age']);
    $location = trim($_POST['location']);
    $username = $_SESSION['username']; // Get the logged-in username

    // Handle the uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (in_array($fileType, $allowedTypes)) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $target_dir = "images/";
            $uniqueName = uniqid('pet_', true) . '.' . $extension;
            $target_file = $target_dir . $uniqueName;

            // Move the file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Store the unique file name in the database
                $image = $uniqueName;
            } else {
                echo "Error uploading image.";
                exit();
            }
        } else {
            echo "Invalid image format. Please upload a JPEG or PNG image.";
            exit();
        }
    } else {
        echo "Please select an image.";
        exit();
    }

    // Insert the pet record into the database
    $stmt = $pdo->prepare("INSERT INTO pets (petname, type, description, image, caption, age, location, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$petname, $type, $description, $image, $caption, $age, $location, $username])) {
        header("Location: add.php?add=success");
        exit();
    } else {
        echo "Failed to add the pet. Please try again.";
    }
}
?>

<main class="container mt-5">
    <!-- Display Success Message if a New Pet Was Added Successfully -->
    <?php if (isset($_GET['add']) && $_GET['add'] === 'success'): ?>
        <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert" style="font-size: 1rem; margin-top: 1rem;">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            New pet added successfully!
        </div>
    <?php endif; ?>

    <div class="addpet">
        <h2>Add a Pet</h2>
        <form action="add.php" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
            <div class="form-group mb-3">
                <label for="petname">Pet Name: <span class="required">*</span></label>
                <input type="text" id="petname" name="petname" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="type">Type: <span class="required">*</span></label>
                <select id="type" name="type" class="form-select" required>
                    <option value="">--Choose an option--</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description: <span class="required">*</span></label>
                <textarea id="description" name="description" rows="4" class="form-control" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="image">Select an Image: <span class="required">*</span></label>
                <input type="file" id="image" name="image" accept="image/*" class="form-control" required>
                <small class="note">Max image size: 500KB</small>
            </div>
            <div class="form-group mb-3">
                <label for="caption">Image Caption: <span class="required">*</span></label>
                <input type="text" id="caption" name="caption" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="age">Age (months): <span class="required">*</span></label>
                <input type="number" id="age" name="age" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="location">Location: <span class="required">*</span></label>
                <input type="text" id="location" name="location" class="form-control" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
            </div>
        </form>
    </div>

    <hr>

    <!-- Section to List Current Pets with Edit and Delete Options -->
    <div class="pet-list">
        <h2>Current Pets</h2>
        <?php
        // Fetch all pets from the database
        $stmt = $pdo->query("SELECT * FROM pets");
        $pets = $stmt->fetchAll();

        if ($pets): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Pet Name</th>
                        <th>Type</th>
                        <th>Age (months)</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pets as $pet): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pet['petname']); ?></td>
                            <td><?php echo htmlspecialchars($pet['type']); ?></td>
                            <td><?php echo htmlspecialchars($pet['age']); ?></td>
                            <td><?php echo htmlspecialchars($pet['location']); ?></td>
                            <td>
                                <!-- Edit and Delete Links -->
                                <a href="edit.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pets found. Add a new pet to get started.</p>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
