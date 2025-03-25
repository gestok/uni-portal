<main class="container home mt-4 mb-3">

  <!-- Notification -->
  <?php if (isset($_GET['success'])): ?>
    <div class="notification success">
      <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
  <?php endif; ?>

  <!-- Title -->
  <div class="title text-center">
    Καλωσήλθατε στο Μεταπτυχιακό μας Πρόγραμμα
  </div>

  <!-- Subtitle -->
  <div class="subtitle text-center">
    Εδώ θα μάθετε πολλά!
  </div>

  <!-- Images -->
  <div class="cards-wrapper mt-3">
    <img class="card"
         src="<?php echo BASE_URL; ?>/static/image1.jpg" />
    <img class="card"
         src="<?php echo BASE_URL; ?>/static/image2.jpg" />
    <img class="card"
         src="<?php echo BASE_URL; ?>/static/image3.jpg" />
  </div>

  <!-- Buttons (εμφανίζεται μόνο σε μη συνδεδεμένους χρήστες) -->
  <?php if (!isLoggedIn()): ?>
    <div class="button-wrapper mt-3">

      <!-- Login -->
      <a href="<?php echo BASE_URL; ?>/login"
         class="btn secondary">
        Είσοδος
      </a>

      <!-- Register -->
      <a href="<?php echo BASE_URL; ?>/register"
         class="btn primary">
        Εγγραφή
      </a>
    </div>
  <?php endif; ?>
</main>