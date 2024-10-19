

<div class="container">
    <h3>КОРЗИНА</h3>
    <a href="/logout">ВЫЙТИ</a>
    <a href="/catalog">КАТАЛОГ</a>
    <a href="/registrateOrder">ОФОРМИТЬ ЗАКАЗ</a>
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
</div>

<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 20px;
        color: darkred;
        background-color: white;
    }

    .text-muted {
        font-size: 20px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>
