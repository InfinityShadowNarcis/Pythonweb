<?php
header('Content-Type: application/json; charset=utf8');

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

require 'connect.php';

switch ($request[0]) {
    case 'users':
        switch ($method) {
            case 'GET':
                GetUsers($connect, $request[1], $request[2]);
                break;
            case 'POST':
                AddUser($connect);
                break;
            default:
                break;
        }
        break;
    default:
        # code...
        break;
}


function GetUsers($connect, $login, $password)
{
    if ($login && $password) {    
        $users = mysqli_query($connect, "SELECT * FROM users WHERE login = '$login' AND pass = '$password'");

        $usersList = [];

        while ($user = mysqli_fetch_assoc($users)) {
            $usersList[] = $user;
        }

        echo json_encode($usersList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else if ($login) {    
        $users = mysqli_query($connect, "SELECT * FROM users WHERE id = '$login'");

        $usersList = [];

        while ($user = mysqli_fetch_assoc($users)) {
            $usersList[] = $user;
        }

        echo json_encode($usersList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {    
        $users = mysqli_query($connect, "SELECT * FROM users");

        $usersList = [];

        while ($user = mysqli_fetch_assoc($users)) {
            $usersList[] = $user;
        }

        echo json_encode($usersList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

function AddUser($connect)
{
    $myPostData = json_decode(file_get_contents("php://input"), true);

    if ($myPostData['login'] && $myPostData['password'] && $myPostData['name']) {
        $name = $myPostData['name'];
        $password = $myPostData['password'];
        $login = $myPostData['login'];

        mysqli_query($connect, "INSERT INTO users (login, pass, name, role) VALUES ('$login', '$password', '$name', '1')");
    };
}