<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Мои курсы</h2>
            <div class="iconBoxDirection" id="add_course">
                <ion-icon name="add-circle-outline"></ion-icon>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Название</td>
                    <td>Создатель</td>
                    <td>Уровень сложности</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 0;
                    while($i < 1) {
                        $i++;
                        print <<<HERE
                        <tr>
                        <td>Питон за 0 лекций</td>
                        <td>Александр Васильевич</td>
                        <td><span class="status good">Легкий</span></td>
                    </tr>
                    <tr>
                        <td>Питон средний уровень</td>
                        <td>Александр Васильевич</td>
                        <td><span class="status medium">Средний</span></td>
                    </tr>
                    <tr>
                        <td>Профессиональный питон</td>
                        <td>Александр Васильевич</td>
                        <td><span class="status bad">Высокий</span></td>
                    </tr>
HERE;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>