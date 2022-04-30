<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <?php
            session_start();

            require '../connect.php';

            $id = $_SESSION['id'];
            $role = $_SESSION['role'];

            $id_course = $_POST['id'];
            $type = $_POST['type'];

            $courses = mysqli_query($connect, "SELECT * FROM courses WHERE id = '$id_course'");

            $course = mysqli_fetch_array($courses);

            $name = $course['name'];

            print <<<HERE
                    <div class="rightBox">
                        <h2 class="course" id="$id_course" >Список лекций курса "$name"</h2>
                HERE;

            if ($role == 2) {
                print <<<HERE
                    <div class="leftBoxDirection" id="change_course">
                        <ion-icon name="pencil-outline"></ion-icon> 
                    </div>
                HERE;
            }

            print <<<HERE
                    </div>
                HERE;

            $user_courses = mysqli_query($connect, "SELECT * FROM user_courses WHERE id_course = '$id_course' AND id_user = '$id'");

            $user_course = mysqli_fetch_array($user_courses);

            if ($role == 2) {
                print <<<HERE
                    <div class="rightBox">
                        <div class="rightBoxDirection" id="stats">
                            <ion-icon name="bar-chart-outline"></ion-icon>
                        </div>
                        <div class="iconBoxDirection" id="add_lecture">
                            <ion-icon name="add-circle-outline"></ion-icon>
                        </div>
                    </div>
                HERE;
            } else if ($role == 1 && !$user_course) {
                print <<<HERE
                    <div class="iconBoxDirection" id="join_the_course">
                        <ion-icon name="add-outline"></ion-icon>
                    </div>
                HERE;
            }
            ?>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Название</td>
                    <td>Тема</td>
                    <?php
                    if ($type == 'main') {
                        print <<<HERE
                                <td>Возможные действия</td>
                        HERE;
                    } else {
                        print <<<HERE
                                <td>Статус лекции &nbsp &nbsp &nbsp &nbsp </td>
                        HERE;
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($type == 'main') {
                    $lectures = mysqli_query($connect, "SELECT * FROM lectures WHERE id_course = '$id_course'");

                    $id_lecture;
                    $name_lecture;

                    $i = 0;
                    while ($lecture = mysqli_fetch_assoc($lectures)) {
                        $id_lecture = $lecture['id'];
                        $name_lecture = $lecture['name'];

                        $i++;

                        print <<<HERE
                                <tr class="lecture">
                                    <td class="number" id="$id_lecture">Лекция $i</td>
                                    <td class="name">$name_lecture</td>
                                    <td> <span class="status open">Просмотр</span></td>
                                </tr>
                            HERE;
                    }
                } else if ($role == 2) {
                    $lectures = mysqli_query($connect, "SELECT * FROM lectures WHERE id_course = '$id_course'");

                    $id_lecture;
                    $name_lecture;

                    $i = 0;
                    while ($lecture = mysqli_fetch_assoc($lectures)) {
                        $id_lecture = $lecture['id'];
                        $name_lecture = $lecture['name'];

                        $i++;

                        print <<<HERE
                                <tr class="lecture">
                                    <td class="number" id="$id_lecture">Лекция $i</td>
                                    <td class="name">$name_lecture</td>
                                    <td> <span class="status available">Создана</span></td>
                                </tr>
                            HERE;
                    }
                } else if ($role == 1) {
                    $lectures = mysqli_query($connect, "SELECT * FROM lectures WHERE id_course = '$id_course'");

                    $id_lecture;
                    $name_lecture;

                    $i = 0;
                    while ($lecture = mysqli_fetch_assoc($lectures)) {
                        $id_lecture = $lecture['id'];
                        $name_lecture = $lecture['name'];

                        $user_lectures = mysqli_query($connect, "SELECT s.name, u.status FROM user_lectures u JOIN statuses s ON u.status = s.id WHERE u.id_lecture = '$id_lecture' AND u.id_user = '$id'");

                        $user_lecture = mysqli_fetch_array($user_lectures);

                        $i++;

                        if ($user_lecture) {
                            $status = $user_lecture['name'];
                            $status_id = $user_lecture['status'];

                            if ($status_id == '2') {
                                $status_class = 'open';
                            } else if ($status_id == '3') {
                                $status_class = 'end';
                            }

                            print <<<HERE
                                    <tr class="lecture_user">
                                        <td class="number" id="$id_lecture">Лекция $i</td>
                                        <td class="name">$name_lecture</td>
                                        <td> <span class="status $status_class">$status</span></td>
                                    </tr>
                                HERE;
                        } else {
                            print <<<HERE
                                    <tr class="lecture_clear">
                                        <td class="number" id="$id_lecture">Лекция $i</td>
                                        <td class="name">$name_lecture</td>
                                        <td> <span class="status available">Доступна</span></td>
                                    </tr>
                                HERE;
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('.lecture_clear').click(async function() {

        const data = {
            type: 'user_lecture',
            id_lecture: $(this).find('.number')[0].id,
            id_user: $('.user')[0].id
        }

        sendRequest('POST', '../rest-api.php/lectures', data);


        await insertHTML('lecture_information.php', {
            id: $(this).find('.number')[0].id
        }, ".main_inner")
    })

    $('.lecture_user').click(async function() {

        const data = {
            id: $(this).find('.number')[0].id
        }

        await insertHTML('lecture_information.php', data, ".main_inner")
    })

    $('.lecture').click(async function() {

        const data = {
            id: $(this).find('.number')[0].id
        }

        await insertHTML('lecture_information.php', data, ".main_inner")
    })

    $('#stats').click(async function() {

        const data = {
            id: $('.course')[0].id
        }

        await insertHTML('stats.php', data, ".main_inner")
    })

    $('#add_lecture').click(async function() {

        const steps = ['1', '2']

        const Queue = Swal.mixin({
            confirmButtonText: 'Добавить',
            confirmButtonColor: '#0094a9',
            showClass: {
                backdrop: 'swal2-noanimation'
            },
            hideClass: {
                backdrop: 'swal2-noanimation'
            },

            showCancelButton: true,
            cancelButtonColor: '#0094a9',
            cancelButtonText: 'Выйти',
        })

        const {
            value: name
        } = await Queue.fire({
            input: 'text',
            title: 'Создание лекции',
            inputPlaceholder: 'Введите название лекции',

            inputValidator: (value) => {
                if (!value) {
                    return 'Введите название лекции!'
                }
            }
        })

        if (!name) {
            return
        }

        const data = {
            type: 'add',
            id: $('.course')[0].id,
            name: name,
        }

        sendRequest('POST', '../rest-api.php/lectures', data);

        Swal.fire({
            title: 'Успех',
            text: 'Новая лекция добавлена в курс',
            icon: 'success',
            confirmButtonColor: '#0094a9',
        }).then((result) => {
            insertHTML('lectures.php', {
                id: $('.course')[0].id
            }, ".main_inner")
        })
    })
    $('#change_course').click(async function() {
        const {
            value: change
        } = await Swal.fire({
            title: 'Редактирование лекции',
            input: 'text',
            inputLabel: 'Изменение названия лекции',
            confirmButtonText: 'Изменить',
            confirmButtonColor: '#0094a9',
            showDenyButton: true,
            denyButtonText: 'Удалить',
            showCloselButton: true,

            inputValidator: (value) => {
                if (!value) {
                    return 'Введите название леции!!'
                }
            },

            preConfirm: (value) => {
                const data = {
                    type: 'change_name',
                    id: $('.course')[0].id,
                    name: value,
                }

                sendRequest('POST', '../rest-api.php/courses', data);
            },

        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Успех',
                    text: 'Название лекции изменено',
                    icon: 'success',
                    confirmButtonColor: '#0094a9',
                }).then((result) => {
                    insertHTML('lecture_information.php', {
                        id: $('.lecture')[0].id
                    }, ".main_inner")
                })
            } else if (result.isDenied) {
                Swal.fire({
                    title: 'Удалить?',
                    text: 'Внесенные изменения невозможно будет отменить, курс будет полностью удален',
                    icon: 'warning',
                    confirmButtonColor: '#dc3741',
                    confirmButtonText: 'Удалить',
                    showCancelButton: true,
                    cancelButtonColor: '#0094a9',
                    cancelButtonText: 'Отменить',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = {
                            type: 'delete',
                            id: $('.course')[0].id,
                        }

                        sendRequest('POST', '../rest-api.php/courses', data);

                        Swal.fire({
                            title: 'Удален',
                            text: 'Курс удален из системы',
                            icon: 'success',
                            confirmButtonColor: '#0094a9',
                        }).then((result) => {
                            insertHTML('myCourses.php', [], ".main_inner")
                        })
                    }
                })
            }
        })
    })

    $('#join_the_course').click(async function() {
        Swal.fire({
            title: 'Вы хотите записаться на данный курс?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0094a9',
            confirmButtonText: 'Записаться',
            cancelButtonColor: '#0094a9',
            cancelButtonText: 'Выйти',

            preConfirm: (value) => {

                const data = {
                    type: 'join_the_course',
                    id_course: $('.course')[0].id,
                    id: $('.user')[0].id
                }

                sendRequest('POST', '../rest-api.php/courses', data);
            },

        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Успех',
                    text: 'Вы записанны на курс',
                    icon: 'success',
                    confirmButtonColor: '#0094a9',
                }).then((result) => {
                    insertHTML('main.php', [], ".main_inner")
                })
            }
        })
    })
</script>