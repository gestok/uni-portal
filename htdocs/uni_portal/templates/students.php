<?php
// Φόρτωση όλων των φοιτητών
$students = getAllStudents();
if ($students === null) {
  setError("Σφάλμα φόρτωσης φοιτητών.");
}

// Φόρτωση στοιχείων επιλεγμένου φοιτητή
$selectedStudent = null;
$enrolledLessons = [];
$submissions = [];

if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
  $studentDetails = getStudentDetails($_GET['student_id']);

  if ($studentDetails) {
    $selectedStudent = $studentDetails['profile'];
    $enrolledLessons = $studentDetails['lessons'];
    $submissions = $studentDetails['submissions'];
  }
}
?>

<main class="container mt-3 mb-3">
  <div class="students-container">
    <!-- Αριστερή στήλη -->
    <div class="students-list-wrapper">
      <!-- Φίλτρο αναζήτησης -->
      <input type="text"
             id="studentSearch"
             placeholder="Αναζήτηση φοιτητή..."
             class="search-input">

      <!-- Λίστα φοιτητών -->
      <div class="students-table">
        <table>
          <thead>
            <tr>
              <th>Όνομα</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody id="studentsList">
            <?php if (count($students) > 0): ?>
              <?php foreach ($students as $student): ?>
                <tr class="student-row <?php echo isset($_GET['student_id']) && $_GET['student_id'] == $student['id'] ? 'selected' : ''; ?>"
                    data-id="<?php echo $student['id']; ?>">
                  <td>
                    <?php echo htmlspecialchars($student['fullname'] ?: $student['username']); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($student['email']); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="2"
                    class="no-students">
                  Δεν βρέθηκαν φοιτητές
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Δεξιά στήλη -->
    <div class="student-details-wrapper">
      <?php if ($selectedStudent): ?>
        <!-- Προφίλ φοιτητή -->
        <div class="student-profile">
          <div class="profile-title">
            <?php echo htmlspecialchars($selectedStudent['fullname'] ?: $selectedStudent['username']); ?>
          </div>

          <div class="profile-info">
            <?php if (!empty($selectedStudent['job'])): ?>
              <div class="info-item">
                <span class="label">Ιδιότητα:</span>
                <span class="value"><?php echo htmlspecialchars($selectedStudent['job']); ?></span>
              </div>
            <?php endif; ?>

            <div class="info-item">
              <span class="label">Email:</span>
              <span class="value"><?php echo htmlspecialchars($selectedStudent['email']); ?></span>
            </div>

            <?php if (!empty($selectedStudent['mobile'])): ?>
              <div class="info-item">
                <span class="label">Τηλέφωνο:</span>
                <span class="value"><?php echo htmlspecialchars($selectedStudent['mobile']); ?></span>
              </div>
            <?php endif; ?>

            <!-- Social media links -->
            <div class="social-links mt-2">
              <?php if (!empty($selectedStudent['facebook'])): ?>
                <a href="<?php echo htmlspecialchars(formatURL($selectedStudent['facebook'])); ?>"
                   target="_blank"
                   class="social-link"
                   title="Facebook">
                  <i class="fab fa-facebook-f"></i>
                </a>
              <?php endif; ?>

              <?php if (!empty($selectedStudent['twitter'])): ?>
                <a href="<?php echo htmlspecialchars(formatURL($selectedStudent['twitter'])); ?>"
                   target="_blank"
                   class="social-link"
                   title="Twitter">
                  <i class="fab fa-twitter"></i>
                </a>
              <?php endif; ?>

              <?php if (!empty($selectedStudent['linkedin'])): ?>
                <a href="<?php echo htmlspecialchars(formatURL($selectedStudent['linkedin'])); ?>"
                   target="_blank"
                   class="social-link"
                   title="LinkedIn">
                  <i class="fab fa-linkedin-in"></i>
                </a>
              <?php endif; ?>

              <?php if (!empty($selectedStudent['instagram'])): ?>
                <a href="<?php echo htmlspecialchars(formatURL($selectedStudent['instagram'])); ?>"
                   target="_blank"
                   class="social-link"
                   title="Instagram">
                  <i class="fab fa-instagram"></i>
                </a>
              <?php endif; ?>

              <?php if (!empty($selectedStudent['youtube'])): ?>
                <a href="<?php echo htmlspecialchars(formatURL($selectedStudent['youtube'])); ?>"
                   target="_blank"
                   class="social-link"
                   title="YouTube">
                  <i class="fab fa-youtube"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Μαθήματα φοιτητή -->
        <div class="student-lessons">
          <div class="section-title">Εγγεγραμμένα Μαθήματα</div>

          <?php if (count($enrolledLessons) > 0): ?>
            <div class="lessons-list">
              <?php foreach ($enrolledLessons as $lesson): ?>
                <div class="lesson-item">
                  <?php echo htmlspecialchars($lesson['title']); ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="no-data">Ο φοιτητής δεν είναι εγγεγραμμένος σε κανένα μάθημα.</div>
          <?php endif; ?>
        </div>

        <!-- Υποβολές φοιτητή -->
        <div class="student-submissions">
          <div class="section-title">Υποβολές Εργασιών</div>

          <?php if (count($submissions) > 0): ?>
            <div class="submissions-list">
              <?php foreach ($submissions as $submission): ?>
                <div class="submission-item">
                  <div class="submission-header">
                    <div class="submission-title">
                      <?php echo htmlspecialchars($submission['title']); ?>
                    </div>
                    <span class="submission-date">
                      <?php echo date('d/m/Y H:i', strtotime($submission['submitted_at'])); ?>
                    </span>
                  </div>

                  <div class="submission-meta">
                    <span class="submission-course">
                      <strong>Μάθημα:</strong> <?php echo htmlspecialchars($submission['lesson_title']); ?>
                    </span>
                    <span class="submission-assignment">
                      <strong>Εργασία:</strong> <?php echo htmlspecialchars($submission['assignment_title']); ?>
                    </span>
                  </div>

                  <div class="submission-description mt-1 mb-2">
                    <?php echo htmlspecialchars($submission['description']); ?>
                  </div>

                  <div class="submission-actions">
                    <a href="<?php echo BASE_URL . '/' . $submission['file_path']; ?>"
                       class="action-button download"
                       download
                       title="Λήψη Εργασίας">
                      <i class="fa-solid fa-download"></i>
                      <span>Λήψη</span>
                    </a>

                    <div class="submission-status">
                      <?php if ($submission['status'] == 'graded'): ?>
                        <span class="status graded">
                          <i class="fa-solid fa-check"></i>
                          Βαθμός: <?php echo $submission['grade']; ?>
                        </span>
                      <?php else: ?>
                        <span class="status pending">
                          <i class="fa-solid fa-clock"></i>
                          Αναμονή βαθμολόγησης
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="no-data">Δεν υπάρχουν υποβολές εργασιών.</p>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div class="no-student-selected">
          <i class="fa-solid fa-user-graduate"></i>
          <p>Επιλέξτε έναν φοιτητή για να δείτε τις λεπτομέρειες</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>