<?php
$title = "Login";
include('includes/header.inc');
include('includes/nav.inc');
?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Login</h2>
        <form action="login_process.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Error Message -->
            <?php if (isset($_GET['error']) && $_GET['error'] === 'incorrect'): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert" style="font-size: 0.9rem;">
                    <i class="fa fa-times me-2" aria-hidden="true"></i>
                    Incorrect login. Please try again.
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</main>

<?php
include('includes/footer.inc');
?>
