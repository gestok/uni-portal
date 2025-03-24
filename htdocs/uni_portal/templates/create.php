<?php
// Φόρτωση μαθημάτων τα οποία διδάσκει ο καθηγητής
$lessons = getTeacherLessons();

if (isPostRequest() && isset($_POST['create'])) {
  // Δημιουργία εργασίας
  $assignment = [
    'lesson_id' => $_POST['lesson_id'],
    'title' => trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING)),
    'description' => trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING)),
    'thumbnail' => $_FILES['thumbnail'] ?? null,
    'deadline' => $_POST['deadline'] ?? null,
  ];

  uploadAssignment($assignment);
}
?>

<main class="container mt-3 mb-3">
  <!-- Φόρμα δημιουργίας εργασίας -->
  <form method="post"
        class="wrapper"
        enctype="multipart/form-data">

    <!-- Επιλογή Μαθήματος -->
    <div class="lessons position-relative">
      <!-- Αριστερό βέλος -->
      <button type="button"
              class="prev"
              title="Προηγούμενο μάθημα">
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <!-- Επιλεγμένο μάθημα -->
      <div class="selected user-select-none">Επιλέξτε μάθημα</div>

      <!-- Δεξί βέλος -->
      <button type="button"
              class="next"
              title="Eπόμενο μάθημα">
        <i class="fa-solid fa-chevron-right"></i>
      </button>

      <!-- Λίστα μαθημάτων (κρυμμένη) -->
      <!-- Χρησιμοποιείται για validation -->
      <select name="lesson_id"
              id="lesson_id"
              required>
        <option value="">Επιλέξτε μάθημα</option>
        <?php foreach ($lessons as $lesson): ?>
          <option value="<?php echo $lesson['id']; ?>"><?php echo htmlspecialchars($lesson['title']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Στοιχεία εργασίας -->
    <div class="info-wrapper">
      <!-- Εικόνα -->
      <label class="upload-wrapper">
        <input type="file"
               name="thumbnail"
               accept="image/jpeg, image/png"
               id="thumbnail"
               required />
        <span class="preview">Επιλέξτε / Σύρετε εικόνα (JPEG/PNG)</span>
      </label>

      <!-- Πληροφορίες -->
      <div class="metadata-wrapper">
        <!-- Τίτλος -->
        <input type="text"
               name="title"
               required
               placeholder="Πληκτρολογήστε τον τίτλο της εργασίας"
               class="lesson-title" />

        <!-- Περιγραφή -->
        <textarea name="description"
                  rows="5"
                  required
                  placeholder="Πληκτρολογήστε την περιγραφή της εργασίας"
                  class="lesson-description"></textarea>

        <!-- Προθεσμία -->
        <label class="deadline">
          <div class="title">Παράδοση</div>
          <input type="datetime-local"
                 name="deadline"
                 required
                 class="date-picker" />
        </label>
      </div>
    </div>

    <!-- Υποβολή -->
    <button type="submit"
            name="create"
            class="btn secondary inline">
      <i class="fa-solid fa-save fa-sm"></i>
      <span>Δημιουργία</span>
    </button>
  </form>
</main>