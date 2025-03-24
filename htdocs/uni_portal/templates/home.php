<!-- Main -->
<main class="container home">

  <!-- Notification -->
  <?php if (isset($_GET['success'])): ?>
    <div class="notification success">
      <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
  <?php endif; ?>

  <!-- Title -->
  <div class="title mt-4 text-center">
    Καλωσήλθατε στο Μεταπτυχιακό μας Πρόγραμμα
  </div>

  <!-- Subtitle -->
  <div class="subtitle mb-3 text-center">
    Εδώ θα μάθετε πολλά!
  </div>

  <!-- Images -->
  <div class="cards-wrapper">
    <img class="card"
         src="<?php echo BASE_URL; ?>/static/image1.jpg" />
    <img class="card"
         src="<?php echo BASE_URL; ?>/static/image2.jpg" />
    <img class="card"
         src="<?php echo BASE_URL; ?>/static/image3.jpg" />
  </div>

  <!-- Buttons (εμφανίζεται μόνο σε μη συνδεδεμένους χρήστες) -->
  <?php if (!isLoggedIn()): ?>
    <div class="button-wrapper">

      <!-- Login -->
      <a href="<?php echo BASE_URL; ?>/login"
         class="cta-button">
        Είσοδος
      </a>

      <!-- Register -->
      <a href="<?php echo BASE_URL; ?>/register"
         class="cta-button">
        Εγγραφή
      </a>
    </div>
  <?php endif; ?>
</main>