<?php

require_once './stripe-php/init.php';

\Stripe\Stripe::setApiKey('sk_test_51HKhlOAPiiqA1PlBS47OGpUnkLUu57aELYdeFezjxWCV3BLWmoLhltuLvFkdwrpogmNhSc4Mmoz6EoPuAshPS4Va00wZCdGrP0');

$chargeId = null;

$coupon = \Stripe\PromotionCode::create([
    'coupon' => 'atNcoXbo',
    'code' => 'OFAYPQX4',
]);

try {
    $token = $_POST['stripeToken'];
    $charge = \Stripe\Charge::create(array(
        'amount' => 2728,
        'currency' => 'jpy',
        'description' => 'test',
        'source' => $token,
        'capture' => false,
        'coupon' => 'atNcoXbo',
        'code' => 'OFAYPQX4',
    ));
    $chargeId = $charge['id'];

    // (2) 注文データベースの更新などStripeとは関係ない処理
    // :
    // :
    // :

    // (3) 売上の確定
    header("Location: /complete.html");
    exit;
} catch (Exception $e) {
    if ($chargeId !== null) {
//        例外が発生すればオーソリを消す
        \Stripe\Refund::create(array(
            'charge' => $chargeId
        ));

    }

//    エラー画面にリダイレクト
    header("Location: /error.html");
}