<?php

// Check PHP version.
if (PHP_VERSION_ID < 80100) {
    exit('Your PHP version must be 8.1 or higher to run CodeIgniter. Current version: ' . PHP_VERSION);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// Load the framework bootstrap file
require rtrim($paths->composerDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'codeigniter4/framework/system/Boot.php';

// Launch the application
CodeIgniter\Boot::bootWeb($paths);
