<?php
// Φόρτωση μαθημάτων τα οποία διδάσκει ο καθηγητής
$lessons = getTeacherLessons();

// Φόρτωση εργασιών για το επιλεγμένο μάθημα (εάν υπάρχει)
$selectedLessonId = $_GET['lesson_id'] ?? null;
$assignments = [];
if ($selectedLessonId) {
  $assignments = getLessonAssignments($selectedLessonId);
}

// Φόρτωση λεπτομερειών της επιλεγμένης εργασίας (εάν υπάρχει)
$selectedAssignmentId = $_GET['assignment_id'] ?? null;
$assignmentDetails = null;
$submissions = [];

if ($selectedAssignmentId) {
  // Φόρτωση λεπτομερειών της εργασίας
  global $pdo;
  try {
    $stmt = $pdo->prepare("SELECT * FROM assignments WHERE id = ?");
    $stmt->execute([$selectedAssignmentId]);
    $assignmentDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    // Φόρτωση όλων των υποβολών για την επιλεγμένη εργασία
    $stmt = $pdo->prepare("
      SELECT s.*, u.username, p.fullname 
      FROM submissions s
      JOIN users u ON s.user_id = u.id
      LEFT JOIN profiles p ON u.id = p.user_id
      WHERE s.assignment_id = ?
      ORDER BY s.submitted_at DESC
    ");
    $stmt->execute([$selectedAssignmentId]);
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    setError("Σφάλμα φόρτωσης δεδομένων: " . $e->getMessage());
  }
}
?>

<main class="container mt-3 mb-3">
  <!-- Wrapper -->
  <div class="wrapper">
    <!-- Επιλογή Μαθήματος -->
    <div class="lessons position-relative">
      <!-- Αριστερό βέλος -->
      <button type="button"
              class="prev"
              title="Προηγούμενο μάθημα">
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <!-- Επιλεγμένο μάθημα -->
      <div class="selected user-select-none">
        <?php echo $selectedLessonId ? htmlspecialchars(getLessonTitle($lessons, $selectedLessonId)) : 'Επιλέξτε μάθημα'; ?>
      </div>

      <!-- Δεξί βέλος -->
      <button type="button"
              class="next"
              title="Eπόμενο μάθημα">
        <i class="fa-solid fa-chevron-right"></i>
      </button>

      <!-- Λίστα μαθημάτων (κρυμμένη) -->
      <select id="lesson_id"
              class="lesson-select">
        <option value="">Επιλέξτε μάθημα</option>
        <?php foreach ($lessons as $lesson): ?>
          <option value="<?php echo $lesson['id']; ?>"
                  <?php echo $selectedLessonId == $lesson['id'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($lesson['title']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <?php if ($selectedLessonId && count($assignments) > 0): ?>
      <!-- Επιλογή Εργασίας -->
      <div class="lessons position-relative">
        <!-- Αριστερό βέλος -->
        <button type="button"
                class="prev assignment-prev"
                title="Προηγούμενη εργασία">
          <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Επιλεγμένη εργασία -->
        <div class="selected assignment-selected user-select-none">
          <?php echo $selectedAssignmentId ? htmlspecialchars(getAssignmentTitle($assignments, $selectedAssignmentId)) : 'Επιλέξτε εργασία'; ?>
        </div>

        <!-- Δεξί βέλος -->
        <button type="button"
                class="next assignment-next"
                title="Επόμενη εργασία">
          <i class="fa-solid fa-chevron-right"></i>
        </button>

        <!-- Λίστα εργασιών (κρυμμένη) -->
        <select id="assignment_id"
                class="assignment-select">
          <option value="">Επιλέξτε εργασία</option>
          <?php foreach ($assignments as $assignment): ?>
            <option value="<?php echo $assignment['id']; ?>"
                    <?php echo $selectedAssignmentId == $assignment['id'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($assignment['title']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    <?php endif; ?>

    <?php if ($assignmentDetails): ?>
      <!-- Στοιχεία εργασίας -->
      <div class="info-wrapper">
        <!-- Εικόνα -->
        <div class="upload-wrapper">
          <img src="<?php echo BASE_URL . '/uploads/thumbnails/' . $assignmentDetails['thumbnail']; ?>"
               alt="<?php echo htmlspecialchars($assignmentDetails['title']); ?>"
               class="thumbnail-preview">
        </div>

        <!-- Πληροφορίες -->
        <div class="metadata-wrapper">
          <!-- Περιγραφή -->
          <div class="lesson-description">
            <?php echo htmlspecialchars($assignmentDetails['description']); ?>
          </div>

          <!-- Προθεσμία -->
          <div class="deadline">
            <div class="title">Παράδοση</div>
            <div class="date">
              <?php echo date('d/m/Y H:i', strtotime($assignmentDetails['deadline'])); ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Υποβολές Φοιτητών -->
      <?php if (count($submissions) > 0): ?>
        <div class="submissions-table">
          <table>
            <thead>
              <tr>
                <th>Φοιτητής</th>
                <th>Τίτλος</th>
                <th>Περιγραφή</th>
                <th>Ημερομηνία Υποβολής</th>
                <th>Βαθμός</th>
                <th>Κατάσταση</th>
                <th>Ενέργειες</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($submissions as $submission): ?>
                <tr>
                  <!-- Φοιτητής -->
                  <td><?php echo htmlspecialchars($submission['fullname'] ?? $submission['username']); ?></td>

                  <!-- Τίτλος υποβολής -->
                  <td><?php echo htmlspecialchars($submission['title']); ?></td>

                  <!-- Περιγραφή υποβολής -->
                  <td class="description-cell"><?php echo htmlspecialchars($submission['description']); ?></td>

                  <!-- Ημερομηνία υποβολής -->
                  <td><?php echo date('d/m/Y H:i', strtotime($submission['submitted_at'])); ?></td>

                  <!-- Βαθμός υποβολής -->
                  <td><?php echo $submission['grade'] ?? '-'; ?></td>

                  <!-- Κατάσταση υποβολής -->
                  <td>
                    <?php echo $submission['status'] == 'graded' ? 'Βαθμολογήθηκε' : ($submission['status'] == 'submitted' ? 'Υποβλήθηκε' : 'Σε εξέλιξη'); ?>
                  </td>

                  <!-- Ενέργειες -->
                  <td>
                    <!-- Λήψη υποβολής -->
                    <a href="<?php echo BASE_URL . '/' . $submission['file_path']; ?>"
                       class="action-button download"
                       download
                       title="Λήψη Εργασίας">
                      <i class="fa-solid fa-download"></i>
                    </a>

                    <!-- Βαθμολόγηση υποβολής -->
                    <a href="#"
                       class="action-button grade"
                       title="Βαθμολόγηση">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="no-submissions">
          <p>Δεν υπάρχουν υποβολές για αυτή την εργασία.</p>
        </div>
      <?php endif; ?>
    <?php elseif ($selectedLessonId && count($assignments) == 0): ?>
      <div class="no-assignments mt-3">
        <p>Δεν υπάρχουν εργασίες για αυτό το μάθημα.</p>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
// Βοηθητική συνάρτηση για την εύρεση του τίτλου μαθήματος με βάση το ID
function getLessonTitle($lessons, $lessonId)
{
  foreach ($lessons as $lesson) {
    if ($lesson['id'] == $lessonId) {
      return $lesson['title'];
    }
  }
  return 'Άγνωστο μάθημα';
}

// Βοηθητική συνάρτηση για την εύρεση του τίτλου εργασίας με βάση το ID
function getAssignmentTitle($assignments, $assignmentId)
{
  foreach ($assignments as $assignment) {
    if ($assignment['id'] == $assignmentId) {
      return $assignment['title'];
    }
  }
  return 'Άγνωστη εργασία';
}
?>