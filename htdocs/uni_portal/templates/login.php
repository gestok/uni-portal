<?php
if (isPostRequest() && isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ?? '';
  $password = $_POST['password'] ?? '';

  if (loginUser($username, $password)) {
    // Ανακατεύθυνση
    redirectTo(BASE_URL);
  }
}
?>

<main class="container login">
  <!-- Τίτλος -->
  <div class="title text-center">Είσοδος Χρήστη</div>

  <!-- Φόρμα -->
  <form action="<?php echo BASE_URL; ?>/login"
        method="post"
        class="form-wrapper">

    <!-- Username -->
    <div class="input-wrapper">
      <i class="fa-solid fa-user icon"></i>
      <input type="text"
             name="username"
             required
             placeholder="Πληκτρολογήστε το όνομα χρήστη" />
    </div>

    <!-- Password -->
    <div class="input-wrapper">
      <i class="fa-solid fa-lock icon"></i>
      <input type="password"
             name="password"
             required
             placeholder="Πληκτρολογήστε τον κωδικό πρόσβασης" />
    </div>

    <!-- Submit -->
    <button type="submit"
            name="login"
            class="btn secondary inline">
      Είσοδος
    </button>
  </form>

  <!-- Register Link -->
  <div class="register-link text-center mt-3">
    <span>Δεν έχετε λογαριασμό;</span>
    <a href="<?php echo BASE_URL; ?>/register">
      Εγγραφείτε εδώ.
    </a>
  </div>
</main>