<?php

// phpcs:ignoreFile

/**
 * \Yii::t('app', 'rbac_administrate_posts')
 */
return [
    // views/layouts/main
    'menu_label_login'             => 'Войти',
    'menu_label_panel'             => 'Панель',
    'menu_label_profile'           => 'Профиль',
    'menu_label_user_admin'        => 'Пользователи',
    'logout_({username})'          => 'Выйти ({username})',
    'footer_about_link'            => 'Об авторе',
    'footer_premium_link'          => 'Premium',
    'footer_contact_link'          => 'Обратная связь',
    // views/partials/share
    'share_friends'                => 'Порекомендуй друзьям:',
    'button_save'                  => 'Сохранить',
    'button_update'                => 'Изменить',
    'button_edit'                  => 'Редактировать',
    'button_delete'                => 'Удалить',
    'button_more'                  => 'Подробнее →',
    'button_search'                => 'Найти',
    'button_clear'                 => 'Сбросить',
    'columns_label_status'         => 'Статус',
    'columns_label_created'        => 'Дата публикации',
    'columns_label_hits'           => 'Просмотров',
    'columns_label_comments'       => 'Комментариев',
    'user_anonym'                  => 'Аноним',
    'breadcrumbs_label_update'     => 'Изменить',
    'username'                     => 'Логин',
    'email'                        => 'E-Mail',
    'imgur_add_img_text'           => 'Нажми здесь или перетащи файл, что бы загрузить картинку.',
    'sort_new'                     => 'Новые',
    'sort_hits'                    => 'Популярные',
    'sort_comments'                => 'Обсуждаемые',
    'added'                        => 'Добавил(а)',
    'author'                       => 'Автор',
    // models/ContactForm
    'contact_name'                 => 'Имя',
    'contact_email'                => 'E-Mail',
    'contact_subject'              => 'Тема',
    'contact_body'                 => 'Сообщение',
    // views/site/contact
    'contact_title'                => 'Обратная связь',
    'contact_email_send'           => 'Спасибо. Ваше сообщения отправлено. Мы ответим вам в ближайщее время.',
    'contact_button_send'          => 'Отправить',
    // tests/functional/ContactFormCest.php
    '{field}_cannot_be_blank'      => 'Необходимо заполнить «{field}»',
    'email_is_not_valid_email'     => 'Значение «E-Mail» не является правильным email адресом',
    //
    'signup_title'                 => 'Регистрация',
    'status'                       => 'Статус',
    'created_at'                   => 'Создан в',
    'premium'                      => 'Premium',
    'or'                           => 'или',
    'button_register'              => 'Зарегистироваться',
    'button_login'                 => 'Войти',
    'password'                     => 'Пароль',
    'invalid_login_password'       => 'Не верный логин или пароль.',
    'username_already_taken'       => 'Это имя пользователя уже занято.',
    'email_already_taken'          => 'Пользователь с таким E-Mail уже зарегистирован.',
    'captcha'                      => 'Капча',
    'status_draft'                 => 'Опубликовать',
    'status_public'                => 'Черновик',
    'yes'                          => 'Да',
    'no'                           => 'Нет',
    'rbac_recreate_permissions'    => 'Ты уверен что хочешь пересоздать дерево разрешений?',
    'rbac_administrate_posts'      => 'Администрирование записей',
    'rbac_administrate_users'      => 'Администрирование пользователей',
    'rbac_administrate_categories' => 'Администрирование категорий',
    'no_user_{username}'           => 'Пользователь с именем {username} не найден.',
    'no_role_{role}'               => 'Роль {role} не найдена.',
];