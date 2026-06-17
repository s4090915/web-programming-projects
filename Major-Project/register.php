<?php
$title = "Register";
include('includes/header.inc');
include('includes/nav.inc');
?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Register</h2>
        <form action="register_process.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</main>

<?php
include('includes/footer.inc');
?>
