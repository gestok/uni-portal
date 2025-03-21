<?php
session_unset();
session_destroy();

header("Location: $base_url/login");

exit();
