<?php
/**
 * Αυτή η συνάρτηση ανακατευθύνει τον χρήστη σε μια άλλη διεύθυνση URL.
 */
function redirectTo($url): never
{
  header("Location: $url");
  exit();
}

/**
 * Αυτή η συνάρτηση ελέγχει αν ο χρήστης είναι συνδεδεμένος.
 */
function isLoggedIn(): bool
{
  return isset($_SESSION['user_id']);
}

/**
 * Αυτή η συνάρτηση ελέγχει αν ο χρήστης είναι φοιτητής.
 */
function isStudent(): bool
{
  return isset($_SESSION['role']) && $_SESSION['role'] == 'student';
}

/**
 * Αυτή η συνάρτηση ανακατευθύνει τον χρήστη στην σελίδα σύνδεσης αν δεν είναι συνδεδεμένος.
 */
function requireLogin(): void
{
  global $base_url;
  if (!isLoggedIn()) {
    redirectTo("$base_url/login");
  }
}

/**
 * Αυτή η συνάρτηση ανακατευθύνει τον χρήστη στην σελίδα σύνδεσης αν δεν είναι φοιτητής.
 */
function requireStudent(): void
{
  global $base_url;
  if (!isStudent()) {
    redirectTo("$base_url/login");
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