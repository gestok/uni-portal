<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/helpers.php';
require_once 'includes/functions.php';
require_once 'includes/queries.php';

// Έλεγχος ρόλων πριν την εμφάνιση της σελίδας
switch (getCurrentPage()):
  // Portfolio, Uploader, Profile
  case 'portfolio':
  case 'uploader':
  case 'profile':
    requireStudent();
    break;

  // Δημιουργία Εργασίας, Εργασίες, Φοιτητές
  case 'create':
  case 'assignments':
  case 'students':
    requireTeacher();
    break;

  // Login, Register
  case 'login':
  case 'register':
    if (isLoggedIn()) {
      redirectTo(BASE_URL . "/home");
    }
    break;

  // Logout
  case 'logout':
    if (!isLoggedIn()) {
      redirectTo(BASE_URL . "/home");
    }
    break;
endswitch;

// Header
require_once 'templates/header.php';

// Συμπερίληψη του κατάλληλου template ανάλογα με την τρέχουσα σελίδα
switch (getCurrentPage()):
  // Portfolio
  case 'portfolio':
    include 'templates/portfolio.php';
    break;

  // Uploader
  case 'uploader':
    include 'templates/uploader.php';
    break;

  // User Profile
  case 'profile':
    include 'templates/profile.php';
    break;

  // Δημιουργία Εργασίας
  case 'create':
    include 'templates/create.php';
    break;

  // Εργασίες
  case 'assignments':
    include 'templates/assignments.php';
    break;

  // Φοιτητές
  case 'students':
    include 'templates/students.php';
    break;

  // Login
  case 'login':
    include 'templates/login.php';
    break;

  // Logout
  case 'logout':
    include 'templates/logout.php';
    break;

  // Register
  case 'register':
    include 'templates/register.php';
    break;

  // Home
  case 'home':
  // Ή αν η σελίδα δεν υπάρχει
  default:
    include 'templates/home.php';
    break;
endswitch;

// Footer
require_once 'templates/footer.php';