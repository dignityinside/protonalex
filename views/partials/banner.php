<?php

$ads = [
    [
        'img' => 'https://i.imgur.com/ssBJVRD.jpg',
        'alt' => 'Хозяин времени',
        'title' => 'Хозяин времени',
        'text' => 'Как грамотно распоряжаться своим временем, чтобы достигать высоких результатов во всех сферах жизни.',
        'url' => 'https://p.cscore.ru/dignity/sdisc124',
        'cta' => 'Получить видеокурс',
    ],
    [
        'img' => 'https://photoshop-master.org/disc_img_mini/dop_disc162.jpg',
        'alt' => 'Как обрабатывать фото из путешествий?',
        'title' => 'Что делать если вы привезли из отпуска 1000 фотографий?',
        'text' => 'Удалить неудачные снимки и обработать все снимки, которые вы решили оставить! Но как это сделать?',
        'url' => 'https://w.cscore.ru/dignity/disc235',
        'cta' => 'Получить видеокурс',
    ],
    [
        'img' => 'https://photoshop-master.org/disc_img_mini/dop_disc162.jpg',
        'alt' => 'Секреты фотосъёмки в обычной квартире',
        'title' => 'Секреты фотосъёмки в обычной квартире',
        'text' => 'Узнай все секреты по фотосъемке в условиях обычной квартиры.',
        'url' => 'https://w.cscore.ru/dignity/disc178',
        'cta' => 'Хочу узнать все секреты!',
    ],
    [
        'img' => 'https://photoshop-master.org/disc_img_mini/dop_disc14.jpg',
        'alt' => 'Моя первая ЗЕРКАЛКА',
        'title' => 'Моя первая ЗЕРКАЛКА',
        'text' => 'Хотите выжать максимум из вашей первой зеркальной фотокамеры?',
        'url' => 'https://w.cscore.ru/dignity/disc33',
        'cta' => 'Получить видео курс',
    ],
];

$id = array_rand($ads, 1);
$data = $ads[$id];

use yii\helpers\Html; ?>

<hr>

<style>
    .post-view .btn-danger {
        color: #fff;
    }
    .banner_container {
        background-color: #fff;

        text-align: center;
    }
    .banner_container_td {
        padding: 10px;
    }
    .banner_container_img {
        width: 40%;
    }
    .banner_container_content {
        font-size: 120%; font-weight: bold;
    }
    .banner_container_content_title {
        color: #c00;
    }
    .banner_container_content_text {
        color: #000; margin: 10px 0;
    }
</style>

<table class="banner_container">
    <tr>
        <td class="banner_container_td">
            <div>
                <img src="<?= $data['img'] ?>" alt="<?= $data['alt'] ?>" class="banner_container_img">
            </div>
        </td>
        <td>
            <div class="banner_container_content">
                <p class="banner_container_content_title"><?= $data['title'] ?></p>
                <p class="banner_container_content_text"><?= $data['text'] ?></p>
                <p><?= Html::a($data['cta'], $data['url'], ['class' => 'btn btn-danger', 'rel' => 'nofollow', 'target' => '_blank']); ?></p>
            </div>
        </td>
    </tr>
</table>
