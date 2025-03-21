<!-- Main -->
<main class="container home">

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
         src="<?php echo $base_url ?>/images/image1.jpg" />
    <img class="card"
         src="<?php echo $base_url ?>/images/image2.jpg" />
    <img class="card"
         src="<?php echo $base_url ?>/images/image3.jpg" />
  </div>

  <!-- Buttons (εμφανίζεται μόνο σε μη συνδεδεμένους χρήστες) -->
  <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="button-wrapper">

      <!-- Login -->
      <a href="<?php echo $base_url ?>/login"
         class="cta-button">
        Είσοδος
      </a>

      <!-- Register -->
      <a href="<?php echo $base_url ?>/register"
         class="cta-button">
        Εγγραφή
      </a>
    </div>
  <?php endif; ?>
</main>