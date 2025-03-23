<?php
/** Το παρόν αρχείο περιέχει βοηθητικές συναρτήσεις για την εφαρμογή. */

/**
 * Αυτή η συνάρτηση επιστρέφει την τρέχουσα διεύθυνση URL.
 * Αν δεν υπάρχει, επιστρέφει `home`.
 */
function getCurrentPage(): string
{
  $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
  $segments = explode('/', $url);
  $currentPage = $segments[0] ?? 'home';
  return $currentPage;
}

/**
 * Αυτή η συνάρτηση ελέγχει αν η τρέχουσα σελίδα είναι η καθορισμένη σελίδα και επιστρέφει true ή false.
 */
function isPage($page): bool
{
  return getCurrentPage() === $page;
}

/**
 * Θέτει μια μεταβλητή χρήστη στην τρέχουσα συνεδρία.
 */
function setUserId($userId): void
{
  $_SESSION['user_id'] = $userId;
}

/**
 * Επιστρέφει το ID του χρήστη από την τρέχουσα συνεδρία.
 * Αν δεν υπάρχει, επιστρέφει null.
 */
function getUserId(): ?int
{
  if (isset($_SESSION['user_id'])) {
    return $_SESSION['user_id'];
  }
  return null;
}

/**
 * Θέτει μια μεταβλητή ρόλου στην τρέχουσα συνεδρία.
 */
function setUserRole($role): void
{
  $_SESSION['role'] = $role;
}

/**
 * Επιστρέφει το ρόλο του χρήστη από την τρέχουσα συνεδρία.
 * Αν δεν υπάρχει, επιστρέφει null.
 */
function getUserRole(): ?string
{
  if (isset($_SESSION['role'])) {
    return $_SESSION['role'];
  }
  return null;
}

/**
 * Θέτει μια μεταβλητή σφάλματος στην τρέχουσα συνεδρία.
 */
function setError($error): void
{
  $_SESSION['error'] = $error;
}

/**
 * Επιστρέφει το σφάλμα από την τρέχουσα συνεδρία.
 */
function getError(): ?string
{
  if (isset($_SESSION['error'])) {
    return $_SESSION['error'];
  }
  return null;
}

/**
 * Καθαρίζει το σφάλμα από την τρέχουσα συνεδρία.
 */
function clearError(): void
{
  unset($_SESSION['error']);
}

/**
 * Θέτει μια μεταβλητή επιτυχίας στην τρέχουσα συνεδρία.
 */
function setSuccess($success): void
{
  $_SESSION['success'] = $success;
}

/**
 * Επιστρέφει την επιτυχία από την τρέχουσα συνεδρία.
 */
function getSuccess(): ?string
{
  if (isset($_SESSION['success'])) {
    return $_SESSION['success'];
  }
  return null;
}

/**
 * Καθαρίζει την επιτυχία από την τρέχουσα συνεδρία.
 */
function clearSuccess(): void
{
  unset($_SESSION['success']);
}

/**
 * Αυτή η συνάρτηση ανακατευθύνει τον χρήστη σε μια άλλη διεύθυνση URL.
 */
function redirectTo($url): never
{
  header(header: "Location: $url");
  exit();
}

/**
 * Αυτή η συνάρτηση ελέγχει αν ο χρήστης είναι συνδεδεμένος.
 */
function isLoggedIn(): bool
{
  return (bool) getUserId();
}

/**
 * Αυτή η συνάρτηση ελέγχει αν ο χρήστης είναι φοιτητής.
 */
function isStudent(): bool
{
  return getUserRole() == 'student';
}

/**
 * Αυτή η συνάρτηση ελέγχει αν ο χρήστης είναι καθηγητής.
 */
function isTeacher(): bool
{
  return getUserRole() == 'teacher';
}

/**
 * Αυτή η συνάρτηση ανακατευθύνει τον χρήστη στην σελίδα σύνδεσης αν δεν είναι συνδεδεμένος.
 */
function requireLogin(): void
{
  if (!isLoggedIn()) {
    redirectTo(BASE_URL . "login");
  }
}

/**
 * Αυτή η συνάρτηση ανακατευθύνει τον χρήστη στην σελίδα σύνδεσης αν δεν είναι φοιτητής.
 */
function requireStudent(): void
{
  if (!isStudent()) {
    redirectTo(BASE_URL . "/login");
  }
}

function requireTeacher(): void
{
  if (!isTeacher()) {
    redirectTo(BASE_URL . "/login");
  }
}

/**
 * Αυτή η συνάρτηση ελέγχει αν η τρέχουσα αίτηση είναι GET.
 */
function isGetRequest(): bool
{
  return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Αυτή η συνάρτηση ελέγχει αν η τρέχουσα αίτηση είναι POST.
 */
function isPostRequest(): bool
{
  return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Επιστρέφει το όνομα του αρχείου με μοναδικό αναγνωριστικό.
 * Αν το αρχείο δεν υπάρχει, επιστρέφει null.
 */
function getUniqueFileName($file): string|null
{
  if (!isset($file['name']) || !getUserId()) {
    return null;
  }

  return uniqid() . "_" . basename($file['name']);
}