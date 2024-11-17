<!doctype html>
<html>
<head>
    <title>Оптовая база</title>
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
    <style>

    </style>
</head>
<div>
    <!-- Preloader-->
    <!--<div class="spinner-wrapper" id="loading">-->
    <!--    <div class="spinner"></div>-->
    <!--    <div class="spinner">-->
    <!--        <div class="rect1"></div>-->
    <!--        <div class="rect2"></div>-->
    <!--        <div class="rect3"></div>-->
    <!--        <div class="rect4"></div>-->
    <!--        <div class="rect5"></div>-->
    <!--    </div>-->
    <!--</div>-->
    <br>
    <br>
    <br>
    <br>

</div class="grid-container">
<?php /** @var \Model\Product $product  */ ?>
<?php /** @var \Model\Review $review  */ ?>
<h3 class="card text-center">ОПТОВАЯ БАЗА</h3>
<a style="float: right" " href="/logout">ВЫЙТИ</a>
<a href="/catalog">КАТАЛОГ</a>
<a href="/cart">КОРЗИНА <?php  ?></a>
<a href="/favorite">ИЗБРАННОЕ</a>
<div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4 grid-x-wrapper">

        <div class="product-box column">
            <a href="#" class="product-item">
                <div class="product-item-image">
                    <img src="<?php echo $product->getImage() ?>" alt="Stadium Full Exterior" width="250" height="150">
                    <div class="product-item-image-hover">
                    </div>
                </div>
                <div class="product-item-content">
                    <div class="product-item-category">
                        <?php echo $product->getDescription(); ?>
                    </div>
                    <div class="product-item-title">
                        <?php echo $product->getName();?>
                    </div>
                    <div class="product-item-price">
                        <?php echo $product->getPrice(), ' РУБЛЕЙ' ; ?>

                    </div>
                    <div class="product-grade">
                        <?php  if ($avarage) {echo 'оценка '. $avarage;} else {echo 'нет оценок';}?>
                    </div>


                </div>
            </a>
        </div>
        <form action="/add-product" method="POST">
            <div class="container">

                <label for="product-id"><b></b></label>
                <label style="color: red"> <?php if (isset($errors['product_id '])) {echo $errors['product_id'];} ?></label>
                <input type="hidden" name="product_id" placeholder= "Введите product_id" required value="<?=  $product->getId() ?>">

                <label for="amount"><b></b></label>
                <label style="color: red"> <?php if (isset($errors['amount'])) {echo $errors['amount'];}?></label>
                <input type="text" placeholder="Введите amount" name="amount" required>
                <button type = "submit" class="button-pill">
                    <span>В корзину</span>
                </button>
            </div>
        </form>

        <form action="/add-favorite" method="POST">
            <label for="product-id"><b></b></label>
            <label style="color: red"> <?php if (isset($errors['product_id '])) {echo $errors['product_id'];} ?></label>
            <input type="hidden" name="product_id" placeholder= "Введите product_id" required value="<?=  $product->getId() ?>">
            <button type="submit" class="button-pill" >
                <span>В ИЗБРАННОЕ</span>
            </button>
        </form>


</div>

<div class="grid-container">
    <div class="grid-x grid-margin-x small-up-1 medium-up-1 large-up-1 grid-x-wrapper">
        <div class="product-box column" style="text-align: center;  margin: 50px 0 50px;">
            <a href="/catalog" target="_blank" style="color: #0719a3; font-weight: 700; text-transform: uppercase;">C A T A L O G</a>
        </div>
    </div>
</div>

<div class="comment-container theme--light">
    <div class="comments" >
        <?php  if ($productFromOrder !== null):?>
        <form action="/add-comment-product" method="POST" >
        <div class="card v-card v-sheet theme--light elevation-2" ><span class="headline" >
            <div class="sign-in-wrapper" >
                <label for="comment"><b></b></label>
                <label style="color: red"> <?php  ?></label>
                <input type="hidden" name="product_id" placeholder= "Введите product_id" required value="<?=  $product->getId() ?>">
                <input type="text" placeholder="Оставьте отзыв" name="comment" required>
                <input type="text" placeholder="Поставить оценку от 1 до 5" name="grade" required>
                <button type = "submit" class="button-pill">
                    <span>Оставить отзыв и оценку</span>
                </button>
            </div>
            <!---->
        </div>
        <form>
         <?php endif; ?>

        <div  >
            <div  class="card v-card v-sheet theme--light elevation-2">Отзывы</span>
                <?php  foreach ($reviews as $review):?>
                <div  class="header">
                    <div  class="v-avatar avatar" style="height: 50px; width: 50px;"><img  src="https://images.unsplash.com/photo-1490894641324-cfac2f5cd077?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=100&q=70"></div>
                    <span  class="displayName title"><?php  $userId = $review->getUserId(); echo \Model\User::getById($userId)->getName();  ?></span> <span  class="displayName caption"></span></div>
                   <!---->
                <div  class="wrapper comment">
                    <p><?php if($review->getComment()) {echo $review->getComment();} else { echo 'нет отзывов';} ?>></p>
                    <p><?php  echo 'Оценка '. $review->getGrade() ?></p>
                 </div>
                <div  class="actions">
                    <!---->
                    <!---->
                    <!---->
                </div>
                <div  class="v-dialog__container" style="display: block;"></div>
                <?php endforeach;?>
            </div>

            <!---->
            <div  class="answers">
                <!---->
            </div>
        </div>


    </div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
</body>
</html>

<style>
    /*
 * modernaweb.net
 * * * * * * * * * */

    @import url('https://fonts.googleapis.com/css?family=Rubik:400,700');
    body { background: #f4f6f9; }
    a:focus,
    a:hover {color: #000;}



    /* Preloader
    ************************** */
    .spinner-wrapper { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.95); z-index: 999999; background: #c5d0e2; }
    .spinner { position: absolute; margin: 100px auto; width: 50px; height: 40px; text-align: center; font-size: 10px; top: 40%; left: 50%; transform: translate(-50%, -60%); -moz-transform: translate(-50%, -60%); -webkit-transform: translate(-50%, -60%); -webkit-transition: all .37s ease; -moz-transition: all .37s ease;  -ms-transition: all .37s ease; -o-transition: all .37s ease; transition: all .37s ease;}
    .spinner > div { background-color: #000; height: 100%; width: 6px; display: inline-block; -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out; animation: sk-stretchdelay 1.2s infinite ease-in-out; }
    .spinner .rect2 { -webkit-animation-delay: -1.1s; animation-delay: -1.1s; }
    .spinner .rect3 { -webkit-animation-delay: -1.0s; animation-delay: -1.0s; }
    .spinner .rect4 { -webkit-animation-delay: -0.9s; animation-delay: -0.9s; }
    .spinner .rect5 { -webkit-animation-delay: -0.8s; animation-delay: -0.8s; }
    @-webkit-keyframes sk-stretchdelay {
        0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
        20% { -webkit-transform: scaleY(1.0) }
    }
    @keyframes sk-stretchdelay {
        0%, 40%, 100% {
            transform: scaleY(0.4);
            -webkit-transform: scaleY(0.4);
        }  20% {
               transform: scaleY(1.0);
               -webkit-transform: scaleY(1.0);
           }
    }
    .none {transition: all 1.7s ease;opacity: 0; display: none; z-index: -9999;}

    /* Products
    ************************** */
    .grid-x-wrapper {max-width: 85%; margin: 0 auto;}
    .product-item .product-item-content { display: block; position: relative; transition: all .3s cubic-bezier(.785,.135,.15,.86); }
    .product-item {display: block;text-align: center;color: #000;padding: 2rem;overflow: hidden;margin-bottom: 1rem;font-family: 'Rubik', sans-serif;margin: 20px 0;background: #fff;box-shadow: 0 10px 40px -3px rgba(0,0,0,0.1);border-radius: 7px;transform:scale(0.97,0.97);transition: all .17s cubic-bezier(0.24, 0.71, 0.58, 0.57);}
    .product-item:hover {box-shadow: 0 0px 50px -10px rgba(0,0,0,0.3); transform:scale(1,1);}
    .product-item:hover .product-item-image { transition-delay: .2s; -ms-transform: scale(.8) translateY(-15%); transform: scale(.8) translateY(-15%);}
    .product-item .product-item-image { display: block; position: relative; margin-bottom: 2rem; transform: translate3d(0,0,0); transition: all .5s cubic-bezier(.68,-.55,.265,1.55); }
    .product-item .product-item-image img { border-radius: 100%; position: relative; z-index: 3; }
    .product-item:hover .product-item-image-hover { transition-delay: .1s; -ms-transform: translate(-50%,-42%) scale(.85); transform: translate(-50%,-42%) scale(.85); }
    .product-item .product-item-image-hover { position: relative; z-index: 2; width: 100%; height: 100%; background: #97e7a2; background: -moz-linear-gradient(135deg,  #97e7a2 0%,#d8ff7e    100%); background: -webkit-linear-gradient(135deg,  #97e7a2 0%,#d8ff7e    100%); background: linear-gradient(135deg,  #97e7a2 0%,#d8ff7e    100%); border-radius: 100%; -ms-transform: translate(-50%,-120%) scale(0); transform: translate(-50%,-120%) scale(0); position: absolute; top: 50%; left: 50%; transition: all .6s cubic-bezier(.68,-.55,.265,1.55); opacity: 0; visibility: hidden;}
    .product-item:hover .product-item-image-hover { opacity: 1; visibility: visible;}
    .product-item:hover .product-item-category { transition-delay: .3s; }
    .product-item:hover .product-item-category,
    .product-item:hover .product-item-price,
    .product-item:hover .product-item-title { -ms-transform: translateY(-50px); transform: translateY(-50px); }
    .product-item .product-item-category,
    .product-item .product-item-price,
    .product-item .product-item-title { transition: all .3s cubic-bezier(.785,.135,.15,.86); }
    .product-item .product-item-category { font-size: .875rem; }
    .product-item:hover .product-item-title { transition-delay: .4s; }
    .product-item:hover .product-item-category,
    .product-item:hover .product-item-price,
    .product-item:hover .product-item-title { -ms-transform: translateY(-50px); transform: translateY(-50px); }
    .product-item .product-item-category,
    .product-item .product-item-price,
    .product-item .product-item-title { transition: all .3s cubic-bezier(.785,.135,.15,.86); }
    .product-item .product-item-title { font-size: 1.125rem; font-weight: 600; }
    .product-item:hover .product-item-price { transition-delay: .5s; }
    .product-item:hover .product-item-category,
    .product-item:hover .product-item-price,
    .product-item:hover .product-item-title { -ms-transform: translateY(-50px); transform: translateY(-50px); }
    .product-item .product-item-category,
    .product-item .product-item-price,
    .product-item .product-item-title { transition: all .3s cubic-bezier(.785,.135,.15,.86); }
    .product-item .product-item-price { font-size: 1.0625rem; }
    .product-item:hover .button-pill { transition-delay: .6s;}
    .product-item:hover .button-pill {opacity: 1;-ms-transform: translateY(5px) translateX(-50%);transform: translateY(5px) translateX(-50%);}
    .product-item .button-pill { position: absolute; bottom: 0; left: 50%; -ms-transform: translateY(30px) translateX(-50%); transform: translateY(30px) translateX(-50%); opacity: 0; transition: all .3s cubic-bezier(.785,.135,.15,.86); }
    .button-pill span {display: inline-block;position: relative;font-size: .75rem;font-weight: 600;letter-spacing: .09em;text-transform: uppercase;  background: #97e7a2; background: -moz-linear-gradient(135deg,  #97e7a2 0%,#d8ff7e    100%); background: -webkit-linear-gradient(135deg,  #97e7a2 0%,#d8ff7e    100%); background: linear-gradient(135deg,  #97e7a2 0%,#d8ff7e    100%); color: #000;border-radius: 1.5rem;padding-top: .6rem;padding-bottom: .6rem;padding-left: 2.1rem;padding-right: 2.1rem;box-shadow: 0 14px 25px 0px rgba(75,204,140,0.1); transition: all .37s ease;}
    .button-pill:hover span {display: inline-block;position: relative;font-size: .75rem;font-weight: 600;letter-spacing: .09em;text-transform: uppercase;  background: #5f5f5f; background: -moz-linear-gradient(135deg,  #5f5f5f 0%,#000    100%); background: -webkit-linear-gradient(135deg,  #5f5f5f 0%,#000    100%); background: linear-gradient(135deg,  #5f5f5f 0%,#000    100%); color: #fff;border-radius: 1.5rem;padding-top: .6rem;padding-bottom: .6rem;padding-left: 2.1rem;padding-right: 2.1rem; box-shadow: 0 14px 25px 0px rgba(0,0,0,0.1);}
    @media(min-width:1200px) and (max-width:1366px) {
        .button-pill {width: 100%;}
        .product-box {padding: 0 10px;}
    }
    @media(min-width:1024px) and (max-width:1200px) {
        .product-item .product-item-title {font-size: 0.888rem;}
        .product-item .product-item-price {font-size: 0.788rem; padding: 7px 0 0;}
        .product-box {padding: 0 7px;}
    }


    @import url('https://fonts.googleapis.com/css?family=Noto+Serif:400,700');

    body {
        background-color: #fafafa;
        font-family: 'Noto Serif', serif;
    }

    .comment-container {
        width: 60%;
        margin: 2rem auto;
    }

    a {
        color: #c40030;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }

    .v-btn {
        align-items: center;
        border-radius: 2px;
        display: inline-flex;
        height: 36px;
        flex: 0 0 auto;
        font-size: 14px;
        font-weight: 700;
        justify-content: center;
        margin: 6px 8px;
        min-width: 88px;
        outline: 0;
        text-transform: uppercase;
        text-decoration: none;
        transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1), color 1ms;
        position: relative;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        padding: 0 16px;
    }

    .v-btn:before {
        border-radius: inherit;
        color: inherit;
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        opacity: 0.12;
        transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
        width: 100%;
    }

    .v-btn:focus,
    .v-btn:hover {
        position: relative;
    }

    .v-btn:focus:before,
    .v-btn:hover:before {
        background-color: currentColor;
    }

    .v-btn__content {
        align-items: center;
        border-radius: inherit;
        color: inherit;
        display: flex;
        flex: 1 0 auto;
        justify-content: center;
        margin: 0 auto;
        position: relative;
        transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
        white-space: nowrap;
        width: inherit;
    }

    .v-btn:not(.v-btn--depressed):not(.v-btn--flat) {
        will-change: box-shadow;
        box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14),
        0 1px 5px 0 rgba(0, 0, 0, 0.12);
    }

    .v-btn:not(.v-btn--depressed):not(.v-btn--flat):active {
        box-shadow: 0 5px 5px -3px rgba(0, 0, 0, 0.2),
        0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12);
    }

    .avatar {
        width: 50px;
        height: 50px;
        margin-left: -42px;
        border-radius: 50%;
    }

    .v-avatar {
        align-items: center;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        position: relative;
        text-align: center;
        vertical-align: middle;
    }

    .v-avatar img {
        border-radius: 50%;
        display: inline-flex;
        height: inherit;
        width: inherit;
        object-fit: cover;
    }

    .v-card {
        text-decoration: none;
    }

    .v-card > :first-child:not(.v-btn):not(.v-chip) {
        border-top-left-radius: inherit;
        border-top-right-radius: inherit;
    }

    .v-card > :last-child:not(.v-btn):not(.v-chip) {
        border-bottom-left-radius: inherit;
        border-bottom-right-radius: inherit;
    }

    .v-sheet {
        display: block;
        border-radius: 2px;
        position: relative;
    }

    .v-dialog__container {
        display: inline-block;
        vertical-align: middle;
    }

    .elevation-2 {
        box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14),
        0 1px 5px 0 rgba(0, 0, 0, 0.12) !important;
    }

    *,
    :after,
    :before {
        box-sizing: inherit;
    }

    :after,
    :before {
        text-decoration: inherit;
        vertical-align: inherit;
    }

    * {
        background-repeat: no-repeat;
        padding: 0;
        margin: 0;
    }

    a:active,
    a:hover {
        outline-width: 0;
    }

    button {
        font: inherit;
        overflow: visible;
        text-transform: none;
        background-color: transparent;
        border-style: none;
        color: inherit;
    }

    [type="button"]::-moz-focus-inner,
    button::-moz-focus-inner {
        border-style: 0;
        padding: 0;
    }

    [type="button"]::-moz-focus-inner,
    button:-moz-focusring {
        outline: 0;
        border: 0;
    }

    button,
    html [type="button"] {
        -webkit-appearance: button;
    }

    img {
        border-style: none;
    }

    ::-ms-clear,
    ::-ms-reveal {
        display: none;
    }

    .headline {
        font-weight: 400;
        letter-spacing: normal !important;
        font-size: 24px !important;
        line-height: 32px !important;
    }

    .title {
        font-size: 20px !important;
        font-weight: 700;
        line-height: 1 !important;
        letter-spacing: 0.02em !important;
    }

    .caption {
        font-weight: 400;
        font-size: 12px !important;
    }

    .theme--light.v-btn {
        color: rgba(0, 0, 0, 0.87);
    }

    .theme--light.v-btn:not(.v-btn--icon):not(.v-btn--flat) {
        background-color: #f5f5f5;
    }

    .theme--light .v-card {
        box-shadow: rgba(0, 0, 0, 0.11) 0 15px 30px 0px,
        rgba(0, 0, 0, 0.08) 0 5px 15px 0 !important;
    }

    .theme--light.application .v-card {
        box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.11),
        0 5px 15px 0 rgba(0, 0, 0, 0.08) !important;
        color: #102c3c !important;
    }

    .theme--light.v-card,
    .theme--light.v-sheet {
        background-color: #fff;
        border-color: #fff;
        color: rgba(0, 0, 0, 0.87);
    }

    a,
    a:hover {
        text-decoration: none !important;
    }

    .wrapper {
        overflow: auto;
    }

    .answers {
        padding-left: 64px;
    }

    .comment {
        overflow-y: auto;
        margin-left: 32px;
        margin-right: 16px;
    }

    .comment p {
        font-size: 14px;
        margin-bottom: 7px;
    }

    .displayName {
        margin-left: 24px;
    }

    .actions {
        display: flex;
        flex: 1;
        flex-direction: row;
        justify-content: flex-end;
    }

    .google-span[data-v-35838f51] {
        font-size: 14px;
        color: rgba(0, 0, 0, 0.54);
    }

    .google-button[data-v-35838f51] {
        background-color: #fff;
        height: 40px;
        margin: 0;
    }

    .headline {
        margin-left: 32px;
    }

    .sign-in-wrapper {
        margin-top: 16px;
        margin-left: 32px;
    }


    .error-message {
        font-style: oblique;
        color: #c40030;
    }

    ::-moz-selection,
    ::selection {
        background-color: #b3d4fc;
        color: #000;
        text-shadow: none;
    }

    .card,
    .card {
        padding: 32px 16px;
        margin-bottom: 32px;
        display: flex;
        flex-direction: column;
    }

    .application a,
    [type="button"],
    button {
        cursor: pointer;
    }

    @media screen and (max-width: 640px) {
        .comment-container {
            width: 90%;
        }
        .comments {
            padding: 32px;
        }
    }

</style>