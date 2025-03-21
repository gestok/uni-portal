<?php
$error = '';
$success = '';

if (isPostRequest() && isset($_POST['register'])) {
  // Καθαρισμός των inputs
  $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Βασικός έλεγχος
  if (empty($username) || empty($email) || empty($password)) {
    $error = "Συμπληρώστε όλα τα υποχρεωτικά πεδία";
  } elseif ($password !== $confirm_password) {
    $error = "Οι κωδικοί δεν ταιριάζουν";
  } elseif (strlen($password) < 8) {
    $error = "Ο κωδικός πρέπει να έχει τουλάχιστον 8 χαρακτήρες";
  } else {
    try {
      // Έλεγχος αν υπάρχει ήδη ο χρήστης
      $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
      $stmt->execute([$username, $email]);

      if ($stmt->rowCount() > 0) {
        $error = "Το username ή email χρησιμοποιείται ήδη";
      } else {
        // Καταχώρηση νέου χρήστη
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'student'; // Προεπιλεγμένος ρόλος

        $insert_stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $insert_stmt->execute([$username, $email, $hashed_password, $role]);

        $success = "Επιτυχής εγγραφή! Μπορείτε να συνδεθείτε.";
        header("Refresh: 2; url=" . $base_url . "/login");
      }
    } catch (PDOException $e) {
      $error = "Σφάλμα συστήματος: " . $e->getMessage();
    }
  }
}
?>

<!-- HTML Form -->
<main class="container register">
  <h1 class="title text-center">Εγγραφή Χρήστη</h1>

  <?php if ($error): ?>
    <div class="error-message"><?php echo $error; ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="success-message"><?php echo $success; ?></div>
  <?php endif; ?>

  <form method="post"
        class="register-wrapper">
    <!-- Username -->
    <div class="info-wrapper">
      <div class="title">Όνομα Χρήστη</div>
      <div class="input-wrapper">
        <i class="fas fa-user"></i>
        <input type="text"
               name="username"
               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
               required
               placeholder="Πληκτρολογήστε το όνομα χρήστη">
      </div>
    </div>

    <!-- Email -->
    <div class="info-wrapper">
      <div class="title">Email</div>
      <div class="input-wrapper">
        <i class="fas fa-envelope"></i>
        <input type="email"
               name="email"
               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
               required
               placeholder="Πληκτρολογήστε το email σας">
      </div>
    </div>

    <!-- Password -->
    <div class="info-wrapper">
      <div class="title">Κωδικός Πρόσβασης</div>
      <div class="input-wrapper">
        <i class="fas fa-lock"></i>
        <input type="password"
               name="password"
               required
               placeholder="Πληκτρολογήστε τον κωδικό πρόσβασης">
      </div>
    </div>

    <!-- Confirm Password -->
    <div class="info-wrapper">
      <div class="title">Επιβεβαίωση Κωδικού</div>
      <div class="input-wrapper">
        <i class="fas fa-lock"></i>
        <input type="password"
               name="confirm_password"
               required
               placeholder="Επιβεβαιώστε τον κωδικό πρόσβασης">
      </div>
    </div>

    <!-- Submit -->
    <div class="submit-wrapper mt-3">
      <button type="submit"
              name="register"
              class="cta-button">
        Εγγραφή
      </button>
    </div>
  </form>
</main>