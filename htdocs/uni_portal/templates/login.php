<?php
if (isPostRequest() && isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ?? '';
  $password = $_POST['password'] ?? '';

  // Βασικό server validation
  if (!$username || !$password) {
    setError("Συμπληρώστε όλα τα πεδία");
  } else {
    try {
      // SQL ερώτημα για την αναζήτηση του χρήστη με βάση το username
      $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
      $stmt->execute([$username]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Επιβεβαίωση χρήστη και κωδικού πρόσβασης
      if ($user && password_verify($password, $user['password'])) {
        // console log
        echo "<script>console.log('_SESSION');</script>";

        // Αποθήκευση στοιχείων χρήστη σε session
        setUserId($user['id']);
        setUserRole($user['role']);

        setSuccess("Επιτυχής είσοδος!");
        // Ανακατεύθυνση
        redirectTo(BASE_URL);
      } else {
        setError("Λάθος email ή κωδικός");
      }
    } catch (PDOException $e) {
      setError("Σφάλμα σύνδεσης. Δοκιμάστε ξανά αργότερα.");
    }
  }
}
?>

<!-- Wrapper -->
<main class="container login">
  <!-- Title -->
  <h1 class="title text-center">Είσοδος Χρήστη</h1>

  <!-- Form -->
  <form action="<?php echo BASE_URL; ?>/login"
        method="post"
        class="login-wrapper">

    <!-- Username -->
    <div class="info-wrapper">
      <div class="title">Όνομα Χρήστη</div>
      <div class="input-wrapper">
        <i class="fas fa-user"></i>
        <input type="text"
               name="username"
               required
               placeholder="Πληκτρολογήστε το όνομα χρήστη" />
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
               placeholder="Πληκτρολογήστε τον κωδικό πρόσβασης" />
      </div>
    </div>

    <!-- Submit -->
    <div class="submit-wrapper mt-3">
      <button type="submit"
              name="login"
              class="cta-button">
        Είσοδος
      </button>
    </div>
  </form>

  <!-- Register Link -->
  <div class="register-link text-center mt-5">
    <span>Δεν έχετε λογαριασμό;</span>
    <a href="<?php echo BASE_URL; ?>/register">
      Εγγραφείτε εδώ.
    </a>
  </div>
</main>