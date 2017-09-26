<?php
require ('classes/Database.php');

// Set default timezone
date_default_timezone_set('UTC');
    
/**************************************
* Create databases and                *
* open connections                    *
**************************************/

$database = new Database;

/**************************************
* Create tables                       *
**************************************/

$database->query('DROP TABLE IF EXISTS roles;
                CREATE TABLE IF NOT EXISTS roles (
                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                name VARCHAR(255) UNIQUE NOT NULL);');
                
$database->query('DROP TABLE IF EXISTS users;
                CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username VARCHAR(255) UNIQUE NOT NULL,
                salt VARCHAR(255) NOT NULL,
                digest VARCHAR(88) NOT NULL,
                active INTEGER NOT NULL,
                role INTEGER NOT NULL,
                FOREIGN KEY(role) REFERENCES roles(id));');
                
$database->query('DROP TABLE IF EXISTS mails;
                CREATE TABLE IF NOT EXISTS mails (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                date VARCHAR(23) UNIQUE NOT NULL,
                idSender INTEGER NOT NULL,
                idReceiver INTEGER NOT NULL,
                subject VARCHAR(255) NOT NULL,
                body TEXT(1024) NOT NULL,
                FOREIGN KEY(idSender) REFERENCES users(id),
                FOREIGN KEY(idReceiver) REFERENCES users(id));'); 

/**************************************
* Set initial data                    *
**************************************/

$roles = array(
            array('name' => 'Administrator'),
            array('name' => 'Co-worker')
            );
            
$users = array(
            array('username' => 'root',
                'salt' => 'OYiKElgWm0U6q6aVnnA0pWYYIdvSklFV4h0G3VqTg5bXoRc5S514CMVPLAIBkkcz5K5aqEOmp3YMI4vzuJVv7zY0NSkoHvdwt6aAHJutrNv8tVhudqzlOHXHTxB66ZcmuK2BHnFMsuipZQHmyMlDSga0hU2feRJiO6xxLkKd1twXNrdopam8aL6vqjtSpML69Er2U8IZRGuE6Ng1MQS1KdTBefXwV0iijYvEwWNWv2HNUb68qcYRf0zqoPXfl7l',
                'digest' => 'Ghq9k4oSb6mHqrZvV8FnqXIYLGFAr7POLJ3kiRGcoQ5Fc/dQLYnCxMOYp65Lx9Z7l9d6zJanNiun0MTlAzgrig==', //base64(SHA512(username + salt + toor))
                'active' => '1',
                'role' => '1'),
            array('username' => 'toor',
                'salt' => 'O7Bj8OS6u9aGHTbPQ4S9RlGD56sVdSIipwaNlpSAeabM3fw85HnHdNXaAr8o4BscV0B5TB2fyENrkX6sIIsWJQ6A5wLjSet8lhm9okeRYapn4bwHitF1mlXwZbiThd8AaurWZPDNksqumreWQJBhXZR7G4V9lCnU0QX0FInv95M6m580pM53BqWIS03DCMT4QHcLe8yIpaR0dmnhTsiCxoytdfHWXr6zUAoyWo04osiYEIMCI9so15BOmNE2e9u',
                'digest' => 'iwKbLW3PXsgaN/kWlMAe5AL9rceA6um4C3S6Kizpi7eflJNkokBti5w0W4WT2YUf3SOORfyDG+PuP8e2rddmGA==', //base64(SHA512(username + salt + root))
                'active' => '0',
                'role' => '1'),
            array('username' => 'loan',
                'salt' => 'ERmaWoe63V8ao5mn1YuvlT5aTw9BRbBksRBsxGS3ypIa9dKLDcxwWb9Rg7q4Vl2BkWMZMPfLoKCwOzFrdaGyXa3irdSosU5WuPL9fU49dIhfu0xwX2VkuPbhSoknkkuay0ingNMqvr1X0c38crosAh8RkyJKNurgmqu5yNpunzwaT8MDiEM806gKvOqEeGT7KET0uneKLFSYBqPvHWcgf8bMw9rs5ZdZi5X4U0r4Rhvi68NRPW6bTz1cB9qpGG6',
                'digest' => 'KCq2TlP2fCvYJMa6VARoJv0nB6JTZSKJfHHqBoNBFKIZy9A+aqlcXNZXqoEQLaCXwHyc7MW95BJP8uFCtp6Z6w==', //base64(SHA512(username + salt + 123))
                'active' => '1',
                'role' => '2'),
            array('username' => 'wojciech',
                'salt' => 'HqW9Jvu7rvK0iL8KUiuHrj8KuyNpBpQO5TwTmkATc1pSnRdq7f9WQEPxx0J2wxhULlGMbZBLL1SzL89aPlCozDbOH04dZUqigZUGJScKblDhhSdFOrgsO8aCs1GgoRuVofZQeg1lCFi4yEHeHPf3DBfJGtWvpfZAFkyaCW1JJq55zcnv95ctIIMqrUkhNcJpdiso94k4MWbUDZrt13LDTPicxKmPIS82y1hQdbMNdiKGW4hGg0Hn86Pgk8yyTog',
                'digest' => 'ZPUCEF+S3ORBU/9+LP+cqYLxd7U1IyXvVxuC+hO4eV2V46svARmaVYPr26yDYG2W8GgDaEuO9fyJuic+jXQFKg==', //base64(SHA512(username + salt + 456))
                'active' => '1',
                'role' => '2'),
            array('username' => 'tano',
                'salt' => 'beIbenqv8SYx6lQGwm7VGIXSuJa86rGKke2fDkYdovQhQeLEOdWSNcyrXxdjFlDiyF5g0ZNUh2kXNefiYnK1i4QvDgZu9K3ELEf5atro9EkNN9r4HhMVNh9SwXKFN9voQIWO6RJUY9tRcMucGfUwPBDorfCM5ewd3AtSvMAilhxy4dQPOl8dAYbasCeMcUNlTSUaVqIPdKntbUTpxmFycSOcpSeGFDuuMyLKRFtxnmKawNk1BghlSWv0eySDRQR',
                'digest' => 'gNZ59vt+Vb2c4M6xUsZVDyMhPMN24IeEVNB5OG1OQdE/S3AMzrACY9ND+f1nThIJub2MLA2g5/XxblWluD4u2A==', //base64(SHA512(username + salt + 789))
                'active' => '0',
                'role' => '2')
            );
            
$mails = array(
            array('date' => '2017-07-25T16:47:33.698',
                'idSender' => '3',
                'idReceiver' => '4',
                'subject' => 'CTF to Bucarest !',
                'body' => 'Hi Wojciech, are you ?
Are you ready to go to Bucarest ? I can not wait !!
Take care.'),
            array('date' => '2017-08-09T10:14:23.698',
                'idSender' => '4',
                'idReceiver' => '3',
                'subject' => 'RE: CTF to Bucarest !',
                'body' => 'Hello Loan !
Yes ! I am ready to go !! Do you prefer to go by plane, train or car?
Because my father offers us to take the private jet !'),
            array('date' => '2017-08-14T22:37:43.698',
                'idSender' => '5',
                'idReceiver' => '2',
                'subject' => 'Hints for Labo_01',
                'body' => 'Can you tell me the answer of the first question please.'),
            array('date' => '2017-08-25T12:12:38.388',
                'idSender' => '1',
                'idReceiver' => '3',
                'subject' => 'Welcome !',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-08-25T16:16:39.798',
                'idSender' => '1',
                'idReceiver' => '4',
                'subject' => 'Welcome !',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-09-01T18:49:38.698',
                'idSender' => '1',
                'idReceiver' => '5',
                'subject' => 'Welcome !',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-09-08T21:57:38.698',
                'idSender' => '2',
                'idReceiver' => '4',
                'subject' => 'Protect your password',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-09-22T23:36:38.698',
                'idSender' => '3',
                'idReceiver' => '4',
                'subject' => 'RE: CTF to Bucarest !',
                'body' => 'the PRIVATE JET !!!')
            );

/**************************************
* Play with databases and tables      *
**************************************/

foreach ($roles as $r) {
    $database->query("INSERT INTO roles (name) 
            VALUES ('{$r['name']}');");
}

foreach ($users as $u) {
    $database->query("INSERT INTO users (username, salt, digest, active, role) 
            VALUES ('{$u['username']}', '{$u['salt']}', '{$u['digest']}','{$u['active']}', '{$u['role']}');");
}

foreach ($mails as $m) {
    $database->query("INSERT INTO mails (date, idSender, idReceiver, subject, body) 
            VALUES ('{$m['date']}', '{$m['idSender']}', '{$m['idReceiver']}', '{$m['subject']}', '{$m['body']}');");
}

$resultsRoles = $database->query('SELECT * FROM roles;');
$resultsUsers = $database->query('SELECT * FROM users;');
$resultsMails = $database->query('SELECT * FROM mails;');

/**************************************
* Close db connections                *
**************************************/

$database->deconnection();

/**************************************
* Display data                        *
**************************************/

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
      <head>
      <title>WeChat - Display data test</title>
      <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
      </head>
      <body>
      <h1>Display data test</h1>
      <br>';

echo '<h2>Roles</h2>';
foreach($resultsRoles as $row) {
    echo 'Name: '.$row['name'].'<br/>';
    echo '<br/>';
}

echo '<h2>Users</h2>';
foreach($resultsUsers as $row) {
    echo 'Username: '.$row['username'].'<br/>';
    echo 'Salt: '.$row['salt'].'<br/>';
    echo 'Digest: '.$row['digest'].'<br/>';
    echo 'Active: '.$row['active'].'<br/>';
    echo 'Role: '.$row['role'].'<br/>';
    echo '<br/>';
}

echo '<h2>Mails</h2>';
foreach($resultsMails as $row) {
    echo 'Date: '.$row['date'].'<br/>';
    echo 'idSender: '.$row['idSender'].'<br/>';
    echo 'idReceiver: '.$row['idReceiver'].'<br/>';
    echo 'Subject: '.$row['subject'].'<br/>';
    echo 'Body: '.$row['body'].'<br/>';
    echo '<br/>';
}
        
echo '</body>
      </html>';
?>