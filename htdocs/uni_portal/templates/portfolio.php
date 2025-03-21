<?php
// Φόρτωση υποβολών φοιτητή
$lessons = [];
try {
  // Ερώτημα για εύρεση υποβολών του φοιτητή σε μαθήματα που έχει εγγραφεί
  $sql = "SELECT l.id, l.title, l.description,
                 a.id AS assignment_id, a.title AS assignment_title,
                 a.description AS assignment_description, a.thumbnail, a.deadline,
                 s.id AS submission_id, s.title AS submission_title,
                 s.description AS submission_description, s.file_path, s.submitted_at, s.grade, s.status
        FROM student_lessons sl
        JOIN lessons l ON sl.lesson_id = l.id
        LEFT JOIN assignments a ON l.id = a.lesson_id
        LEFT JOIN submissions s ON a.id = s.assignment_id AND s.user_id = ?
        WHERE sl.student_id = ?
        ORDER BY l.title, a.id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Ομαδοποίηση δεδομένων
  foreach ($results as $lesson) {
    $lessonId = $lesson['id'];
    if (!isset($lessons[$lessonId])) {
      $lessons[$lessonId] = [
        'title' => $lesson['title'],
        'description' => $lesson['description'],
        'assignments' => []
      ];
    }

    if ($lesson['assignment_id']) {
      $lessons[$lessonId]['assignments'][$lesson['assignment_id']] = [
        'assignment' => [
          'id' => $lesson['assignment_id'],
          'title' => $lesson['assignment_title'],
          'description' => $lesson['assignment_description'],
          'thumbnail' => $lesson['thumbnail'],
          'deadline' => $lesson['deadline']
        ],
        'submission' => $lesson['submission_id'] ? [
          'id' => $lesson['submission_id'],
          'title' => $lesson['submission_title'],
          'description' => $lesson['submission_description'],
          'file' => explode('uni_portal', $lesson['file_path'])[1] ?? null,
          'date' => $lesson['submitted_at'],
          'grade' => $lesson['grade'],
          'status' => $lesson['status']
        ] : null
      ];
    }
  }
} catch (PDOException $e) {
  die("Σφάλμα φόρτωσης υποβολών: " . $e->getMessage());
}
?>

<main class="container portfolio mt-3 mb-3">
  <!-- Μπάρα -->
  <div class="header">

    <!-- Τίτλος -->
    <span class="title user-select-none pe-none">Μάθημα</span>

    <!-- Νέα Υποβολή -->
    <a href="<?php echo $base_url ?>/uploader"
       class="upload-btn user-select-none">
      <i class="fas fa-upload icon"></i>
      <span>Νέα υποβολή</span>
    </a>
  </div>

  <!-- Μαθήματα -->
  <div class="courses mt-2">

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
            <div class="icon">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>

          <!-- Εργασίες Μαθήματος -->
          <div class="content">

            <!-- Λούπα για κάθε εργασία -->
            <?php $index = 0;
            foreach ($lesson['assignments'] as $assignment): ?>
              <div class="work-wrapper <?php echo $index % 2 === 0 ? 'even' : 'odd'; ?>">
                <!-- Thumbnail -->
                <img src="<?php echo $base_url . '/uploads/thumbnails/' . $assignment['assignment']['thumbnail']; ?>"
                     class="thumbnail user-select-none pe-none" />

                <!-- Πληροφορίες Εργασίας -->
                <div class="info">

                  <!-- Τίτλος -->
                  <h2 class="title">
                    <?php echo htmlspecialchars($assignment['assignment']['title']); ?>
                  </h2>

                  <!-- Περιγραφή -->
                  <div class="subtitle">
                    <?php echo htmlspecialchars($assignment['assignment']['description']); ?>
                  </div>

                  <!-- Υποβολή -->
                  <?php if ($assignment['submission']): ?>
                    <div class="submission-details">
                      <!-- Τίτλος -->
                      <div class="description">
                        <?php echo htmlspecialchars($assignment['submission']['title']); ?>
                      </div>

                      <!-- Περιγραφή -->
                      <div class="description">
                        <?php echo htmlspecialchars($assignment['submission']['description']); ?>
                      </div>

                      <!-- Στατιστικά Υποβολής -->
                      <div class="meta">
                        <span>Υποβλήθηκε: <?php echo date('d/m/Y H:i', strtotime($assignment['submission']['date'])); ?></span>
                      </div>

                      <!-- Κατάσταση -->
                      <span class="status <?php echo $submission['status']; ?>">
                        <?php echo $assignment['submission']['status'] === 'submitted' ? 'Υποβλήθηκε' : ($assignment['submission']['status'] === 'graded' ? 'Βαθμολογήθηκε: ' . $assignment['submission']['grade'] : 'Σε εξέλιξη'); ?>
                      </span>

                      <!-- Λήψη -->
                      <a href="<?php echo $base_url . $assignment['submission']['file']; ?>"
                         download
                         class="download user-select-none">
                        <!-- Εικονίδιο -->
                        <i class="fa-solid fa-download icon"></i>

                        <!-- Κείμενο -->
                        <span>Λήψη</span>
                      </a>
                    </div>
                  <?php else:
                    // Εμφάνιση υπολυπόμενου χρόνου αν υπάρχει προθεσμία
                    $deadline = strtotime($assignment['assignment']['deadline']);
                    $now = time();
                    $timeLeft = $deadline - $now;
                    $daysLeft = floor($timeLeft / (60 * 60 * 24));
                    $hoursLeft = floor(($timeLeft % (60 * 60 * 24)) / (60 * 60));
                    $minutesLeft = floor(($timeLeft % (60 * 60)) / 60);

                    if ($timeLeft > 0): ?>
                      <div class="deadline">
                        <span>
                          Υποβολή μέχρι: <?php echo date('d/m/Y', $deadline); ?>
                        </span>
                        <span>
                          Προθεσμία: <?php echo "$daysLeft ημέρες, $hoursLeft ώρες, $minutesLeft λεπτά"; ?>
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