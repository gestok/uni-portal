<!-- Notification -->
<?php if (getSuccess() || getError()): ?>
  <div class="notification <?php echo getSuccess() ? 'success' : 'error'; ?>">
    <?php
    // Κείμενο
    echo getSuccess() ?? getError();

    // Καθαρισμός
    clearSuccess();
    clearError();
    ?>
  </div>
<?php endif; ?>