<?php

// phpcs:ignoreFile

/**
 * \Yii::t('app/deals', 'menu_label_index_deals')
 */
return [
    // views/layouts/main
    'menu_label_deals_index'        => 'Скидки',
    'menu_label_deals_admin'        => 'Все скидки',
    // views/deals/_form
    'deals_form_select_category'    => 'Выберите категорию',
    'deals_form_hint_title'         => 'Короткий и содержательный заголовок.',
    'deals_form_hint_content'       => 'Здесь вы можете описать свою сделку своими словами.',
    'deals_form_hint_author'        => 'Например: rooland',
    'deals_form_hint_field'         => 'Добавьте сюда ссылку на сайт, где можно найти сделку и получить дополнительную информацию.',
    'deals_form_hint_thumbnail'     => 'Добавьте сюда ссылку на картинку',
    'deals_form_hint_valid_until'   => 'Если сделка заканчивается в определенный день, пожалуйста, введите эту дату.',
    'deals_form_hint_price_before'  => 'Пожалуйста, введите цену до скидки в рублях (по умолчанию), евро (eur) или долларах (usd).',
    'deals_form_hint_price_after'   => 'Пожалуйста, введите цену после скидки в рублях, euro или usd.',
    'deals_form_hint_coupon'        => 'Если у вас есть купон, пожалуйста, введите здесь.',
    // views/deals/admin
    'deals_page_admin_title'        => 'Скидки',
    'deals_button_add'              => 'Добавить сделку',
    // views/deals/category
    'deals_page_title_{name}'       => 'Скидки - {name}',
    'deals_breadcrumbs_label_index' => 'Скидки',
    'deals_category_header_title'   => 'Скидки',
    'deals_index_list_empty_text'   => 'Скидки не найдены.',
    // views/deals/create
    'page_create_deals_title'       => 'Добавить сделку',
    // views/deals/index
    'page_deals_index_title'        => 'Руланд скидки',
    'deals_index_filter_soon'       => 'Скоро заканчиваются',
    'deals_index_filter_expired'    => 'Завершенные',
    // views/deals/update
    'page_deals_update_title'       => 'Обновить сделку',
    'deals_expired_text'            => 'Скидка закончилась.',
    'deals_countdown_text'          => 'Скидка действует ограниченное время!',
    'deals_coupon'                  => 'Промокод',
    'deals_author'                  => 'Автор скидки',
    // views/deals/partials/button
    'button_text_go_to_deal'        => 'К скидки',
    'button_title_go_to_deal'       => 'Перейти на страницу со скидкой',
];
