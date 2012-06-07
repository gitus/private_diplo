<?php

session_start();

require_once 'includes/global.php';

if (isset($_SESSION["auth"]) && $_SESSION["auth"]){
    if (isset($_GET['logout']) && $_GET['logout']){
        session_destroy();
        redirect('index.php');
    }
    // page de chargement des données courantes
    echo 'Bonjour, '.$_SESSION["login"].'.';
    include "common/controller.php";
}else{
    if (isset($_POST['login']) && isset($_POST['pwd'])){
        if (file_exists('data/users.xml')){
            $users = simplexml_load_file(_USER_FILE);
            foreach($users as $user){
                if (hashPasswd($_POST['pwd']) == trim($user->pwd) && $_POST['login'] == trim($user->login)){
                    $_SESSION['auth'] 	= 1;
                    $_SESSION['login'] 	= trim($user->login);
                    redirect('index.php');
                }
            }
        }else{
            echo 'Pas d\'utilisateur disponible';
        }
    }
    ?>
    <form method="POST" action="index.php">
        <label>Login :</label>
        <input type="text" name="login" />
        <label>Password :</label>
        <input type="password" name="pwd" />
        <input type="submit" value="Se connecter" />
    </form>
    <?
}
?>
