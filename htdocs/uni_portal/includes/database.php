<?php
try {
  // Δημιουργία DSN (Data Source Name) για τη σύνδεση με τη βάση δεδομένων
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

  // Δημιουργία PDO αντικειμένου για τη σύνδεση με τη βάση δεδομένων
  $pdo = new PDO($dsn, DB_USER, DB_PASS);

  // Ρύθμιση του PDO ώστε να πετάει εξαιρέσεις σε περίπτωση σφάλματος
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // Διαχείριση σφάλματος σύνδεσης
  die("Σφάλμα σύνδεσης: " . $e->getMessage());
}
