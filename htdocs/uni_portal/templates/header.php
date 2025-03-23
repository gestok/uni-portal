<!DOCTYPE html>
<html lang="gr">

<head>
      <meta charset="UTF-8" />
      <meta name="viewport"
            content="width=device-width, initial-scale=1.0" />
      <!-- Page Title -->
      <title><?php echo ucfirst(getCurrentPage()) ?> - ΕΑΠ Platform</title>
      <link rel="icon"
            type="image/x-icon"
            href="<?php echo BASE_URL; ?>/static/favicon.ico" />
      <!-- Normalize CSS -->
      <link rel="stylesheet"
            href="<?php echo BASE_URL; ?>/css/normalize.css" />
      <!-- Global CSS -->
      <link rel="stylesheet"
            href="<?php echo BASE_URL; ?>/css/styles.css" />
      <!-- Notifications CSS -->
      <link rel="stylesheet"
            href="<?php echo BASE_URL; ?>/css/notifications.css" />
      <!-- Google Fonts -->
      <link rel="preconnect"
            href="https://fonts.googleapis.com">
      <link rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
      <!-- Font Awesome -->
      <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
      <!-- Custom CSS ανάλογα με τη σελίδα -->
      <?php if (isPage('portfolio') || isPage('profile') || isPage('uploader')): ?>
            <link rel="stylesheet"
                  href="<?php echo BASE_URL; ?>/css/<?php echo getCurrentPage(); ?>.css" />
      <?php endif; ?>
</head>

<body>
      <!-- Header -->
      <header>
            <div class="header-wrapper container">
                  <!-- Λογότυπο -->
                  <a href="<?php echo BASE_URL; ?>"
                     title="Αρχική"
                     class="logo">
                        <img src="static/logo.png"
                             alt="ΕΑΠ Platform" />
                  </a>

                  <!-- Μπάρα περιήγησης -->
                  <nav class="navigation">
                        <!-- Αρχική -->
                        <a href="<?php echo BASE_URL; ?>"
                           class="<?php echo isPage('home') ? 'active' : '' ?>">
                              Αρχική
                        </a>

                        <!-- Portfolio (εμφανίζεται μόνο σε φοιτητή) -->
                        <?php if (isStudent()): ?>
                              <a href="<?php echo BASE_URL; ?>/portfolio"
                                 class="<?php echo isPage('portfolio') ? 'active' : '' ?>">
                                    Portfolio
                              </a>
                        <?php endif; ?>

                        <!-- Profile (εμφανίζεται μόνο σε φοιτητή) -->
                        <?php if (isStudent()): ?>
                              <a href="<?php echo BASE_URL; ?>/profile"
                                 class="<?php echo isPage('profile') ? 'active' : '' ?>">
                                    Προφίλ
                              </a>
                        <?php endif; ?>

                        <!-- Δημιουργία (εμφανίζεται μόνο σε καθηγητή) -->
                        <?php if (isTeacher()): ?>
                              <a href="<?php echo BASE_URL; ?>/create"
                                 class="<?php echo isPage('create') ? 'active' : '' ?>">
                                    Δημιουργία
                              </a>
                        <?php endif; ?>

                        <!-- Εργασίες (εμφανίζεται μόνο σε καθηγητή) -->
                        <?php if (isTeacher()): ?>
                              <a href="<?php echo BASE_URL; ?>/assignments"
                                 class="<?php echo isPage('assignments') ? 'active' : '' ?>">
                                    Εργασίες
                              </a>
                        <?php endif; ?>

                        <!-- Φοιτητές (εμφανίζεται μόνο σε καθηγητή) -->
                        <?php if (isTeacher()): ?>
                              <a href="<?php echo BASE_URL; ?>/students"
                                 class="<?php echo isPage('students') ? 'active' : '' ?>">
                                    Φοιτητές
                              </a>
                        <?php endif; ?>
                  </nav>

                  <!-- Login / Logout -->
                  <div class="auth-links">
                        <?php if (isLoggedIn()): ?>
                              <a href="<?php echo BASE_URL; ?>/logout"
                                 title="Αποσύνδεση"
                                 class="cta">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                              </a>
                        <?php else: ?>
                              <a href="<?php echo BASE_URL; ?>/login"
                                 title="Είσοδος"
                                 class="cta">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                              </a>
                        <?php endif; ?>
                  </div>
            </div>
      </header>