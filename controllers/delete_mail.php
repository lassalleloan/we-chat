<?php
/**
 * STI - Project Web
 * WeChat
 * Description: Web site to send mails between users 
 * Authors: Matthieu Chatelan, Loan Lassalle, Wojciech Myszkorowski
 */

extract(@$_GET);
require_once(dirname(__DIR__).'/models/Authentication.php');
require_once(dirname(__DIR__).'/models/Database.php');
require_once(dirname(__DIR__).'/models/Mail.php');

// Redirect the user to index.php
Authentication::get_instance()->redirect_if_is_not_logged();

// Redirect the user to home.php
Utils::get_instance()->redirect_if_is_not_correct_file_origin(array('home.php', 'read_mail.php'));

$token = isset($_SESSION['token_mail']) && isset($token) ? $token : "";
$id = isset($id) ? (int)$id : 0;

// Deletes the email
if ($_SESSION['token_mail'] === $token && 
    $id >= Database::PHP_INT_MIN && 
    $id <= Database::PHP_INT_MAX) {
    
    Mail::get_instance()->redirect_if_is_not_associate_to_user($id);
    Mail::get_instance()->delete_one($id);

    // Closes the connection to the database
    Database::get_instance()->deconnection();
}

header('location:/wechat/home.php');
?>
