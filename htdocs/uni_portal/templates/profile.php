<?php

// Φόρτωση προφίλ χρήστη
$profile = [];
try {
  // Φόρτωση στοιχείων προφίλ από τη βάση δεδομένων
  $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $profile = $stmt->fetch(PDO::FETCH_ASSOC);

  // Φόρτωση email από τη βάση δεδομένων
  $stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $profile['email'] = $stmt->fetchColumn();
} catch (PDOException $e) {
  $error = "Σφάλμα φόρτωσης προφίλ: " . $e->getMessage();
}

// Επεξεργασία υποβολής φόρμας
if (isPostRequest() && isset($_POST['save_profile'])) {
  // Ονοματεπώνυμο
  $fullname = trim(filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING));
  // Επαγγελματική ιδιότητα
  $job = trim(filter_input(INPUT_POST, 'job', FILTER_SANITIZE_STRING));
  // Email
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  // Τηλέφωνο
  $mobile = trim(filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING));
  // Social Media Links
  $facebook = trim(filter_input(INPUT_POST, 'facebook', FILTER_SANITIZE_URL));
  $twitter = trim(filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_URL));
  $linkedin = trim(filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_URL));
  $instagram = trim(filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_URL));
  $youtube = trim(filter_input(INPUT_POST, 'youtube', FILTER_SANITIZE_URL));

  try {
    // Ενημέρωση των στοιχείων στο profiles table ή εισαγωγή αν δεν υπάρχει
    $sql = "INSERT INTO profiles (user_id, fullname, job, mobile, facebook, twitter, linkedin, instagram, youtube)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            fullname = VALUES(fullname),
            job = VALUES(job),
            mobile = VALUES(mobile),
            facebook = VALUES(facebook),
            twitter = VALUES(twitter),
            linkedin = VALUES(linkedin),
            instagram = VALUES(instagram),
            youtube = VALUES(youtube)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      $_SESSION['user_id'],
      $fullname,
      $job,
      $mobile,
      $facebook,
      $twitter,
      $linkedin,
      $instagram,
      $youtube
    ]);

    // Ενημέρωση του email στο users table
    $sql = "UPDATE users SET email = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $_SESSION['user_id']]);

    // Ενημέρωση μηνύματος επιτυχίας και ανακατεύθυνση
    $_SESSION['success'] = "Τα στοιχεία αποθηκεύτηκαν επιτυχώς!";
    header("Location: " . $base_url . "/profile");
    exit();

  } catch (PDOException $e) {
    $error = "Σφάλμα αποθήκευσης: " . $e->getMessage();
  }
}
?>

<main class="container profile-page">
  <form method="post"
        class="profile-wrapper">
    <!-- Μήνυμα επιτυχίας -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="success-message">
        <?php echo $_SESSION['success']; ?>
        <?php unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <!-- Μήνυμα σφάλματος -->
    <?php if ($error): ?>
      <div class="error-message">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <!-- Βασικά Στοιχεία -->
    <div class="basic-wrapper">

      <!-- Τίτλος -->
      <div class="title">Βασικά Στοιχεία</div>

      <!-- Φόρμα -->
      <div class="inputs-wrapper">

        <!-- Ονοματεπώνυμο -->
        <div class="input-wrapper">
          <i class="fas fa-user"></i>
          <input type="text"
                 name="fullname"
                 value="<?php echo htmlspecialchars($profile['fullname'] ?? ''); ?>"
                 placeholder="Ονοματεπώνυμο" />
        </div>

        <!-- Επαγγελματική Ιδιότητα -->
        <div class="input-wrapper">
          <i class="fas fa-graduation-cap"></i>
          <input type="text"
                 name="job"
                 value="<?php echo htmlspecialchars($profile['job'] ?? ''); ?>"
                 placeholder="Επαγγελματική ιδιότητα" />
        </div>

        <!-- Email -->
        <div class="input-wrapper">
          <i class="fas fa-envelope"></i>
          <input type="email"
                 name="email"
                 value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>"
                 placeholder="Email" />
        </div>

        <!-- Τηλέφωνο -->
        <div class="input-wrapper">
          <i class="fas fa-phone"></i>
          <input type="tel"
                 name="mobile"
                 value="<?php echo htmlspecialchars($profile['mobile'] ?? ''); ?>"
                 placeholder="Τηλέφωνο" />
        </div>
      </div>
    </div>

    <!-- Social Media -->
    <div class="social-wrapper mt-3">

      <!-- Τίτλος -->
      <div class="title">Social</div>

      <!-- Φόρμα -->
      <div class="inputs-wrapper">

        <!-- Facebook -->
        <div class="input-wrapper">
          <i class="fab fa-facebook-f"></i>
          <input type="text"
                 name="facebook"
                 value="<?php echo htmlspecialchars($profile['facebook'] ?? ''); ?>"
                 placeholder="URL Facebook" />
        </div>

        <!-- Twitter -->
        <div class="input-wrapper">
          <i class="fab fa-twitter"></i>
          <input type="text"
                 name="twitter"
                 value="<?php echo htmlspecialchars($profile['twitter'] ?? ''); ?>"
                 placeholder="URL Twitter/X" />
        </div>

        <!-- LinkedIn -->
        <div class="input-wrapper">
          <i class="fab fa-linkedin-in"></i>
          <input type="text"
                 name="linkedin"
                 value="<?php echo htmlspecialchars($profile['linkedin'] ?? ''); ?>"
                 placeholder="URL LinkedIn" />
        </div>

        <!-- Instagram -->
        <div class="input-wrapper">
          <i class="fab fa-instagram"></i>
          <input type="text"
                 name="instagram"
                 value="<?php echo htmlspecialchars($profile['instagram'] ?? ''); ?>"
                 placeholder="URL Instagram" />
        </div>

        <!-- YouTube -->
        <div class="input-wrapper">
          <i class="fab fa-youtube"></i>
          <input type="text"
                 name="youtube"
                 value="<?php echo htmlspecialchars($profile['youtube'] ?? ''); ?>"
                 placeholder="URL Youtube" />
        </div>
      </div>
    </div>

    <!-- Αποθήκευση -->
    <div class="submit-wrapper mt-3">
      <button type="submit"
              name="save_profile"
              class="cta-button">
        Αποθήκευση
      </button>
    </div>
  </form>
</main>