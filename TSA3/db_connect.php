<?php
/**
 * Database Connection
 * alt.FPOS - Point of Sale System
 * 
 * Update these credentials for your hosting environment.
 * InfinityFree: Use the MySQL credentials from your control panel.
 */

$db_host = 'sql207.infinityfree.com';           // InfinityFree: sql__.infinityfree.com
$db_user = 'if0_43050614';                // InfinityFree: your_if_username
$db_pass = 'snuIdpEdvycM';                    // InfinityFree: your_if_password
$db_name = 'if0_43050614_altfpos';         // InfinityFree: your_if_dbname

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die('<div style="text-align:center;padding:3rem;font-family:Inter,sans-serif;color:#ff6b6b;">
        <h2>Database Connection Failed</h2>
        <p>' . htmlspecialchars($conn->connect_error) . '</p>
    </div>');
}

$conn->set_charset('utf8mb4');
