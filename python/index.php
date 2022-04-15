<!DOCTYPE html>

<?php 
    require '../connect.php';
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width", initial-scale-1.0>
        <title>Python book </title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="container">
            <div class="main">
                <div class="topbar">
                </div>
                <div class="cardBox">
                    <div class="card active" id="main">
                        <div>
                            <div class="numbers">Доступные курсы</div>
                            <div class="cardName">Доступные для прохождения курсы</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="copy-outline"></ion-icon>
                        </div>
                    </div>    
                    <div class="card" id="myCourses">
                        <div>
                            <div class="numbers">Мои курсы</div>
                            <div class="cardName">Начатые вами курсы</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="create-outline"></ion-icon>
                        </div>
                    </div>      
                </div>
                <div class="main_inner">
                </div>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        <script>
            function sendRequest(method, url, body = null) {
                const headers = {
                    'Content-Type': 'application/json'
                }
                
                return fetch(url, {
                    method: method,
                    headers: headers,
                    body: JSON.stringify(body)
                })
            }

            function insertHTML(url, data, div_class) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    response: 'text',
                    success: function(data) {
                        $(div_class).html(data);
                        $(div_class).hide().fadeIn(700);
                    }
                })
            }

            function loadCitiesPage(name){
                insertHTML(name + '.php', [], ".main_inner")
            }

            insertHTML('main.php', [], ".main_inner")
            insertHTML("top_bar.php", [], ".topbar")

            function activeCard(){
                cards.forEach((item) =>
                item.classList.remove('active'));
                this.classList.add('active');
                loadCitiesPage(this.id);
            }
            
            let cards = document.querySelectorAll('.card')
            
            cards.forEach((item) => 
            item.addEventListener('click', activeCard))
        </script>
    </body>
</html>
