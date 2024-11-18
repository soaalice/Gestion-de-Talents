<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'] ?? null;
    $dob = $_POST['dob'];
    $idrole = $_POST['role'];

    if ($user->register2($name, $email, $password, $phone, $dob,$idrole)) {
        $user->login($email, $password); // Connexion automatique après l'inscription
        header('Location: index.php');
        exit;
    } else {
        echo "<p class='text-danger text-center'>Registration failed. Email may already be in use.</p>";
    }
}

 // Récupérer les rôles à afficher dans le formulaire
 $roles = $user->getRoles();

include 'header.php';
?>
<div class="container p-5" style="background-color: #eaf4f0; padding-top: 80px;"> <!-- Fond léger avec padding-top pour espacer du nav -->
    <div class="d-flex justify-content-center align-items-start" style="min-height: auto;">
        <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%; border-radius: 15px; background-color: #d2f1d4; border: 1px solid #6fa37d;">
            <h1 class="display-4 text-center mb-4" style="color: #3a6a40;">Create an Account</h1>

            <form method="post" action="index.php?page=register">
                <div class="mb-3">
                    <label for="name" class="form-label" style="font-weight: bold; color: #3a6a40;">Name:</label>
                    <input type="text" name="name" class="form-control" id="name" style="border-radius: 10px; border: 1px solid #6fa37d;" required>
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label" style="font-weight: bold; color: #3a6a40;">Email:</label>
                    <input type="email" name="email" class="form-control" id="email" style="border-radius: 10px; border: 1px solid #6fa37d;" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label" style="font-weight: bold; color: #3a6a40;">Password:</label>
                    <input type="password" name="password" class="form-control" id="password" style="border-radius: 10px; border: 1px solid #6fa37d;" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label" style="font-weight: bold; color: #3a6a40;">Phone (Optional):</label>
                    <input type="text" name="phone" class="form-control" id="phone" style="border-radius: 10px; border: 1px solid #6fa37d;">
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label" style="font-weight: bold; color: #3a6a40;">Date of Birth:</label>
                    <input type="date" name="dob" class="form-control" id="dob" style="border-radius: 10px; border: 1px solid #6fa37d;" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label" style="font-weight: bold; color: #3a6a40;">Role:</label>
                    <select name="role" class="form-control" id="role" style="border-radius: 10px; border: 1px solid #6fa37d;" required>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= htmlspecialchars($role['id']) ?>"><?= htmlspecialchars($role['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <button type="submit" class="btn btn-success btn-lg w-100" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); background-color: #6fa37d; border: none;">Register</button>
            </form>


            <div class="text-center mt-3">
                <a href="index.php?page=login" class="btn btn-link" style="color: #3a6a40;">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>
