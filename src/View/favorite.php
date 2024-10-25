

<div class="container">
    <?php /** @var \Model\FavoriteProduct $favoriteProduct  */ ?>
    <h3>ИЗБРАННОЕ</h3>
    <a href="/logout">ВЫЙТИ</a>
    <a href="/catalog">КАТАЛОГ</a>
    <div class="card-deck">
        <?php foreach ($favoriteProducts as $favoriteProduct):?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        <?php echo $favoriteProduct->getProduct()->getName();?>
                    </div>
                    <img class="card-img-top" src="<?php echo $favoriteProduct->getProduct()->getImage()?>" alt="Card image" width="140" height="140">
                    <div class="card-body">
                        <div class="card-footer">
                            <?php echo 'Цена ',$favoriteProduct->getProduct()->getPrice(), ' РУБЛЕЙ';?>
                            <a href="#"><h5 class="card-title"></h5></a>
                            <input type="text" hidden placeholder="Enter product-id" name="product_id" id="product-id" value=" <?php  echo $favoriteProduct->getProduct()->getId() ?>"required>
                        </div>
                    </div>
                </a>
                <form action="/remove-favorite" method="POST">
                    <input type="text" hidden placeholder="Enter product-id" name="product_id" id="product-id" value=" <?php  echo $favoriteProduct->getProduct()->getId() ?>"required>
                    <button type="submit">Удалить</button>
                </form>
            </div>

        <?php endforeach;?>
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
