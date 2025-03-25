<?php
// Φόρτωση μαθημάτων φοιτητή
$lessons = getStudentEnrolledLessons(getUserId());

// Φόρτωση εργασιών μαθημάτων
foreach ($lessons as &$lesson) {
  $lesson['assignments'] = getLessonAssignments($lesson['id']);

  // Φόρτωση υποβολών εργασιών για κάθε εργασία
  foreach ($lesson['assignments'] as &$assignment) {
    if (!empty(getAssignmentSubmission($assignment['id']))) {
      $assignment['submission'] = getAssignmentSubmission($assignment['id']);
    }
  }
}
// Απελευθέρωση αναφορών
unset($lesson);
unset($assignment);
?>

<main class="container portfolio mt-3 mb-3">
  <!-- Μπάρα -->
  <div class="header">
    <!-- Νέα Υποβολή -->
    <a href="<?php echo BASE_URL; ?>/uploader"
       class="btn secondary small user-select-none">
      <i class="fa-solid fa-upload fa-sm"></i>
      <span>Νέα υποβολή</span>
    </a>
  </div>

  <!-- Μαθήματα -->
  <div class="courses">

    <!-- Λούπα για κάθε μάθημα που παρακολουθεί ο φοιτητής με ενεργές εργασίες -->
    <?php foreach ($lessons as $lesson): ?>
      <?php if (!empty($lesson['assignments'])): ?>
        <div class="course">

          <!-- Μπάρα -->
          <div class="top-bar">

            <!-- Τίτλος Μαθήματος -->
            <span class="title"><?php echo htmlspecialchars($lesson['title']); ?></span>
            <!-- Περιγραφή Μαθήματος -->
            <span class="description"><?php echo htmlspecialchars($lesson['description']); ?></span>

            <!-- Εικονίδιο -->
            <i class="fa-solid fa-plus fa-lg"></i>
          </div>

          <!-- Εργασίες Μαθήματος -->
          <div class="content">

            <!-- Λούπα για κάθε εργασία -->
            <?php $index = 0;
            foreach ($lesson['assignments'] as $assignment): ?>
              <div class="work-wrapper <?php echo $index % 2 === 0 ? 'even' : 'odd'; ?>">
                <!-- Thumbnail -->
                <img src="<?php echo BASE_URL . '/uploads/thumbnails/' . $assignment['thumbnail']; ?>"
                     class="thumbnail user-select-none pe-none" />

                <!-- Πληροφορίες Εργασίας -->
                <div class="info">

                  <!-- Τίτλος -->
                  <div class="title">
                    <?php echo htmlspecialchars($assignment['title']); ?>
                  </div>

                  <!-- Περιγραφή -->
                  <div class="subtitle">
                    <?php echo htmlspecialchars($assignment['description']); ?>
                  </div>

                  <!-- Υποβολή -->
                  <?php if (isset($assignment['submission'])): ?>
                    <div class="submission-details">
                      <!-- Τίτλος -->
                      <div class="title">
                        <?php echo htmlspecialchars($assignment['submission']['title']); ?>
                      </div>

                      <!-- Περιγραφή -->
                      <div class="description">
                        <?php echo htmlspecialchars($assignment['submission']['description']); ?>
                      </div>

                      <!-- Κατάσταση -->
                      <span class="status <?php echo $assignment['submission']['status']; ?>">
                        <?php echo $assignment['submission']['status'] === 'submitted' ? ('<i class="fa-regular fa-clock"></i> ' . date('d/m/Y H:i', strtotime($assignment['submission']['submitted_at']))) : ($assignment['submission']['status'] === 'graded' ? 'Βαθμολογήθηκε: ' . $assignment['submission']['grade'] : 'Σε εξέλιξη'); ?>
                      </span>

                      <!-- Λήψη -->
                      <a href="<?php echo BASE_URL . '/' . $assignment['submission']['file_path']; ?>"
                         download
                         class="download btn primary inline small user-select-none">
                        <!-- Εικονίδιο -->
                        <i class="fa-solid fa-download fa-sm"></i>

                        <!-- Κείμενο -->
                        <span>Λήψη</span>
                      </a>
                    </div>
                  <?php else:
                    // Εμφάνιση υπολυπόμενου χρόνου αν υπάρχει προθεσμία
                    $deadline = strtotime($assignment['deadline']);
                    $now = time();
                    $timeLeft = $deadline - $now;
                    $daysLeft = floor($timeLeft / (60 * 60 * 24));
                    $hoursLeft = floor(($timeLeft % (60 * 60 * 24)) / (60 * 60));
                    $minutesLeft = floor(($timeLeft % (60 * 60)) / 60);

                    if ($timeLeft > 0): ?>
                      <div class="deadline">
                        <!-- Ημερομηνία Υποβολής -->
                        <span class="date">
                          <i class="fa-regular fa-clock"></i>
                          <span>Υποβολή: <?php echo date('d/m/Y', $deadline); ?></span>
                        </span>

                        <!-- Προθεσμία -->
                        <span class="remaining">
                          <?php echo "$daysLeft ημέρες, $hoursLeft ώρες, $minutesLeft λεπτά"; ?>
                        </span>
                      </div>
                    <?php else: ?>
                      <div class="no-submission">
                        <span>Δεν έχετε υποβάλλει αυτήν την εργασία.</span>
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
              <?php $index++; endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</main>