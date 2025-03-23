<?php
/*
 * Το παρόν αρχείο περιέχει ρυθμίσεις και σταθερές για την εφαρμογή.
 * Συμπεριλαμβάνει τη σύνδεση στη βάση δεδομένων και άλλες ρυθμίσεις.
 * Επίσης ξεκινά μια συνεδρία για την αποθήκευση πληροφοριών χρήστη.
 */
session_start();

// URL βάσης της εφαρμογής
const BASE_URL = 'http://localhost/uni_portal';

// Database configuration
const DB_HOST = 'localhost';
const DB_NAME = 'chondromatidis';
const DB_USER = 'root';
const DB_PASS = '';
