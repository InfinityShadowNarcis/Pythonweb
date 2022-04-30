<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Список студентов на курсе</h2>
        </div>
        <?php
            require '../connect.php';

            print <<<HERE
                <table>
                    <thead>
                        <tr>
                            <td>Студент</td>
                            <td>Лекций пройдено</td>
                            <td>Средний балл</td>
                        </tr>
                    </thead>
                <tbody>
            HERE;

            $id = $_POST['id'];

            $users = mysqli_query($connect, "SELECT u.name, u.id FROM user_courses uc JOIN users u ON uc.id_user = u.id WHERE id_course = '$id'");

            $name;
            $id_user;

            while($user = mysqli_fetch_assoc($users)) {
                $name = $user['name'];
                $id_user = $user['id'];

                $statistics = mysqli_query($connect, "SELECT AVG(rating) AS avg_rating, COUNT(id) AS amount FROM user_lectures WHERE id_user = '$id_user' AND status = '3'");

                $stats = mysqli_fetch_array($statistics);

                $avg_rating = (int)$stats['avg_rating'];
                $amount = $stats['amount'];

                print <<<HERE
                    <tr class="course">
                        <td class="name" id="$id_user">$name</td>
                        <td class="name_host">$amount</td>
                        <td> <span class="status open">$avg_rating</span></td>
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