<!-- Footer -->
<footer>
  <div class="footer-wrapper container">
    <!-- Copyright -->
    <div class="copyright"></div>

    <div class="footer-link-wrapper">
      <!-- Terms of Use -->
      <a href="static/dummy.pdf"
         class="footer-link">
        Όροι Χρήσης
      </a>

      <!-- Separator -->
      <div class="separator user-select-none pe-none">•</div>

      <!-- Privacy Policy -->
      <a href="static/dummy.pdf"
         class="footer-link">
        Πολιτική Απορρήτου
      </a>
    </div>
  </div>
</footer>

<!-- General Scripts -->
<script src="<?php echo BASE_URL; ?>/js/scripts.js"></script>

<!-- Specific Scripts -->
<?php if (isPage('portfolio')): ?>
  <script src="<?php echo BASE_URL; ?>/js/portfolio.js"></script>
<?php endif; ?>
<?php if (isPage('uploader')): ?>
  <script src="<?php echo BASE_URL; ?>/js/uploader.js"></script>
<?php endif; ?>
<?php if (isPage('create')): ?>
  <script src="<?php echo BASE_URL; ?>/js/create.js"></script>
<?php endif; ?>
<?php if (isPage('assignments')): ?>
  <script src="<?php echo BASE_URL; ?>/js/assignments.js"></script>
<?php endif; ?>
<?php if (isPage('students')): ?>
  <script src="<?php echo BASE_URL; ?>/js/students.js"></script>
<?php endif; ?>

</body>

</html>