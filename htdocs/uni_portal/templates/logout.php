<?php
// Τερματισμός της συνεδρίας
session_unset();
session_destroy();

// Έναρξη νέας συνεδρίας
session_start();

// Επιτυχής αποσύνδεση
setSuccess("Έχετε αποσυνδεθεί επιτυχώς.");

// Ανακατεύθυνση στην σελίδα σύνδεσης
redirectTo(BASE_URL . "/login");