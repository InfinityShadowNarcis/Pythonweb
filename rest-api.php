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
    case 'skill_levels':
        switch ($method) {
            case 'GET':
                GetSkillLevels($connect);
                break;
            default:
                break;
        }
        break;
    case 'courses':
        switch ($method) {
            case 'GET':
                GetCourses($connect, $request[1]);
                break;
            case 'POST':
                AddCourse($connect);
                break;
            default:
                break;
        }
        break;
    case 'lectures':
        switch ($method) {
            case 'GET':
                Getlectures($connect, $request[1]);
                break;
            case 'POST':
                Addlecture($connect);
                break;
            default:
                break;
        }
        break;
    case 'informetion':
        switch ($method) {
            case 'GET':
                GetInformetion($connect, $request[1]);
                break;
            case 'POST':
                AddInformetion($connect);
                break;
            default:
                break;
        }
        break;
    case 'tasks':
        switch ($method) {
            case 'POST':
                AddTasks($connect);
                break;
            default:
                break;
        }
        break;
    default:
        # code...
        break;
}


function GetSkillLevels($connect){
    $levels = mysqli_query($connect, "SELECT * FROM skill_levels");

    $levelsList = [];

    while ($level = mysqli_fetch_assoc($levels)) {
        $levelsList[] = $level;
    }

    echo json_encode($levelsList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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

        $user = mysqli_query($connect, "SELECT * FROM users where login = '$login'");

        if (!$user) {
            mysqli_query($connect, "INSERT INTO users (login, pass, name, role) VALUES ('$login', '$password', '$name', '1')");
        }
    };
}

function GetCourses($connect, $id) {
    if ($id) {
        $courses = mysqli_query($connect, "SELECT * FROM courses WHERE host_id = '$id'");
    } else {
        $courses = mysqli_query($connect, "SELECT * FROM courses");
    }

    $coursesList = [];

    while ($course = mysqli_fetch_assoc($courses)) {
        $coursesList[] = $course;
    }

    echo json_encode($coursesList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function AddCourse($connect)
{
    $myPostData = json_decode(file_get_contents("php://input"), true);

    switch ($myPostData['type']) {
        case 'add':
            if ($myPostData['id'] && $myPostData['name'] && $myPostData['skill_level']) {
                $id = $myPostData['id'];
                $name = $myPostData['name'];
                $skill_level = $myPostData['skill_level'];
        
                mysqli_query($connect, "INSERT INTO courses(host_id, name, skill_lvl) VALUES ('$id','$name','$skill_level')");
            };
            break;
        case 'change_name':
            if ($myPostData['id'] && $myPostData['name']) {
                $id = $myPostData['id'];
                $name = $myPostData['name'];
        
                mysqli_query($connect, "UPDATE courses SET name = '$name' WHERE id = '$id'");
            };
            break;
        case 'delete':
            if ($myPostData['id']) {
                $id = $myPostData['id'];
        
                mysqli_query($connect, "DELETE FROM courses WHERE id = '$id'");
            };
            break;
        default:
            # code...
            break;
    }
}

function GetLectures($connect, $id) {
    if ($id) {
        $lectures = mysqli_query($connect, "SELECT * FROM lectures WHERE id_course = '$id'");
    }

    $lecturesList = [];

    while ($lecture = mysqli_fetch_assoc($lectures)) {
        $lecturesList[] = $lecture;
    }

    echo json_encode($lecturesList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function AddLecture($connect)
{
    $myPostData = json_decode(file_get_contents("php://input"), true);

    switch ($myPostData['type']) {
        case 'add':
            if ($myPostData['id'] && $myPostData['name']) {
                $id = $myPostData['id'];
                $name = $myPostData['name'];
        
                mysqli_query($connect, "INSERT INTO lectures (id_course, name) VALUES ('$id','$name')");
            };
            break;
        case 'change_name':
            if ($myPostData['id'] && $myPostData['name']) {
                $id = $myPostData['id'];
                $name = $myPostData['name'];
        
                mysqli_query($connect, "UPDATE lectures SET name = '$name' WHERE id = '$id'");
            };
            break;
        case 'delete':
            if ($myPostData['id']) {
                $id = $myPostData['id'];
        
                mysqli_query($connect, "DELETE FROM lectures WHERE id = '$id'");
            };
            break;
        default:
            # code...
            break;
    }
}

function GetInformetion($connect, $id) {
    if ($id) {
        $informations = mysqli_query($connect, "SELECT * FROM information WHERE id_lecture = '$id'");
    }

    $informationsList = [];

    while ($information = mysqli_fetch_assoc($informations)) {
        $informationsList[] = $information;
    }

    echo json_encode($informationsList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function AddInformetion($connect)
{
    $myPostData = json_decode(file_get_contents("php://input"), true);

    if($_POST['type']) {
        $post_type = $_POST['type'];
    } else if ($myPostData['type']) {
        $post_type = $myPostData['type'];
    }

    switch ($post_type) {
        case 'add_text':
            if ($myPostData['id'] && $myPostData['text'] && $myPostData['setting']) {
                $id = $myPostData['id'];
                $text = $myPostData['text'];
                $setting = $myPostData['setting'];
        
                mysqli_query($connect, "INSERT INTO information (id_lecture, information, type, setting) VALUES ('$id', '$text', 'text','$setting')");
            };
            break;
        case 'add_image':
            if ($_POST['id'] && $_POST['name']) {
                $id = $_POST['id'];
                $name = $_POST['name'];

                mysqli_query($connect, "INSERT INTO information (id_lecture, type, setting) VALUES ('$id', 'image', '$name')");

                $id_information = mysqli_insert_id($connect);

                foreach ($_FILES as $key => $file) {
                    $file['name'] = 'lecture_' . $id_information . '_image' . '.png';
        
                    move_uploaded_file($file['tmp_name'], 'images/lectures/' . $file['name']);
            
                    $file_url = 'https://python.petropavlovsk.kz/images/lectures/' . $file['name'];
        
                    mysqli_query($connect, "UPDATE information SET information = '$file_url' WHERE id = '$id_information'");
                }
            };
            break;
        default:
            # code...
            break;
    }
}

function AddTasks($connect)
{
    $myPostData = json_decode(file_get_contents("php://input"), true);

    switch ($myPostData['type']) {
        case 'add_task':
            if ($myPostData['id'] && $myPostData['task'] && $myPostData['input'] && $myPostData['output']) {
                $id = $myPostData['id'];
                $task = $myPostData['task'];
                $input = $myPostData['input'];
                $output = $myPostData['output'];
        
                mysqli_query($connect, "INSERT INTO tasks (id_lecture, task, input, output) VALUES ('$id', '$task', '$input', '$output')");
            };
            break;
        
        default:
            # code...
            break;
    }
}
