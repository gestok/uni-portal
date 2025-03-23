<?php
// Φόρτωμα εγγεγραμμένων μαθημάτων
$enrolledLessons = getEnrolledLessons();
// Φόρτωμα εργασιών για το συγκεκριμένο μάθημα (εάν έχει επιλεχθεί μάθημα)
$assignments = getLessonAssignments($_GET['lesson_id'] ?? null);
// Φόρτωμα τελευταίας υποβολής για το συγκεκριμένο μάθημα και εργασία (εάν έχει επιλεχθεί εργασία και υπάρχει υποβολή)
$submission = getAssignmentSubmission($_GET['assignment_id'] ?? null);

// Αν η υποβολή είναι POST
if (isPostRequest()) {
  $submission = [
    'assignment_id' => $_POST['assignment_id'],
    'lesson_id' => $_POST['lesson_id'],
    'title' => trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING)) ?? null,
    'description' => trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING)) ?? null,
  ];
  $file = $_FILES['file'];
  uploadSubmission($submission, $file);
  redirectTo(BASE_URL . "/uploader?lesson_id={$_POST['lesson_id']}&assignment_id={$_POST['assignment_id']}");
}
?>

<main class="container uploader mt-3 mb-3">
  <h1 class="title text-center">Υποβολή Εργασίας</h1>
  <p class="text-center">
    Υποβάλετε μια νέα εργασία, αφού πρώτα επιλέξετε το σωστό μάθημα.
  </p>

  <!-- Φόρμα υποβολής -->
  <form method="post"
        enctype="multipart/form-data"
        class="uploader-wrapper position-relative">

    <!-- Notification -->
    <?php include_once 'templates/notification.php'; ?>

    <!-- Μάθημα -->
    <label class="info-wrapper">
      <!-- Τίτλος -->
      <div class="title">Μάθημα *</div>

      <!-- Επιλογή -->
      <select name="lesson_id"
              required
              id="lessonSelect"
              class="course">
        <!-- Placeholder -->
        <option value="">Επιλέξτε μάθημα</option>

        <!-- Επιλογές -->
        <?php foreach ($enrolledLessons as $lesson): ?>
          <option value="<?php echo $lesson['id']; ?>"
                  <?php echo (isset($_GET['lesson_id']) && $_GET['lesson_id'] == $lesson['id']) ? 'selected' : '' ?>>
            <?php echo htmlspecialchars($lesson['title']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <!-- Εργασία -->
    <label class="info-wrapper">
      <!-- Τίτλος -->
      <div class="title">Εργασία *</div>

      <!-- Επιλογή -->
      <select name="assignment_id"
              required
              id="assignmentSelect"
              class="work">
        <!-- Placeholder -->
        <option value="">Επιλέξτε εργασία</option>

        <!-- Επιλογές -->
        <?php foreach ($assignments as $assignment): ?>
          <option value="<?php echo $assignment['id']; ?>"
                  <?php echo isset($_GET['assignment_id']) && $_GET['assignment_id'] == $assignment['id'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($assignment['title']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <!-- Τίτλος Εργασίας Φοιτητή -->
    <label class="info-wrapper">
      <!-- Τίτλος -->
      <div class="title">Τίτλος *</div>

      <!-- Τιμή -->
      <input type="text"
             name="title"
             required
             value="<?php echo htmlspecialchars($submission['title'] ?? ''); ?>"
             placeholder="Πληκτρολογήστε τον τίτλο της εργασίας" />
    </label>

    <!-- Περιγραφή Εργασίας Φοιτητή -->
    <label class="info-wrapper">
      <!-- Τίτλος -->
      <div class="title">Περιγραφή *</div>

      <!-- Τιμή -->
      <textarea name="description"
                rows="5"
                required
                placeholder="Πληκτρολογήστε την περιγραφή της εργασίας"><?php
                echo htmlspecialchars($submission['description'] ?? '');
                ?></textarea>
    </label>

    <!-- Upload -->
    <label class="custom-file-upload position-relative">
      <input type="file"
             name="file"
             accept="application/pdf"
             <?php echo !isset($submission['id']) ? 'required' : ''; ?>
             id="file" />
      <span class="uploaded-file">
        <?php echo isset($submission['file_path']) ? htmlspecialchars(basename($submission['file_path'])) : 'Επιλέξτε / Σύρετε αρχείο PDF'; ?>
      </span>
    </label>

    <div class="submit-wrapper">
      <!-- Λήψη -->
      <?php if (isset($submission['file_path'])): ?>
        <a href="<?php echo BASE_URL . '/' . $submission['file_path']; ?>"
           download
           class="cta-button">
          <!-- Εικονίδιο -->
          <i class="fa-solid fa-download fa-sm"></i>

          <!-- Κείμενο -->
          <span>Λήψη</span>
        </a>
      <?php endif; ?>

      <!-- Υποβολή -->
      <button type="submit"
              class="cta-button">
        <!-- Εικονίδιο -->
        <i class="fa-solid fa-save fa-sm"></i>

        <!-- Κείμενο -->
        <span><?php echo isset($submission['id']) ? 'Ενημέρωση' : 'Υποβολή'; ?></span>
      </button>
    </div>
  </form>
</main>