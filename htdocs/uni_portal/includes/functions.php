<?php
/**
 * Η συνάρτηση δέχεται μια νέα υποβολή, (προαιρετικά) ένα αρχείο
 * και προσθέτει ή ενημερώνει την υποβολή στη βάση δεδομένων.
 * * Αν το αρχείο δεν δοθεί και δεν υπάρχει προηγούμενη υποβολή, θέτει σφάλμα.
 */
function uploadSubmission($submission, $file): void
{
  // Αν δεν υπάρχουν απαιτούμενα πεδία, σταματάμε την εκτέλεση.
  // Το πεδίο `file` είναι προαιρετικό ανάλογα με το αν υπάρχει υποβολή ή όχι.
  if (
    !getUserId() || !isset($submission) ||
    !isset($submission['assignment_id']) || !isset($submission['title']) ||
    !isset($submission['description'])
  ) {
    setError("Λάθος δεδομένα υποβολής.");
    return;
  }

  // Αν η εργασία δεν ανήκει σε εγγεγραμμένο μάθημα φοιτητή.
  if (!isAssignmentOfEnrolledLesson($submission['assignment_id'])) {
    setError("Δεν έχετε πρόσβαση σε αυτό το μάθημα");
    return;
  }

  // Λήψη τελευταίας υποβολής (αν υπάρχει).
  // Από εδώ και κάτω, το $submissionToBeUpdated είναι η υποβολή που θα ενημερωθεί ή θα δημιουργηθεί.
  $submissionToBeUpdated = getAssignmentSubmission($submission['assignment_id']);

  // Αν δεν υπάρχει προηγούμενη υποβολή και δεν υπάρχει νέο αρχείο,
  // σταματάμε την εκτελέση διότι δεν υπάρχει αρχείο.
  if (!$submissionToBeUpdated && !isset($file['tmp_name'])) {
    setError("Απαιτείται ανέβασμα αρχείου");
    return;
  }

  // Αν υπάρχει νέο αρχείο:
  // 1. Ελέγχουμε αν το αρχείο είναι PDF.
  // 2. Δημιουργούμε φάκελο για την αποθήκευση του αρχείου αν δεν υπάρχει.
  // 3. Μεταφέρουμε το αρχείο στον φάκελο.
  // 4. Αν υπάρχει παλιά υποβολή, διαγράφουμε το αρχείο της παλιάς υποβολής.
  // 5. Ενημερώνουμε το μονοπάτι του αρχείου της νέας υποβολής.
  if ($file['tmp_name']) {
    // Έλεγχος τύπου αρχείου.
    if (mime_content_type($file['tmp_name']) != 'application/pdf') {
      setError("Μόνο αρχεία PDF επιτρέπονται.");
      return;
    }

    $file_name = getUniqueFileName($file);
    $upload_dir = dirname(__DIR__) . '/uploads/submissions/lesson_' . $submission['lesson_id'];

    // Δημιουργία φακέλου μεταφόρτωσης αν δεν υπάρχει.
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0777, true);
    }

    // Μεταφορά αρχείου στον φάκελο. Aν αποτύχει, επιστρέφουμε σφάλμα.
    if (!move_uploaded_file($file['tmp_name'], "$upload_dir/$file_name")) {
      setError("Σφάλμα κατά την αποθήκευση του αρχείου.");
      return;
    }

    // Αν υπάρχει παλιά υποβολή, διαγραφή του αρχείου.
    if ($submissionToBeUpdated && file_exists(dirname(__DIR__) . '/' . $submissionToBeUpdated['file_path'])) {
      unlink(dirname(__DIR__) . '/' . $submissionToBeUpdated['file_path']);
    }

    // Ενημέρωση μονοπατιού αρχείου.
    $submissionToBeUpdated['file_path'] = 'uploads/submissions/lesson_' . $submission['lesson_id'] . '/' . $file_name;
  }

  // Ενημερώνουμε τα υπόλοιπα πεδία της υποβολής
  $submissionToBeUpdated['assignment_id'] = $submission['assignment_id'];
  $submissionToBeUpdated['user_id'] = getUserId();
  $submissionToBeUpdated['title'] = $submission['title'];
  $submissionToBeUpdated['description'] = $submission['description'];

  // Ενημέρωση ή προσθήκη υποβολής στη βάση δεδομένων
  if (upsertSubmission($submissionToBeUpdated)) {
    setSuccess("Η υποβολή σας ολοκληρώθηκε επιτυχώς.");
  } else {
    setError("Σφάλμα κατά την υποβολή της εργασίας.");
  }
}

/**
 * Η συνάρτηση δέχεται μια νέα εργασία και την αποθηκεύει στη βάση δεδομένων.
 */
function uploadAssignment($assignment): void
{
  // Αν δεν υπάρχουν απαιτούμενα πεδία, σταματάμε την εκτέλεση.
  if (
    !getUserId() || !isset($assignment) || !isset($assignment['lesson_id']) ||
    !isset($assignment['title']) || !isset($assignment['description']) ||
    !isset($assignment['deadline']) || !isset($assignment['thumbnail'])
  ) {
    setError("Λάθος δεδομένα υποβολής.");
    return;
  }

  if (!$assignment['thumbnail']['tmp_name']) {
    setError("Απαιτείται ανέβασμα εικόνας.");
    return;
  }

  if (mime_content_type($assignment['thumbnail']['tmp_name']) != 'image/jpeg' && mime_content_type($assignment['thumbnail']['tmp_name']) != 'image/png') {
    setError("Μόνο αρχεία JPEG και PNG επιτρέπονται.");
    return;
  }

  $file_name = getUniqueFileName($assignment['thumbnail']);
  $upload_dir = dirname(__DIR__) . '/uploads/thumbnails';

  // Δημιουργία φακέλου μεταφόρτωσης αν δεν υπάρχει.
  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
  }

  if (!move_uploaded_file($assignment['thumbnail']['tmp_name'], "$upload_dir/$file_name")) {
    setError("Σφάλμα κατά την αποθήκευση της εικόνας.");
    return;
  }

  // Ενημέρωση μονοπατιού εικόνας.
  $assignment['thumbnail'] = $file_name;

  if (insertAssignment($assignment)) {
    setSuccess("Η εργασία δημιουργήθηκε επιτυχώς.");
  } else {
    setError("Σφάλμα κατά την δημιουργία της εργασίας.");
  }
}

/**
 * Επιστρέφει όλα τα στοιχεία ενός φοιτητή με το δοθέν ID.
 * Δομή επιστροφής: array με κλειδιά 'profile', 'lessons', 'submissions'
 * 
 * Αν προκύψει σφάλμα, θέτει το κατάλληλο μήνυμα σφάλματος και επιστρέφει null.
 */
function getStudentDetails(int|string $studentId = null): ?array
{
  if (!isset($studentId)) {
    return null;
  }

  // Φόρτωση προφίλ φοιτητή
  $profile = getStudentProfile($studentId);
  if (!$profile && $studentId) {
    setError("Σφάλμα φόρτωσης προφίλ φοιτητή.");
    return null;
  }

  // Φόρτωση εγγεγραμμένων μαθημάτων
  $lessons = getStudentEnrolledLessons($studentId);
  if ($lessons === null && $studentId) {
    setError("Σφάλμα φόρτωσης μαθημάτων φοιτητή.");
    return null;
  }

  // Φόρτωση υποβολών
  $submissions = getStudentSubmissions($studentId);
  if ($submissions === null && $studentId) {
    setError("Σφάλμα φόρτωσης υποβολών φοιτητή.");
    return null;
  }

  // Επιστροφή συγκεντρωμένων στοιχείων
  return [
    'profile' => $profile,
    'lessons' => $lessons,
    'submissions' => $submissions
  ];
}

/**
 * Επιστρέφει το προφίλ του χρήστη.
 * 
 * Αν προκύψει σφάλμα, θέτει το κατάλληλο μήνυμα σφάλματος και επιστρέφει null.
 */
function getUserProfile(): mixed
{
  return getUserData() ?: [];
}

/**
 * Αποθηκεύει τα στοιχεία του χρήστη στη βάση δεδομένων.
 * 
 * Αν προκύψει σφάλμα, θέτει το κατάλληλο μήνυμα σφάλματος και επιστρέφει false.
 */
function saveUserProfile($profileData): bool
{
  if (saveUserData($profileData) && updateUserEmail($profileData['email'])) {
    setSuccess("Τα στοιχεία αποθηκεύτηκαν επιτυχώς!");
    return true;
  } else {
    setError("Σφάλμα αποθήκευσης. Δοκιμάστε ξανά.");
    return false;
  }
}

/**
 * Ελέγχει αν τα στοιχεία στις παραμέτρους είναι έγκυρα και αντιστοιχούν σε χρήστη.
 * 
 * @return bool Επιστρέφει true αν τα στοιχεία είναι έγκυρα και αντιστοιχούν σε χρήστη, αλλιώς false.
 */
function loginUser(string|null $username = null, string|null $password = null): bool
{
  // Αν δεν υπάρχουν απαιτούμενα πεδία, σταματάμε την εκτέλεση.
  if (!isset($username) || !isset($password)) {
    setError("Συμπληρώστε όλα τα πεδία");
    return false;
  }

  try {
    $user = getUserByUsername($username);

    if (!$user) {
      setError("Λάθος email ή κωδικός");
      return false;
    }

    if (!password_verify($password, $user['password'])) {
      setError("Λάθος email ή κωδικός");
      return false;
    }

    // Αποθήκευση στοιχείων χρήστη σε session
    setUserId($user['id']);
    setUserRole($user['role']);
    setSuccess("Επιτυχής είσοδος!");

    return true;
  } catch (PDOException $e) {
    setError("Σφάλμα σύνδεσης. Δοκιμάστε ξανά αργότερα.");
    return false;
  }
}

/**
 * Εγγράφει έναν νέο χρήστη στη βάση δεδομένων αφού ελέγξει αν τα στοιχεία που δόθηκαν είναι έγκυρα.
 * 
 * @return bool Επιστρέφει true αν η εγγραφή ήταν επιτυχής, αλλιώς false
 */
function registerUser($username, $email, $password, $confirm_password): bool
{
  // Αν δεν υπάρχουν απαιτούμενα πεδία, σταματάμε την εκτέλεση.
  if (!isset($username) || !isset($email) || !isset($password)) {
    setError("Συμπληρώστε όλα τα υποχρεωτικά πεδία");
    return false;
  }

  // Επιβεβαίωση ότι οι κωδικοί ταιριάζουν.
  if ($password !== $confirm_password) {
    setError("Οι κωδικοί δεν ταιριάζουν");
    return false;
  }

  // Επιβεβαίωση ότι ο κωδικός είναι τουλάχιστον 10 χαρακτήρες.
  if (strlen($password) < 10) {
    setError("Ο κωδικός πρέπει να έχει τουλάχιστον 10 χαρακτήρες");
    return false;
  }

  // Επιβεβαίωση ότι ο κωδικός περιέχει τουλάχιστον 1 αριθμό, 1 πεζό γράμμα, 1 κεφαλαίο γράμμα και 1 ειδικό χαρακτήρα.
  if (
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[a-z]/', $password) ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[\W_]/', $password)
  ) {
    setError("Ο κωδικός πρέπει να περιέχει τουλάχιστον 1 αριθμό, 1 πεζό γράμμα, 1 κεφαλαίο γράμμα και 1 ειδικό χαρακτήρα");
    return false;
  }

  // Έλεγχος αν το username ή το email χρησιμοποιούνται ήδη
  if (checkUserExists($username, $email)) {
    setError("Το username ή email χρησιμοποιείται ήδη");
    return false;
  }

  // Hash του κωδικού πρόσβασης
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $role = 'student'; // Προεπιλεγμένος ρόλος

  if (insertUser($username, $email, $hashed_password, $role)) {
    setSuccess("Επιτυχής εγγραφή! Μπορείτε να συνδεθείτε.");
    return true;
  } else {
    setError("Σφάλμα κατά την εγγραφή. Δοκιμάστε ξανά.");
    return false;
  }
}