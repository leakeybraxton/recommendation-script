<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Report all errors except E_WARNING
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);

// Google Apps Script Web App URL
$googleAppsScriptURL = "https://script.google.com/macros/s/AKfycbz-Ty5jUSwk9Ji2WUjxlSaM4aBb8mNDnm4wI1CJMwENc5kK6IJbaR39HNqhOwyBs03X/exec";

$encryption_key = 'This is password yeah 9594';

function encrypt($plaintext, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); // Generate a random initialization vector
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, 0, $iv); // Encrypt the plaintext
    $ciphertext_with_iv = base64_encode($iv . $ciphertext); // Store the IV with the ciphertext for decryption
    return $ciphertext_with_iv; // Return the encrypted text in base64 format
}
function decrypt($ciphertext_base64, $key)
{
    $ciphertext_with_iv = base64_decode($ciphertext_base64); // Decode the base64 text
    $iv_length = openssl_cipher_iv_length('aes-256-cbc'); // Get the length of the initialization vector
    $iv = substr($ciphertext_with_iv, 0, $iv_length); // Extract the IV from the beginning
    $ciphertext = substr($ciphertext_with_iv, $iv_length); // Extract the ciphertext
    $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, 0, $iv); // Decrypt the ciphertext
    return $plaintext; // Return the original plaintext
}


/* The name of the database */
define('SB_DB_NAME', 'u956006469_rr_leads');

/* MySQL database username */
define('SB_DB_USER', 'root');

/* MySQL database password */
define('SB_DB_PASSWORD', '');

/* MySQL hostname */
define('SB_DB_HOST', 'localhost');

/* MySQL port (optional) */
define('SB_DB_PORT', '8080');
