<?php
// Start session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/header.inc'); 
include('includes/nav.inc'); 
require('includes/db_connect.inc'); 

// Fetch the username from the session
$username = $_SESSION['username'] ?? '';

// Fetch pets uploaded by the logged-in user
$stmt = $pdo->prepare("SELECT * FROM pets WHERE username = ?");
$stmt->execute([$username]);
$pets = $stmt->fetchAll();
?>

<main class="container mt-5">
    <h2><?php echo htmlspecialchars($username); ?>'s Pets</h2>

    <?php if ($pets): ?>
        <table class="table table-bordered">
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
                            <a href="edit.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pets uploaded yet. You can add a pet <a href="add.php">here</a>.</p>
    <?php endif; ?>
</main>

<?php include('includes/footer.inc'); ?>
