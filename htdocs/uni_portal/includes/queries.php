<?php
/**
 * Επιστρέφει ένα array με μαθήματα (`id`, `title` και `description`) στα οποία είναι εγγεγραμμένος ο φοιτητής,
 * ταξινομημένα αλφαβητικά κατά τον τίτλο του μαθήματος.
 * 
 * Αν δεν υπάρχουν εγγεγραμμένα μαθήματα ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 */
function getStudentLessons(): array
{
  global $pdo;

  if (!isset($pdo) || !getUserId()) {
    return [];
  }

  try {
    $sql = "SELECT id, title, description
            FROM lessons
            JOIN student_lessons ON lessons.id = student_lessons.lesson_id
            WHERE student_lessons.student_id = ?
            ORDER BY title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([getUserId()]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Επιστρέφει ένα array με μαθήματα (`id`, `title` και `description`) που διδάσκει ο καθηγητής,
 * ταξινομημένα αλφαβητικά κατά τον τίτλο του μαθήματος.
 * 
 * Αν δεν υπάρχουν μαθήματα ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 */
function getTeacherLessons(): array
{
  global $pdo;

  if (!isset($pdo) || !getUserId()) {
    return [];
  }

  try {
    $sql = "SELECT id, title, description
            FROM lessons
            INNER JOIN teacher_lessons ON lessons.id = teacher_lessons.lesson_id
            WHERE teacher_lessons.teacher_id = ?
            ORDER BY title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([getUserId()]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Επιστρέφει ένα array με εργασίες (`id`, `title`, `description`, `thumbnail` και `deadline`) για το συγκεκριμένο μάθημα,
 * ταξινομημένες αλφαβητικά κατά τον τίτλο της εργασίας.
 * 
 * Αν δεν δοθεί ID μαθήματος ή αν δεν υπάρχουν εργασίες ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 */
function getLessonAssignments(int|string $lesson_id = null): array
{
  global $pdo;

  if (!isset($pdo) || !getUserId() || !isset($lesson_id)) {
    return [];
  }

  try {
    $sql = "SELECT id, title, description, thumbnail, deadline
            FROM assignments
            WHERE lesson_id = ?
            ORDER BY title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lesson_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Επιστρέφει την υποβολή της εργασίας (`id`, `assignment_id`, `title`, `description`, `file_path`, `submitted_at`, `grade` και `status`)
 * για το συγκεκριμένο μάθημα και εργασία.
 * 
 * Αν δεν δοθεί ID μαθήματος ή αν δεν υπάρχουν υποβολές ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 */
function getAssignmentSubmission(int|string $assignment_id = null)
{
  global $pdo;

  if (!isset($pdo) || !getUserId() || !isset($assignment_id)) {
    return null;
  }

  try {
    $sql = "SELECT id, assignment_id, title, description, file_path, submitted_at, grade, status
            FROM submissions
            WHERE user_id = ? AND assignment_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([getUserId(), $assignment_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Επιστρέφει true αν η εργασία ανήκει σε μάθημα στο οποίο είναι εγγεγραμμένος ο φοιτητής.
 * Σε αντίθετη περίπτωση ή αν προκύψει σφάλμα, επιστρέφει false.
 */
function isAssignmentOfEnrolledLesson(int|string $assignment_id = null): bool
{
  global $pdo;

  if (!isset($pdo) || !getUserId() || !isset($assignment_id)) {
    return false;
  }

  try {
    $sql = "SELECT 1
            FROM assignments
            JOIN student_lessons
            ON assignments.lesson_id = student_lessons.lesson_id
            WHERE assignments.id = ? AND student_lessons.student_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$assignment_id, getUserId()]);
    return (bool) $stmt->fetch();
  } catch (PDOException $e) {
    return false;
  }
}

/**
 * Ενημερώνει ή προσθέτει μια υποβολή εργασίας στη βάση δεδομένων.
 * * Αν η υποβολή υπάρχει, ενημερώνει τα πεδία `title`, `description`, `file_path` και `submitted_at`.
 * * Αν δεν υπάρχει, προσθέτει μια νέα υποβολή με τα πεδία `assignment_id`, `user_id`, `title`, `description`, `file_path` και `submitted_at`.
 * 
 * Επιστρέφει `true` αν η υποβολή ενημερώθηκε ή προστέθηκε επιτυχώς, αλλιώς επιστρέφει `false`.
 */
function upsertSubmission($submission): bool
{
  global $pdo;

  // Αν δεν υπάρχουν απαιτούμενα πεδία, σταματάμε
  if (
    !isset($pdo) || !getUserId() ||
    !isset($submission) || empty($submission['assignment_id']) ||
    empty($submission['title']) || empty($submission['description']) || empty($submission['file_path'])
  ) {
    return false;
  }

  try {
    $sql = null;
    $stmt = null;
    // Αν δόθηκε ID, τότε ενημερώνουμε την βάση
    if (isset($submission['id'])) {
      $sql = "UPDATE submissions
              SET title = ?, description = ?, file_path = ?, submitted_at = NOW()
              WHERE id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$submission['title'], $submission['description'], $submission['file_path'], $submission['id']]);
    }
    // Αν δεν δόθηκε ID, τότε προσθέτουμε νέα υποβολή
    else {
      $sql = "INSERT INTO submissions (assignment_id, user_id, title, description, file_path, submitted_at)
              VALUES (?, ?, ?, ?, ?, NOW())";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$submission['assignment_id'], getUserId(), $submission['title'], $submission['description'], $submission['file_path']]);
    }
    return true;
  } catch (PDOException $e) {
    return false;
  }
}

/**
 * Εισάγει μια νέα εργασία (lesson_id, title, description, thumbnail, created_by, deadline) στη βάση δεδομένων.
 * Επιστρέφει `true` αν η εργασία εισήχθη επιτυχώς, αλλιώς επιστρέφει `false`.
 */
function insertAssignment($assignment): bool
{
  global $pdo;

  // Αν δεν υπάρχουν απαιτούμενα πεδία, σταματάμε την εκτέλεση.
  if (
    !isset($pdo) || !getUserId() || !isset($assignment) ||
    !isset($assignment['lesson_id']) || !isset($assignment['title']) ||
    !isset($assignment['description']) || !isset($assignment['thumbnail']) ||
    !isset($assignment['deadline'])
  ) {
    return false;
  }

  try {
    $sql = "INSERT INTO assignments (lesson_id, title, description, thumbnail, created_by, deadline, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$assignment['lesson_id'], $assignment['title'], $assignment['description'], $assignment['thumbnail'], getUserId(), $assignment['deadline']]);
    return true;
  } catch (PDOException $e) {
    return false;
  }
}

/**
 * Επιστρέφει ένα array με όλους τους φοιτητές (id, username, email, fullname)
 * ταξινομημένους αλφαβητικά κατά το ονοματεπώνυμο και μετά κατά το username.
 * 
 * Αν δεν υπάρχουν φοιτητές ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 */
function getAllStudents(): array
{
  global $pdo;

  if (!isset($pdo)) {
    return [];
  }

  try {
    $sql = "SELECT id, username, email, p.fullname 
            FROM users
            LEFT JOIN profiles p ON users.id = p.user_id
            WHERE users.role = 'student'
            ORDER BY p.fullname, users.username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Επιστρέφει τα στοιχεία προφίλ του φοιτητή με το δοθέν ID.
 * 
 * Αν δεν υπάρχει φοιτητής με το συγκεκριμένο ID ή αν προκύψει σφάλμα, επιστρέφει null.
 */
function getStudentProfile(int|string $studentId = null)
{
  global $pdo;

  if (!isset($pdo) || !isset($studentId)) {
    return null;
  }

  try {
    $sql = "SELECT id, username, email, p.* 
            FROM users
            LEFT JOIN profiles p ON users.id = p.user_id
            WHERE users.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  } catch (PDOException $e) {
    return null;
  }
}

/**
 * Επιστρέφει ένα array με τα μαθήματα (id, title, description) στα οποία είναι
 * εγγεγραμμένος ο φοιτητής με το δοθέν ID, ταξινομημένα αλφαβητικά κατά τον τίτλο.
 * 
 * Αν δεν υπάρχουν εγγεγραμμένα μαθήματα ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 * @todo Σύμπτιξη με την getStudentLessons() για να αποφευχθεί η επανάληψη κώδικα.
 */
function getStudentEnrolledLessons(int|string $studentId = null): array
{
  global $pdo;

  if (!isset($pdo) || !isset($studentId)) {
    return [];
  }

  try {
    $sql = "SELECT id, title, description
            FROM lessons
            JOIN student_lessons ON lessons.id = student_lessons.lesson_id
            WHERE student_lessons.student_id = ?
            ORDER BY lessons.title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Επιστρέφει ένα array με τις υποβολές (id, assignment_id, title, description, file_path, 
 * submitted_at, grade, status, assignment_title, lesson_title) του φοιτητή με το δοθέν ID,
 * ταξινομημένες ανά ημερομηνία υποβολής (από την πιο πρόσφατη).
 * 
 * Αν δεν υπάρχουν υποβολές ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 */
function getStudentSubmissions(int|string $studentId = null): array
{
  global $pdo;

  if (!isset($pdo) || !isset($studentId)) {
    return [];
  }

  try {
    $sql = "SELECT s.*, assignments.title as assignment_title, lessons.title as lesson_title
            FROM submissions s
            JOIN assignments ON s.assignment_id = assignments.id
            JOIN lessons ON assignments.lesson_id = lessons.id
            WHERE s.user_id = ?
            ORDER BY s.submitted_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Επιστρέφει τα στοιχεία του χρήστη με το δοθέν ID.
 * Επιστρέφει ένα array με τα πεδία `id`, `username`, `email`
 * και profile (`fullname`, `job`, `mobile`, `facebook`, `twitter`, `linkedin`, `instagram`, `youtube`).
 */
function getUserData()
{
  global $pdo;

  if (!isset($pdo) || !getUserId()) {
    return null;
  }

  try {
    $stmt = $pdo->prepare("SELECT u.id, u.username, u.email, p.fullname, p.job, p.mobile, p.facebook, p.twitter, p.linkedin, p.instagram, p.youtube
                                FROM users u
                                LEFT JOIN profiles p ON u.id = p.user_id
                                WHERE u.id = ?");
    $stmt->execute([getUserId()]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * Eνημερώνει ή προσθέτει τα στοιχεία του χρήστη στη βάση δεδομένων.
 */
function saveUserData($profileData): bool
{
  global $pdo;

  if (!isset($pdo) || !getUserId() || !isset($profileData)) {
    return false;
  }

  try {
    $sql = "INSERT INTO profiles (user_id, fullname, job, mobile, facebook, twitter, linkedin, instagram, youtube)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            fullname = VALUES(fullname),
            job = VALUES(job),
            mobile = VALUES(mobile),
            facebook = VALUES(facebook),
            twitter = VALUES(twitter),
            linkedin = VALUES(linkedin),
            instagram = VALUES(instagram),
            youtube = VALUES(youtube)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      getUserId(),
      $profileData['fullname'],
      $profileData['job'],
      $profileData['mobile'],
      $profileData['facebook'],
      $profileData['twitter'],
      $profileData['linkedin'],
      $profileData['instagram'],
      $profileData['youtube']
    ]);
    return true;
  } catch (PDOException $e) {
    return false;
  }
}

/**
 * Ενημερώνει το email του χρήστη στη βάση δεδομένων.
 */
function updateUserEmail($email): bool
{
  global $pdo;

  if (!isset($pdo) || !getUserId() || !$email) {
    return false;
  }

  try {
    $sql = "UPDATE users SET email = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, getUserId()]);
    return true;
  } catch (PDOException $e) {
    return false;
  }
}