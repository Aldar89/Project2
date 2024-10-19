<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Reistration Form</title>
</head>
<body>
<form action="/registrateOrder" method="POST">
    <div class="container">
        <h1>ОФОРМЛЕНИЕ ЗАКАЗА</h1>
        <p>Заполните данные</p>

        <label for="first_name"><b>Имя</b></label>
        <label style="color: red"> <?php if (isset($errors['first_name'])) {echo $errors['first_name'];} ?></label>
        <input type="text" name="first_name" placeholder= "Введите Имя" required>

        <label for="last_name"><b>Фамилия</b></label>
        <label style="color: red"> <?php if (isset($errors['last_name'])) {echo $errors['last_name'];}?></label>
        <input type="text" placeholder="Введите фамилию" name="last_name" required>

        <label for="address"><b>Адрес</b></label>
        <label style="color: red"> <?php if (isset($errors['address'])) {echo $errors['address']; }?></label>
        <input type="text" placeholder="Введите адресс" name="address" required>

        <label for="phone"><b>Телефон</b></label>
        <label style="color: red"> <?php if (isset($errors['phone'])) {echo $errors['phone'];}?></label>
        <input type="text" placeholder="Введите телефон" name="phone" required>

        <div class="clearfix">

        </div>
        <button type="submit" class="registerbtn">RegisterOder</button>
    </div>
        </div>
    </div>
</form>

    <a href="/logout">ВЫЙТИ</a>
    <a href="/catalog2">КАТАЛОГ</a>

    <div class="card-deck">
        <?php foreach ($userProduct as $product):?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        <?php echo $product['product_name'];?>
                    </div>
                    <img class="card-img-top" src="<?php echo $product['image']?>" alt="Card image" width="140" height="140">
                    <div class="card-body">
                        <p  class="card-text text-muted"><?php echo $product['amount']?>  шт.</p>
                        <div class="card-footer">
                            <?php echo 'Цена ',$product['price'], ' РУБЛЕЙ';?>
                            <?php echo 'Сумма ',$product['price']* $product['amount'], ' РУБЛЕЙ';?>
                            <a href="#"><h5 class="card-title"></h5></a>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach;?>
        <?php echo 'ИТОГО ',$totalPrice, ' РУБЛЕЙ';?>
    </div>

</body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500&display=swap');

    body {
        font-family: Montserrat,Arial, Helvetica, sans-serif;
        background-color:#f7f7f7;
    }
    * {box-sizing: border-box}

    /* Add padding to container elements */
    .container {
        padding: 20px;
        width:500px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border:1px solid #ccc;
        border-radius:10px;
        background:white;
        -webkit-box-shadow: 2px 1px 21px -9px rgba(0,0,0,0.38);
        -moz-box-shadow: 2px 1px 21px -9px rgba(0,0,0,0.38);
        box-shadow: 2px 1px 21px -9px rgba(0,0,0,0.38);
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f7f7f7;
        font-family: Montserrat,Arial, Helvetica, sans-serif;
    }
    select {
        width: 18%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f7f7f7;
        font-family: Montserrat,Arial, Helvetica, sans-serif;
    }

    input[type=phone] {
        width: 81%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f7f7f7;
    }

    input[type=text]:focus, input[type=password]:focus, input[type=phone]:focus, select:focus {
        background-color: #ddd;
        outline: none;
    }



    /* Set a style for all buttons */
    button {
        background-color: #0eb7f4;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
        font-size:16px;
        font-family: Montserrat,Arial, Helvetica, sans-serif;
        border-radius:10px;
    }

    button:hover {
        opacity:1;
    }


    /* Change styles for signup button on extra small screens */
    @media screen and (max-width: 300px) {
        .signupbtn {
            width: 100%;
        }
    }

    .youtubeBtn{
        position: fixed;
        right: 20px;
        transform:translatex(-50%);
        top: 20px;
        cursor: pointer;
        transition: all .3s;
        vertical-align: middle;
        text-align: center;
        display: inline-block;
        background:#000;
        padding:2px 10px;
        border-radius:5px;
    }
    .youtubeBtn i{
        font-size:20px;
        float:left;
    }
    .youtubeBtn a{
        color:#ff0000;
        animation: youtubeAnim 1000ms linear infinite;
        float:right;
    }
    .youtubeBtn a:hover{
        color:#c9110f;
        transition:all .3s ease-in-out;
    }
    .youtubeBtn i:active{
        transform:scale(.9);
        transition:all .3s ease-in-out;
    }
    .youtubeBtn span{
        font-family: 'Lato';
        font-weight: bold;
        color: #fff;
        display: block;
        font-size: 12px;
        float: right;
        line-height: 20px;
        padding-left: 5px;

    }

    @keyframes youtubeAnim{
        0%,100%{
            color:#c9110f;
        }
        50%{
            color:#ff0000;
        }
    }
</style>
