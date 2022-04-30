<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <?php 
                session_start();

                require '../connect.php';

                $id = $_SESSION['id'];
                $role = $_SESSION['role'];

                $id_lecture = $_POST['id'];

                $lectures = mysqli_query($connect, "SELECT * FROM lectures WHERE id = '$id_lecture'");

                $lecture = mysqli_fetch_array($lectures);

                $name = $lecture['name'];
                $id_course = $lecture['id_course'];
                
                print <<<HERE
                    <div class="rightBox">
                        <h2 class="lecture" id="$id_lecture" >Содержание лекции "$name"</h2>
                HERE;
                
                if ($role == 2) {
                    print <<<HERE
                    <div class="leftBoxDirection" id="change_lecture">
                        <ion-icon name="pencil-outline"></ion-icon>
                        <input id="course" type="hidden" value='$id_course'> 
                    </div>
                    HERE;
                }
                print <<<HERE
                    </div>
                HERE;
                
                if ($role == 2) {
                    print <<<HERE
                    <div class="rightBox">
                        <div class="rightBoxDirection" id="add_text">
                            <ion-icon name="reorder-four-outline"></ion-icon>
                        </div>
                        <div class="rightBoxDirection" id="add_image">
                            <ion-icon name="image-outline"></ion-icon>
                        </div>
                        <div class="rightBoxDirection" id="add_task">
                            <ion-icon name="duplicate-outline"></ion-icon>
                        </div>
                    </div>
                HERE;
                }

                if ($role == 1) {
                    print <<<HERE
                        <div class="rightBoxDirection" id="back">
                            <ion-icon name="return-up-back-outline"></ion-icon>
                            <input id="course" type="hidden" value='$id_course'> 
                        </div>
                HERE;
                }
            ?>
        </div>
        <div>
            <?php
                $informations = mysqli_query($connect, "SELECT * FROM information WHERE id_lecture = '$id_lecture'");

                $id_information;
                $information_inner;
                $type;
                $setting;

                $i = 0;
                $j = 0;
                while($information = mysqli_fetch_assoc($informations)) {
                    $id_information = $information['id'];
                    $information_inner = $information['information'];
                    $type = $information['type'];
                    $setting = $information['setting'];

                    $i++;

                    switch ($setting) {
                        case 'header':
                            $text_type = 'text_header';
                            break;
                        case 'ordinary':
                            $text_type = 'text_ordinary';
                            break;
                        case 'important':
                            $text_type = 'text_important';
                            break;
                        default:
                            break;
                    }

                    switch ($type) {
                        case 'text':
                            print <<<HERE
                                <p class="$text_type">
                                    $information_inner
                                <p>
                            HERE;
                            break;
                        case 'image':
                            $j++;
                            print <<<HERE
                                <div class="lecture_image">
                                    <img src="$information_inner">
                                    <p>Рисунок $j "$setting"<p>
                                </div>
                            HERE;
                            break;
                        default:
                            # code...
                            break;
                    }    
                }

                $tasks = mysqli_query($connect, "SELECT * FROM tasks WHERE id_lecture = '$id_lecture'");

                $id_task;
                $task_inner;
                $input;
                $output;

                $i = 0;
                while($task = mysqli_fetch_assoc($tasks)) {
                    $id_task = $task['id'];
                    $task_inner = $task['task'];
                    $input = $task['input'];
                    $output = $task['output'];

                    $i++;

                    print <<<HERE
                        <br>
                        <p class="text_important">
                            Задание $i
                        <p>
                        <p class="text_ordinary">
                            $task_inner
                        <p>
                        <p>
                            Ввод: $input
                            <br><br>
                            Вывод: $output
                        <p>
                        <textarea class="input_area" placeholder="Введите ваш код сюда"></textarea>
                    HERE;    
                }

                $user_lectures = mysqli_query($connect, "SELECT * FROM user_lectures u JOIN statuses s ON u.status = s.id WHERE u.id_lecture = '$id_lecture' AND u.id_user = '$id'");

                $user_lecture = mysqli_fetch_array($user_lectures);

                if($user_lecture && $user_lecture['status'] == '2') {
                    print <<<HERE
                        <div class="cardBox">
                        <div class="card" id="check">
                            <div>
                                <div class="numbers">Проверить решение</div>
                            </div>
                            <div class="iconBx">
                                <ion-icon name="checkmark-circle-outline"></ion-icon>
                            </div>
                        </div>    
                        <div class="card" id="send">
                            <div>
                                <div class="numbers">Завершить лекцию</div>
                            </div>
                            <div class="iconBx">
                                <ion-icon name="checkmark-done-circle-outline"></ion-icon>
                            </div>
                        </div>      
                    </div>
                HERE;  
                }
            ?>
        </div>
    </div>
</div>

<script>
    $('#back').click(async function() {

    const data = {
        id: $('#course').val(),
    }

    await insertHTML('lectures.php', data, ".main_inner")
    })

    $('#add_text').click(async function(){

        const types = {
            header: 'Заголовок',
            ordinary: 'Обычный текст',
            important: 'Важный текст',
        }

        const steps = ['1', '2']

        const Queue = Swal.mixin({
        progressSteps: steps,
        confirmButtonText: 'Далее >',
        confirmButtonColor: '#0094a9',
        showClass: { backdrop: 'swal2-noanimation' },
        hideClass: { backdrop: 'swal2-noanimation' },

        showCancelButton: true,
        cancelButtonColor: '#0094a9',
        cancelButtonText: 'Выйти',
        })

        const { value: text } = await Queue.fire({
        currentProgressStep: 0,
        input: 'textarea',
        title: 'Добавление текста',
        inputPlaceholder: 'Введите текст',

        inputValidator: (value) => {
            if (!value) {
            return 'Введите текст!'
            }
        }
        })

        if(!text) {
            return
        }

        const { value: type} = await Queue.fire({
        currentProgressStep: 1,

        input: 'select',
        title: 'Добавление текста',
        inputOptions: types,
        inputPlaceholder: 'Выберите тип текста',
        confirmButtonText: 'Добавить',

        inputValidator: (value) => {
            if (!value) {
            return 'Выберите тип текста!'
            }
        }
        })

        if(!type) {
            return
        }

        const data = {
            type: 'add_text',
            id: $('.lecture')[0].id,
            text: text,
            setting: type,
        }

        sendRequest('POST', '../rest-api.php/informetion', data);

        Swal.fire({
            title: 'Успех',
            text: 'Текст добавлен в лекцию',
            icon: 'success',
            confirmButtonColor: '#0094a9',
        }).then((result) => {
            insertHTML('lecture_information.php', {id: $('.lecture')[0].id}, ".main_inner")
        })
    })
    
    $('#add_image').click(async function(){
        const steps = ['1', '2']

        const Queue = Swal.mixin({
        progressSteps: steps,
        confirmButtonText: 'Далее >',
        confirmButtonColor: '#0094a9',
        showClass: { backdrop: 'swal2-noanimation' },
        hideClass: { backdrop: 'swal2-noanimation' },

        showCancelButton: true,
        cancelButtonColor: '#0094a9',
        cancelButtonText: 'Выйти',
        })

        const { value: name } = await Queue.fire({
        currentProgressStep: 0,
        input: 'text',
        title: 'Добавление рисунка',
        inputPlaceholder: 'Введите название',

        inputValidator: (value) => {
            if (!value) {
            return 'Введите название!'
            }
        }
        })

        if(!name) {
            return
        }

        const { value: image} = await Queue.fire({
        currentProgressStep: 1,

        title: 'Добавление рисунка',
        input: 'file',
        text: 'Выберите изображение',
        inputAttributes: {
            'accept': 'image/*',
        },
        confirmButtonText: 'Добавить',
        confirmButtonColor: '#0094a9',

        inputValidator: (value) => {
            if (!value) {
            return 'Выберите изображение!'
            }
        }
        })

        if(!image) {
            return
        }

        const data = new FormData();
        data.append('type', 'add_image');
        data.append('id', $('.lecture')[0].id);
        data.append('Image', image);
        data.append('name', name);
        
        sendRequestWithImage('../rest-api.php/informetion', data);

        Swal.fire({
            title: 'Успех',
            text: 'Текст добавлен в лекцию',
            icon: 'success',
            confirmButtonColor: '#0094a9',
        }).then((result) => {
            insertHTML('lecture_information.php', {id: $('.lecture')[0].id}, ".main_inner")
        })
    })

    $('#add_task').click(async function(){
        const steps = ['1', '2', '3']

        const Queue = Swal.mixin({
        progressSteps: steps,
        confirmButtonText: 'Далее >',
        confirmButtonColor: '#0094a9',
        showClass: { backdrop: 'swal2-noanimation' },
        hideClass: { backdrop: 'swal2-noanimation' },

        showCancelButton: true,
        cancelButtonColor: '#0094a9',
        cancelButtonText: 'Выйти',
        })

        const { value: task } = await Queue.fire({
        currentProgressStep: 0,
        input: 'textarea',
        title: 'Добавление задания',
        inputPlaceholder: 'Введите формуровку задания',

        inputValidator: (value) => {
            if (!value) {
            return 'Введите формуровку задания!'
            }
        }
        })

        if(!task) {
            return
        }

        const { value: input} = await Queue.fire({
        currentProgressStep: 1,

        input: 'text',
        title: 'Добавление задания',
        inputPlaceholder: 'Введите входные данные',

        inputValidator: (value) => {
            if (!value) {
            return 'Введите входные данные!'
            }
        }

        })

        if(!input) {
            return
        }

        const { value: output} = await Queue.fire({
        currentProgressStep: 2,

        input: 'text',
        title: 'Добавление задания',
        inputPlaceholder: 'Введите ожидаемые данные',

        inputValidator: (value) => {
            if (!value) {
            return 'Введите ожидаемые данные!'
            }
        }

        })

        if(!output) {
            return
        }

        const data = {
            type: 'add_task',
            id: $('.lecture')[0].id,
            task: task,
            input: input,
            output: output
        }

        sendRequest('POST', '../rest-api.php/tasks', data);

        Swal.fire({
            title: 'Успех',
            text: 'Задание добавлено в лекцию',
            icon: 'success',
            confirmButtonColor: '#0094a9',
        }).then((result) => {
            insertHTML('lecture_information.php', {id: $('.lecture')[0].id}, ".main_inner")
        })
    })

    $('#change_lecture').click(async function(){
        const { value: change } = await Swal.fire({
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
                id: $('.lecture')[0].id,
                name: value,
            }

            sendRequest('POST', '../rest-api.php/lectures', data);
        },

        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: 'Успех',
            text: 'Название лекции изменено',
            icon: 'success',
            confirmButtonColor: '#0094a9',
        }).then((result) => {
            insertHTML('lecture_information.php', {id: $('.lecture')[0].id}, ".main_inner")
        })
        } else if (result.isDenied) {
            Swal.fire({
            title: 'Удалить?',
            text: 'Внесенные изменения невозможно будет отменить, лекция будет полностью удалена',
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
                    id: $('.lecture')[0].id,
                }

                sendRequest('POST', '../rest-api.php/lectures', data);

                Swal.fire({
                    title: 'Удалена',
                    text: 'Лекция удалена из курса',
                    icon: 'success',
                    confirmButtonColor: '#0094a9',
                }).then((result) => {
                    insertHTML('lectures.php', {id: $('#course').val()}, ".main_inner")  
                })
            }
            })
        }
        })
    })

    $('#check').click(async function(){
        let timerInterval
        Swal.fire({
            title: 'Проверка кода',
            html: 'Это может занять некоторое время',
            timer: 4000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            Swal.fire({
                title: 'Проверка завершена',
                text: 'Ваш код прошел все тесты',
                icon: 'success',
                confirmButtonColor: '#0094a9',
            }).then((result) => {
                insertHTML('lecture_information.php', {id: $('.lecture')[0].id}, ".main_inner")
            })
        }
        })
    })

    $('#send').click(async function(){
        Swal.fire({
        title: 'Завершить?',
        text: 'Данное действие невозможно будет отменить',
        icon: 'question',
        confirmButtonColor: '#0094a9',
        confirmButtonText: 'Завершить',
        showCancelButton: true,
        cancelButtonColor: '#0094a9',
        cancelButtonText: 'Отменить',
        }).then((result) => {
        if (result.isConfirmed) {
            const data = {
                type: 'send',
                id_lecture: $('.lecture')[0].id,
                id_user: $('.user')[0].id,
                rating: '100',
            }

            sendRequest('POST', '../rest-api.php/lectures', data);

            Swal.fire({
                title: 'Успех',
                text: 'Вы завершили лекцию',
                icon: 'success',
                confirmButtonColor: '#0094a9',
            }).then((result) => {
                insertHTML('lecture_information.php', {id: $('.lecture')[0].id}, ".main_inner")
            })
        }
        })
    })
</script>