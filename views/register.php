<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'] ?? null;
    $dob = $_POST['dob'];
    $roleId = $_POST['role']; // Récupération de l'ID du rôle

    if ($user->register($name, $email, $password, $phone, $dob, $roleId)) {
        $user->login($email, $password); // Connexion automatique après l'inscription
        header('Location: index.php');
        exit;
    } else {
        echo "<p>Registration failed. Email may already be in use.</p>";
    }
}

?>

<?php
    // Récupérer les rôles à afficher dans le formulaire
    $roles = $user->getRoles();
?>

<form method="post" action="index.php?page=register">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Phone (Optional):</label><br>
    <input type="text" name="phone"><br><br>

    <label>Date of Birth:</label><br>
    <input type="date" name="dob" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?= htmlspecialchars($role['id']) ?>"><?= htmlspecialchars($role['nom']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Register">
</form>