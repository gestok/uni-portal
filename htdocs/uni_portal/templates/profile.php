<?php
// Επεξεργασία υποβολής φόρμας
if (isPostRequest() && isset($_POST['save_profile'])) {
  $profileData = [
    'fullname' => $_POST['fullname'] ?? '',
    'job' => $_POST['job'] ?? '',
    'email' => $_POST['email'] ?? '',
    'mobile' => $_POST['mobile'] ?? '',
    'facebook' => $_POST['facebook'] ?? '',
    'twitter' => $_POST['twitter'] ?? '',
    'linkedin' => $_POST['linkedin'] ?? '',
    'instagram' => $_POST['instagram'] ?? '',
    'youtube' => $_POST['youtube'] ?? ''
  ];

  saveUserProfile($profileData);
}
// Φόρτωση προφίλ χρήστη
$profile = getUserProfile();
?>

<main class="container mt-3 mb-3">
  <form method="post"
        class="profile-wrapper">

    <!-- Ονοματεπώνυμο -->
    <label class="input-wrapper">
      <i class="icon fas fa-user"></i>
      <input type="text"
             name="fullname"
             value="<?php echo htmlspecialchars($profile['fullname'] ?? ''); ?>"
             placeholder="Ονοματεπώνυμο" />
    </label>

    <!-- Επαγγελματική Ιδιότητα -->
    <label class="input-wrapper">
      <i class="icon fas fa-graduation-cap"></i>
      <input type="text"
             name="job"
             value="<?php echo htmlspecialchars($profile['job'] ?? ''); ?>"
             placeholder="Επαγγελματική ιδιότητα" />
    </label>

    <!-- Email -->
    <label class="input-wrapper">
      <i class="icon fas fa-envelope"></i>
      <input type="email"
             name="email"
             value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>"
             placeholder="Email" />
    </label>

    <!-- Τηλέφωνο -->
    <label class="input-wrapper">
      <i class="icon fas fa-phone"></i>
      <input type="tel"
             name="mobile"
             value="<?php echo htmlspecialchars($profile['mobile'] ?? ''); ?>"
             placeholder="Τηλέφωνο" />
    </label>

    <!-- Facebook -->
    <label class="input-wrapper">
      <i class="icon fab fa-facebook-f"></i>
      <input type="text"
             name="facebook"
             value="<?php echo htmlspecialchars($profile['facebook'] ?? ''); ?>"
             placeholder="URL Facebook" />
    </label>

    <!-- Twitter -->
    <label class="input-wrapper">
      <i class="icon fab fa-twitter"></i>
      <input type="text"
             name="twitter"
             value="<?php echo htmlspecialchars($profile['twitter'] ?? ''); ?>"
             placeholder="URL Twitter/X" />
    </label>

    <!-- LinkedIn -->
    <label class="input-wrapper">
      <i class="icon fab fa-linkedin-in"></i>
      <input type="text"
             name="linkedin"
             value="<?php echo htmlspecialchars($profile['linkedin'] ?? ''); ?>"
             placeholder="URL LinkedIn" />
    </label>

    <!-- Instagram -->
    <label class="input-wrapper">
      <i class="icon fab fa-instagram"></i>
      <input type="text"
             name="instagram"
             value="<?php echo htmlspecialchars($profile['instagram'] ?? ''); ?>"
             placeholder="URL Instagram" />
    </label>

    <!-- YouTube -->
    <label class="input-wrapper">
      <i class="icon fab fa-youtube"></i>
      <input type="text"
             name="youtube"
             value="<?php echo htmlspecialchars($profile['youtube'] ?? ''); ?>"
             placeholder="URL Youtube" />
    </label>

    <!-- Αποθήκευση -->
    <button type="submit"
            name="save_profile"
            class="btn secondary inline">
      Αποθήκευση
    </button>
  </form>
</main>