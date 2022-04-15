<?php
    $user = $_POST['id'];

    if ($user) {
        print <<<HERE
            <div class="user" id='$user'>
                <ion-icon name="person-outline"></ion-icon>
            </div>
    HERE;
    }
?>

<div class="search">
    <label>
        <input type="text" placeholder="Поиск курсов">
        <ion-icon name="search-outline"></ion-icon>
    </label>
</div>

<?php
    if ($user) {
        print <<<HERE
            <div id="logOut" class="toggle">
                <ion-icon name="log-out-outline"></ion-icon>
            </div>
    HERE;
    } else {
        print <<<HERE
            <div id="logIn" class="toggle">
                <ion-icon name="log-in-outline"></ion-icon>
            </div>
    HERE;
    }
?>

<script>
    $('#logIn').click( async function() {
        const { value: formValues } = await Swal.fire({
        title: 'Авторизация',
        html:
            '<input id="swal-input1" class="swal2-input" placeholder="Логин">' +
            '<input type="password" id="swal-input2" class="swal2-input" placeholder="Пароль">',
        focusConfirm: false,
        confirmButton: true,
        confirmButtonColor: '#0094a9',
        confirmButtonText: 'Войти',

        showDenyButton: true,
        denyButtonColor: '#0094a9',
        denyButtonText: 'Регистрация',
        // preConfirm: () => {
        //     return {
        //     login: document.getElementById('swal-input1').value,
        //     password: document.getElementById('swal-input2').value
        //     }
        // }
        }).then(async (result) => {
            if (result.isConfirmed) {
                let user = {};

                if (document.getElementById('swal-input1').value && document.getElementById('swal-input2').value) {
                    await $.get("../rest-api.php/users/" + document.getElementById('swal-input1').value + '/' + document.getElementById('swal-input2').value, function(data) {
                    data.forEach((item) => {
                        user['id'] = item['id'];
                    })
                })
                }

                if (user['id']) {
                    Swal.fire({
                        title: 'Вы авторизованны',
                        text: 'Добро пожаловать в систему',
                        icon: 'success',
                        confirmButtonColor: '#0094a9',
                    }).then((result) => {
                        insertHTML("main.php", [], ".main_inner")
                        insertHTML("top_bar.php", user, ".topbar")
                    })
                } else {
                    Swal.fire({
                        title: 'Ошибка',
                        text: 'Вы ввели неправильные данные',
                        icon: 'warning',
                        confirmButtonColor: '#0094a9',
                    })
                }
            } else if (result.isDenied) {
                const { value: form } = await Swal.fire({
                title: 'Регистрация',
                html:
                '   <input id="swal-input3" class="swal2-input" placeholder="Имя">' +
                    '<input id="swal-input1" class="swal2-input" placeholder="Логин">' +
                    '<input type="password" id="swal-input2" class="swal2-input" placeholder="Пароль">',
                focusConfirm: false,
                confirmButton: true,
                confirmButtonColor: '#0094a9',
                confirmButtonText: 'Зарегистрироваться',

                showDenyButton: true,
                denyButtonColor: '#0094a9',
                denyButtonText: 'Выйти',
                preConfirm: () => {
                    const data = {
                        name: document.getElementById('swal-input3').value,
                        login: document.getElementById('swal-input1').value,
                        password: document.getElementById('swal-input2').value   
                    }

                    sendRequest('POST', '../rest-api.php/users', data);
                }
                })
            }
        })
    })
    $('#logOut').click( async function() {
        const { value: formValues } = await Swal.fire({
        title: 'Выйти из системы?',
        icon: 'question',
        confirmButtonColor: '#0094a9',
        focusConfirm: false,
        confirmButton: true,
        confirmButtonColor: '#0094a9',
        confirmButtonText: 'Выйти',

        showCancelButton: true,
        cancelButtonColor: '#0094a9',
        cancelButtonText: 'Назад',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Вы вышли из системы',
                    icon: 'success',
                    confirmButtonColor: '#0094a9',
                }).then((result) => {
                    insertHTML("main.php", [], ".main_inner")
                    insertHTML("top_bar.php", [], ".topbar")
                })
            }
        })
    })

    $('.user').click( async function() {
        let id = this.id;

        let user = {};

        await $.get("../rest-api.php/users/" + id, function(data) {
            data.forEach((item) => {
                user['id'] = item['id'];
                user['name'] = item['name'];
                user['type'] = item['role']
            })
        })

        let role;

        if(user['type'] == '1') {
            role = 'Студент'
        } else if (user['type'] == '2') {
            role = 'Преподаватель'
        }

        await Swal.fire({
            title: user['name'],
            text: role,
            confirmButtonColor: '#0094a9',
        })
    })
</script>