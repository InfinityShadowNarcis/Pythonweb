<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Список курсов</h2>
        </div>
        <?php
            require '../connect.php';

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
            JOIN skill_levels s ON c.skill_lvl = s.id");

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
        ?>
    </div>
</div>

<script>
    $('.course').click(async function(){

    const data = {
        id: $(this).find('.name')[0].id,
        type: 'main'
    }

    await insertHTML('lectures.php', data, ".main_inner")
    })
</script>