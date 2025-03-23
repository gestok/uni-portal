<?php
if (isPostRequest() && isset($_POST['register'])) {
  // Καθαρισμός των inputs
  $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Βασικός έλεγχος
  if (empty($username) || empty($email) || empty($password)) {
    setError("Συμπληρώστε όλα τα υποχρεωτικά πεδία");
  } elseif ($password !== $confirm_password) {
    setError("Οι κωδικοί δεν ταιριάζουν");
  } elseif (strlen($password) < 10) {
    setError("Ο κωδικός πρέπει να έχει τουλάχιστον 10 χαρακτήρες");
  }
  // Αν ο κωδικός δεν περιέχει τουλάχιστον 1 αριθμό, 1 πεζό γράμμα, 1 κεφαλαίο γράμμα και 1 ειδικό χαρακτήρα (π.χ. !@#$%^&*)
  elseif (!preg_match('/[0-9]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[\W_]/', $password)) {
    setError("Ο κωδικός πρέπει να περιέχει τουλάχιστον 1 αριθμό, 1 πεζό γράμμα, 1 κεφαλαίο γράμμα και 1 ειδικό χαρακτήρα");
  } else {
    try {
      // Έλεγχος αν υπάρχει ήδη ο χρήστης
      $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
      $stmt->execute([$username, $email]);

      if ($stmt->rowCount() > 0) {
        setError("Το username ή email χρησιμοποιείται ήδη");
      } else {
        // Καταχώρηση νέου χρήστη
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'student'; // Προεπιλεγμένος ρόλος

        $insert_stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $insert_stmt->execute([$username, $email, $hashed_password, $role]);

        setSuccess("Επιτυχής εγγραφή! Μπορείτε να συνδεθείτε.");
        redirectTo(BASE_URL . "/login");
      }
    } catch (PDOException $e) {
      setError("Σφάλμα κατά την εγγραφή. Δοκιμάστε ξανά.");
    }
  }
}
?>

<!-- HTML Form -->
<main class="container register">
  <h1 class="title text-center">Εγγραφή Χρήστη</h1>

  <!-- Φόρμα Εγγραφής -->
  <form method="post"
        class="register-wrapper position-relative">
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

    <!-- Notification -->
    <?php include_once 'templates/notification.php'; ?>
  </form>
</main>