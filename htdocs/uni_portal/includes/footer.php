<!-- Footer -->
<footer>
  <div class="footer-wrapper container">
    <!-- Copyright -->
    <div class="copyright"></div>

    <div class="footer-link-wrapper">
      <!-- Terms of Use -->
      <a href="images/dummy.pdf"
         class="footer-link">
        Όροι Χρήσης
      </a>

      <!-- Separator -->
      <div class="separator user-select-none pe-none">•</div>

      <!-- Privacy Policy -->
      <a href="images/dummy.pdf"
         class="footer-link">
        Πολιτική Απορρήτου
      </a>
    </div>
  </div>
</footer>

<!-- General Scripts -->
<script src="<?php echo $base_url ?>/js/scripts.js"></script>

<!-- Specific Scripts -->
<?php if ($current_page == 'portfolio'): ?>
  <script src="<?php echo $base_url ?>/js/portfolio.js"></script>
<?php endif; ?>
<?php if ($current_page == 'uploader'): ?>
  <script src="<?php echo $base_url; ?>/js/uploader.js"></script>
<?php endif; ?>

</body>

</html>