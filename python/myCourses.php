<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Мои курсы</h2>
            <?php 
                session_start();

                $id = $_SESSION['id'];
                $role = $_SESSION['role'];
                
                if ($role == 2) {
                    print <<<HERE
                    <div class="iconBoxDirection" id="add_course">
                        <ion-icon name="add-circle-outline"></ion-icon>
                    </div>
                HERE;
                }
            ?>
        </div>
        <?php
            require '../connect.php';

            if ($role == 2) {

                print <<<HERE
                    <table>
                        <thead>
                            <tr>
                                <td>Название</td>
                                <td>Создатель</td>
                                <td>Уровень сложности</td>
                            </tr>
                        </thead>
                    <tbody>
                HERE;

                $courses = mysqli_query($connect, "SELECT u.name AS host, c.id, c.name, s.name AS level_name, c.skill_lvl FROM courses c JOIN users u ON c.host_id = u.id 
                JOIN skill_levels s ON c.skill_lvl = s.id WHERE c.host_id = '$id'");

                $id_course;
                $host;
                $name;
                $skill_level;
                $status;

                while($course = mysqli_fetch_assoc($courses)) {
                    $id_course = $course['id'];
                    $name = $course['name'];
                    $host = $course['host'];
                    $skill_level = $course['skill_lvl'];
                    $level_name = $course['level_name'];

                    switch ($skill_level) {
                        case '1':
                            $status = 'good';
                            break;
                        case '2':
                            $status = 'medium';
                            break;
                        case '3':
                            $status = 'bad';
                            break;       
                    }

                    print <<<HERE
                        <tr class="course">
                            <td class="name" id="$id_course">$name</td>
                            <td class="name_host">$host</td>
                            <td> <span class="status $status">$level_name</span></td>
                        </tr>
                    HERE;
                }

                print <<<HERE
                        </tbody>
                    </table>
                HERE;
            } else if ($role == 1) {
                 print <<<HERE
                    <table>
                        <thead>
                            <tr>
                                <td>Название</td>
                                <td>Создатель</td>
                                <td>Уровень сложности</td>
                            </tr>
                        </thead>
                    <tbody>
                HERE;

                $courses = mysqli_query($connect, "SELECT u.name AS host, c.id, c.name, s.name AS level_name, c.skill_lvl FROM courses c JOIN users u ON c.host_id = u.id 
                JOIN skill_levels s ON c.skill_lvl = s.id JOIN user_courses us ON c.id = us.id_course WHERE us.id_user = '$id'");

                $id_course;
                $host;
                $name;
                $skill_level;
                $status;

                while($course = mysqli_fetch_assoc($courses)) {
                    $id_course = $course['id'];
                    $name = $course['name'];
                    $host = $course['host'];
                    $skill_level = $course['skill_lvl'];
                    $level_name = $course['level_name'];

                    switch ($skill_level) {
                        case '1':
                            $status = 'good';
                            break;
                        case '2':
                            $status = 'medium';
                            break;
                        case '3':
                            $status = 'bad';
                            break;       
                    }

                    print <<<HERE
                        <tr class="course">
                            <td class="name" id="$id_course">$name</td>
                            <td class="name_host">$host</td>
                            <td> <span class="status $status">$level_name</span></td>
                        </tr>
                    HERE;
                }

                print <<<HERE
                        </tbody>
                    </table>
                HERE;
            } else {
                print <<<HERE
                    <p class="text_header"> Войдите в систему чтобы записаться на курсы</p>
                HERE;
            }
        ?>
    </div>
</div>

<script>
    $('.course').click(async function(){

    const data = {
        id: $(this).find('.name')[0].id
    }

    await insertHTML('lectures.php', data, ".main_inner")
    })

    $('#add_course').click(async function(){

        const skillLevels = {}

        await $.get("../rest-api.php/skill_levels", function(data) {
            data.forEach((item) => {
                skillLevels[item['id']] = item['name'];
            })
        })

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
        title: 'Создание курса',
        inputPlaceholder: 'Введите название курса',

        inputValidator: (value) => {
            if (!value) {
            return 'Введите название курса!'
            }
        }
        })

        if(!name) {
            return
        }

        const { value: skillLevel} = await Queue.fire({
        currentProgressStep: 0,

        input: 'select',
        title: 'Создание курса',
        inputOptions: skillLevels,
        inputPlaceholder: 'Выберите уровень сложности',

        inputValidator: (value) => {
            if (!value) {
            return 'Выберите уровень сложности!'
            }
        }
        })

        if(!skillLevel) {
            return
        }

        const data = {
            type: 'add',
            id: $('.user')[0].id,
            name: name,
            skill_level: skillLevel,
        }

        sendRequest('POST', '../rest-api.php/courses', data);

        Swal.fire({
            title: 'Успех',
            text: 'Новый курс добавлен в систему',
            icon: 'success',
            confirmButtonColor: '#0094a9',
        }).then((result) => {
            insertHTML('myCourses.php', [], ".main_inner")
        })
    })          
</script>