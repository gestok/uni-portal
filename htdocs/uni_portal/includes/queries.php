<?php
/**
 * Επιστρέφει ένα array με μαθήματα (`id`, `title` και `description`) στα οποία είναι εγγεγραμμένος ο φοιτητής,
 * ταξινομημένα αλφαβητικά κατά τον τίτλο του μαθήματος.
 * 
 * Αν δεν υπάρχουν εγγεγραμμένα μαθήματα ή αν προκύψει σφάλμα, επιστρέφει ένα κενό array.
 */
function getEnrolledLessons(): array
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