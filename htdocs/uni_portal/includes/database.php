<?php
/** Δημιουργία PDO αντικειμένου για τη σύνδεση με τη βάση δεδομένων */
$pdo = null;

try {
  // Δημιουργία DSN (Data Source Name) για τη σύνδεση με τη βάση δεδομένων
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
  $pdo = new PDO($dsn, DB_USER, DB_PASS);

  // Ρύθμιση του PDO ώστε να πετάει εξαιρέσεις σε περίπτωση σφάλματος
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Σφάλμα σύνδεσης: " . $e->getMessage());
}
