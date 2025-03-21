<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Συμπεριλαμβάνουμε το αντίστοιχο αρχείο PHP με βάση το πρώτο τμήμα της διεύθυνσης URL
switch ($current_page):
  // Portfolio
  case 'portfolio':
    requireStudent();
    include 'templates/portfolio.php';
    break;

  // Uploader
  case 'uploader':
    requireStudent();
    include 'templates/uploader.php';
    break;

  // User Profile
  case 'profile':
    requireStudent();
    include 'templates/profile.php';
    break;

  // Login
  case 'login':
    if (isLoggedIn()) {
      redirectTo("$base_url/home");
    }
    include 'templates/login.php';
    break;

  // Logout
  case 'logout':
    if (!isLoggedIn()) {
      redirectTo("$base_url/home");
    }
    include 'templates/logout.php';
    break;

  // Register
  case 'register':
    if (isLoggedIn()) {
      redirectTo("$base_url/home");
    }
    include 'templates/register.php';
    break;

  // Home
  case 'home':
  // Ή αν η σελίδα δεν υπάρχει, επανακατευθύνουμε στην αρχική σελίδα
  default:
    include 'templates/home.php';
    break;
endswitch;

// Footer
require_once 'includes/footer.php';