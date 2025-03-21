<?php
// Φόρτωμα εγγεγραμμένων μαθημάτων
$lessons = [];
try {
  $sql = "SELECT l.id, l.title
          FROM student_lessons sl 
          JOIN lessons l ON sl.lesson_id = l.id
          WHERE sl.student_id = ?
          ORDER BY l.title";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_SESSION['user_id']]);
  $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Σφάλμα φόρτωσης μαθημάτων. Δοκιμάστε ξανά.";
  die();
}

// Φόρτωμα εργασιών για το επιλεγμένο μάθημα
$assignments = [];
$existing = null;
if (isGetRequest() && isset($_GET['lesson_id'])):
  try {
    // Φόρτωση δεδομένων συγκεκριμένου μαθήματος
    if (isset($_GET['assignment_id'])):
      $sql = "SELECT id, assignment_id, title, description, file_path
              FROM submissions
              WHERE user_id = ? AND assignment_id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$_SESSION['user_id'], $_GET['assignment_id']]);
      $existing = $stmt->fetch(PDO::FETCH_ASSOC);
      // $existing['lesson_id'] = $_GET['lesson_id'];
    endif;

    $sql = "SELECT id, title FROM assignments WHERE lesson_id = ? ORDER BY title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['lesson_id']]);
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $_SESSION['error'] = "Σφάλμα φόρτωσης εργασιών. Δοκιμάστε ξανά.";
    die();
  }
endif;

// Επεξεργασία υποβολής
if (isPostRequest()):
  $assignment_id = $_POST['assignment_id'];
  $lesson_id = $_POST['lesson_id'];
  $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
  $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));

  try {
    $sql = "SELECT id, title FROM assignments WHERE lesson_id = ? ORDER BY title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lesson_id]);
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Έλεγχος αν το assignment ανήκει σε εγγεγραμμένο μάθημα
    $sql = "SELECT 1 FROM assignments a JOIN student_lessons sl ON a.lesson_id = sl.lesson_id WHERE a.id = ? AND sl.student_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$assignment_id, $_SESSION['user_id']]);

    if (!$stmt->fetch())
      die("Δεν έχετε πρόσβαση σε αυτή την εργασία");

    // Διαχείριση αρχείου
    $file_path = null;
    if (!empty($_FILES['file']['name'])):
      $file_name = uniqid() . '_' . basename($_FILES['file']['name']);
      $file_type = mime_content_type($_FILES['file']['tmp_name']);

      // Δημιουργία φακέλου αν δεν υπάρχει
      $uploadDir = dirname(__DIR__) . "/uploads/submissions/lesson_$lesson_id/";
      if (!is_dir($uploadDir)):
        mkdir($uploadDir, 0777, true);
      endif;

      $target = "$uploadDir$file_name";

      if ($file_type != 'application/pdf' || !move_uploaded_file($_FILES['file']['tmp_name'], $target)):
        $_SESSION['error'] = "Σφάλμα κατά την αποθήκευση του αρχείου. Βεβαιωθείτε ότι είναι αρχείο PDF.";
        exit();
      endif;

      $file_path = $target;
    endif;

    // Έλεγχος ύπαρξης υποβολής
    $sql = "SELECT id, assignment_id, title, description, file_path
            FROM submissions
            WHERE user_id = ? AND assignment_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id'], $assignment_id]);
    $existing = $stmt->fetch();

    if ($existing):
      if ($file_path && file_exists($existing['file_path'])):
        // Διαγραφή παλιού αρχείου αν υπάρχει
        unlink($existing['file_path']);
      else:
        // Αν το αρχείο δεν έχει αλλάξει, διατηρούμε το παλιό
        $file_path = $existing['file_path'] ?: null;
      endif;

      $sql = "UPDATE submissions
              SET title = ?, description = ?, file_path = ?, submitted_at = NOW()
              WHERE id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$title, $description, $file_path, $existing['id']]);

      // Ενημέρωση του existing array
      $existing['title'] = $title;
      $existing['description'] = $description;
      $existing['file_path'] = $file_path;
    else:
      // Νέα υποβολή
      if (!$file_path):
        $_SESSION['error'] = "Απαιτείται ανέβασμα αρχείου";
        exit();
      endif;

      $sql = "INSERT INTO submissions (assignment_id, user_id, title, description, file_path)
              VALUES (?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$assignment_id, $_SESSION['user_id'], $title, $description, $file_path]);
    endif;

    $_SESSION['success'] = "Η υποβολή ολοκληρώθηκε επιτυχώς!";
  } catch (PDOException $e) {
    $_SESSION['error'] = "Σφάλμα υποβολής! Δοκιμάστε ξανά.";
  }
endif;
?>

<main class="container uploader mt-3 mb-3">
  <h1 class="title text-center">Υποβολή Εργασίας</h1>
  <p class="text-center">
    Υποβάλετε μια νέα εργασία, αφού πρώτα επιλέξετε το σωστό μάθημα.
  </p>

  <!-- Φόρμα υποβολής -->
  <form method="post"
        enctype="multipart/form-data"
        class="uploader-wrapper">

    <!-- Αποτυχία υποβολής -->
    <?php if (isset($_SESSION['error'])): ?>
      <div class="error-message">
        <?php echo $_SESSION['error'];
        unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <!-- Επιτυχία υποβολής -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="success-message">
        <?php echo $_SESSION['success'];
        unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

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
        <?php foreach ($lessons as $lesson): ?>
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
                  <?php echo isset($existing['assignment_id']) && $existing['assignment_id'] == $assignment['id'] ? 'selected' : ''; ?>>
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
             value="<?php echo isset($existing['title']) ? htmlspecialchars($existing['title']) : ''; ?>"
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
                echo isset($existing['description']) ? htmlspecialchars($existing['description']) : '';
                ?></textarea>
    </label>

    <!-- Upload -->
    <label class="custom-file-upload">
      <input type="file"
             name="file"
             accept="application/pdf"
             <?php echo !isset($existing['id']) ? 'required' : ''; ?>
             id="file" />
      <span class="uploaded-file">
        <?php echo isset($existing['file_path']) ? 'Αρχείο: ' . htmlspecialchars(basename($existing['file_path'])) : 'Επιλέξτε/Σύρετε αρχείο PDF'; ?>
      </span>
    </label>

    <!-- Υποβολή -->
    <div class="submit-wrapper">
      <button type="submit"
              class="cta-button">
        <!-- Εικονίδιο -->
        <i class="fa-solid fa-save fa-sm"></i>

        <!-- Κείμενο -->
        <span><?php echo isset($existing['id']) ? 'Ενημέρωση' : 'Υποβολή'; ?></span>
      </button>
    </div>
  </form>
</main>

<script>console.log('existing');</script>
<script>console.log(<?php echo json_encode($existing, JSON_FORCE_OBJECT); ?>);</script>
<script>console.log('GET');</script>
<script>console.log(<?php echo json_encode($_GET, JSON_FORCE_OBJECT); ?>);</script>