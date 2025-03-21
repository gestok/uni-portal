<!DOCTYPE html>
<html lang="gr">

<head>
      <meta charset="UTF-8" />
      <meta name="viewport"
            content="width=device-width, initial-scale=1.0" />
      <!-- Page Title -->
      <title><?php echo ucfirst($current_page) ?> - ΕΑΠ Platform</title>
      <link rel="icon"
            type="image/x-icon"
            href="<?php echo $base_url ?>/images/favicon.ico" />
      <!-- Normalize CSS -->
      <link rel="stylesheet"
            href="<?php echo $base_url ?>/css/normalize.css" />
      <!-- Global CSS -->
      <link rel="stylesheet"
            href="<?php echo $base_url ?>/css/styles.css" />
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
      <?php if ($current_page == 'portfolio' || $current_page == 'profile' || $current_page == 'uploader'): ?>
            <link rel="stylesheet"
                  href="<?php echo $base_url; ?>/css/<?php echo $current_page; ?>.css" />
      <?php endif; ?>
</head>

<body>
      <!-- Header -->
      <header>
            <div class="header-wrapper container">
                  <!-- Logo -->
                  <a href="<?php echo $base_url ?>"
                     title="Αρχική"
                     class="logo">
                        <img src="images/logo.png"
                             alt="ΕΑΠ Platform" />
                  </a>

                  <!-- Navigation -->
                  <nav class="navigation">
                        <!-- Home -->
                        <a href="<?php echo $base_url ?>"
                           class="<?php echo $current_page == 'home' ? 'active' : '' ?>">
                              Αρχική
                        </a>

                        <!-- Portfolio (εμφανίζεται μόνο σε φοιτητή) -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'student'): ?>
                              <a href="<?php echo $base_url ?>/portfolio"
                                 class="<?php echo $current_page == 'portfolio' ? 'active' : '' ?>">
                                    Portfolio
                              </a>
                        <?php endif; ?>

                        <!-- Profile (εμφανίζεται μόνο σε φοιτητή) -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'student'): ?>
                              <a href="<?php echo $base_url ?>/profile"
                                 class="<?php echo $current_page == 'profile' ? 'active' : '' ?>">
                                    Προφίλ
                              </a>
                        <?php endif; ?>
                  </nav>

                  <!-- Login / Logout -->
                  <div class="auth-links">
                        <?php if (isset($_SESSION['user_id'])): ?>
                              <a href="<?php echo $base_url ?>/logout"
                                 title="Αποσύνδεση"
                                 class="cta">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                              </a>
                        <?php else: ?>
                              <a href="<?php echo $base_url ?>/login"
                                 title="Είσοδος"
                                 class="cta">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                              </a>
                        <?php endif; ?>
                  </div>
            </div>
      </header>