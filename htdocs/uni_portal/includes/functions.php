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