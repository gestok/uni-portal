<?php
if (isPostRequest() && isset($_POST['register'])) {
  $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (registerUser($username, $email, $password, $confirm_password)) {
    // Ανακατεύθυνση
    redirectTo(BASE_URL . "/login");
  }
}
?>

<main class="container register">
  <div class="title text-center">Εγγραφή Χρήστη</div>

  <!-- Φόρμα -->
  <form method="post"
        class="form-wrapper">
    <!-- Username -->
    <div class="input-wrapper">
      <i class="fa-solid fa-user icon"></i>
      <input type="text"
             name="username"
             value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
             required
             placeholder="Πληκτρολογήστε το όνομα χρήστη *">
    </div>

    <!-- Email -->
    <div class="input-wrapper">
      <i class="fa-solid fa-envelope icon"></i>
      <input type="email"
             name="email"
             value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
             required
             placeholder="Πληκτρολογήστε το email σας *">
    </div>

    <!-- Password -->
    <label class="input-wrapper">
      <i class="fa-solid fa-lock icon"></i>
      <input type="password"
             name="password"
             minlength="10"
             pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}"
             required
             placeholder="Πληκτρολογήστε τον κωδικό πρόσβασης *">
      <hint class="hint">
        Ο κωδικός πρόσβασης πρέπει να έχει τουλάχιστον 10 χαρακτήρες, 1 αριθμό, 1 πεζό γράμμα, 1
        κεφαλαίο γράμμα και 1 ειδικό χαρακτήρα.
      </hint>
    </label>

    <!-- Επιβεβαίωση Password -->
    <div class="input-wrapper">
      <i class="fa-solid fa-lock icon"></i>
      <input type="password"
             name="confirm_password"
             minlength="10"
             pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}"
             required
             placeholder="Επιβεβαιώστε τον κωδικό πρόσβασης *">
    </div>

    <!-- Submit -->
    <button type="submit"
            name="register"
            class="btn primary inline">
      Εγγραφή
    </button>
  </form>
</main>