<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->login($email, $password)) {
        header('Location: index.php');
        exit;
    } else {
        echo "<p class='text-danger text-center'>Invalid email or password.</p>";
    }
}
?>
<div class="container p-5" style="background-color: #eaf4f0; padding-top: 80px;"> <!-- Fond léger avec padding-top pour espacer du nav -->
    <div class="d-flex justify-content-center align-items-start" style="min-height: auto;">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 15px; background-color: #d2f1d4; border: 1px solid #6fa37d;">
            <h1 class="display-4 text-center mb-4" style="color: #3a6a40;">Login</h1>

            <form method="post" action="index.php?page=login">
                <div class="mb-3">
                    <label for="email" class="form-label" style="font-weight: bold; color: #3a6a40;">Email:</label>
                    <input type="email" name="email" class="form-control" id="email" style="border-radius: 10px; border: 1px solid #6fa37d;" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label" style="font-weight: bold; color: #3a6a40;">Password:</label>
                    <input type="password" name="password" class="form-control" id="password" style="border-radius: 10px; border: 1px solid #6fa37d;" required>
                </div>

                <button type="submit" class="btn btn-warning btn-lg w-100" style="border-radius: 10px; background-color: #6fa37d; border: none;">Login</button>
            </form>

            <div class="text-center mt-3">
                <a href="index.php?page=register" class="btn btn-link" style="color: #3a6a40;">Don't have an account? Register</a>
            </div>
        </div>
    </div>
</div>
