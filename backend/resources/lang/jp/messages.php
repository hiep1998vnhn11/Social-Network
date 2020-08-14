<?php

return [
        // must have
    'language' => '言語',
    // common parts
    'password' => 'パスワード',
    'login_id' => 'ログインID',
    'login'    => 'ログイン',
    'login_success' => 'You are logged in',
    'register' => '登録',
    'cancel'   => 'キャンセル',
    'edit'     => '編集',
    'delete'   => '削除',
    // page title
    'admin' => '管理者',
    'dist'  => '配信',
    // page subtitle
    'list'     => '一覧',
    // sidemenu
    'logout' => 'ログアウト',

    // admin/list
    'nickname' => 'ニックネーム',
    'create'   => '作成',
    // admin/create
    'create_confirm'   => '登録内容確認',
    'new_admin_regist' => '管理者を新規登録しました',
    'str_4'            => '半角英数字4文字以上',
    'str_10'           => '半角英数字及び記号(@ - _ #)10文字以上',
    // admin/edit
    'edit_title'          => '登録内容変更',
    'current_pass'        => '現在のパスワードを入力してください',
    'update_admin_regist' => '管理者登録内容を更新しました',
    'confirm'             => '確認',
    'edit_confirm'        => '変更内容確認',
    'new_password'        => '新しいパスワード',
    'do_not_update'       => 'パスワードが違います',
    'change_password'     => 'パスワードを変更する',
    'edit_anotation'      => '※変更は登録ボタンが押された段階で適用されます※',
    // admin/delete
    'del_confirm'        => 'このアカウントを削除',
    'delete_message'     => '管理者を削除しました',
    'not_delete_message' => '自身のアカウントは削除できません',
    // distribution/register
    'dist_period'             => '期間',
    'current_time'            => '現在時刻',
    'dist_type'               => '配信タイプ',
    'file_input_display_name' => 'ファイル選択',
    'preview'                 => 'プレビュー',
    'weather_forecast'        => '天気',
    'image'                   => '株価画像',
    'text'                    => '本文',
    'selectbox_default'       => '配信タイプを選択してください',
    //// forecast type
    'weekly' => '週間',
    'daily'  => '日間',
    //// weather type
    'weather' => [
        'sunny'             => '晴れ',
        'sunny_then_cloudy' => '晴れのち曇り',
        'sunny_then_rain'   => '晴れのち雨',
        'cloudy'            => '曇り',
        'cloudy_then_sunny' => '曇りのち晴れ',
        'cloudy_then_rain'  => '曇りのち雨',
        'rain'              => '雨',
        'rain_then_cloudy'  => '雨のち曇り',
        'rain_then_sunny'   => '雨のち晴れ',
        'typhoon'           => '台風',
    ],

    // top
    'top' => 'トップ',

    //validation message
    'require'         => '入力必須',
    'format'          => '指定された形式で入力してください',
    'filesize'        => 'ファイルが大きすぎます',
    'wrongmime'       => 'jpg,jpeg,pngではないです',
    'template_error'  => 'テンプレートエラー',
    'atLeast1Require' => '最低1枚は必要です',
    'blankRemoved'    => '行頭・行末の空白、改行・空白のみの行を削除しました',

    // flash message
    'success' => '登録完了しました',
    'delete_confirm' => '本当に削除しますか?',
];
