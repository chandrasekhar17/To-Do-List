<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $favouriteCricketer = htmlspecialchars($_POST['favouriteCricketer']);

    echo 'This is the submitted data:';
    echo '<br>';
    echo 'first name :'.$firstname;
    echo '<br>';
    echo 'last name :'.$lastname;
    echo '<br>';
    echo 'favourite cricketer :'.$favouriteCricketer;
}
