<?php
session_start();

// Base URL
$base_url = 'http://localhost/uni_portal';

// Database configuration
const DB_HOST = 'localhost';
const DB_NAME = 'chondromatidis';
const DB_USER = 'root';
const DB_PASS = '';

// Routing
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$segments = explode('/', $url);
$current_page = !empty($segments[0]) ? $segments[0] : 'home';

// Error handling
$error = '';
