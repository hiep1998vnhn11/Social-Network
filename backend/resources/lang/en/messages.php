<?php

return [
    // must have
    'language' => 'Language',
    'lang' => 'English',
    // common parts
    'password' => 'Password',
    'login_id' => 'Login ID',
    'login'    => 'Login',
    'login_success' => 'You are logged in',
    'register' => 'Register',
    'cancel'   => 'Cancel',
    'edit'     => 'Edit',
    'delete'   => 'Delete',
    // page title
    'admin' => 'Admin',
    'dist'  => 'Dist',
    // page subtitle
    'list'     => 'List',
    // sidemenu
    'logout' => 'Logout',

    // admin/list
    'nickname' => 'Nickname',
    'create'   => 'Create',
    // admin/create
    'create_confirm'   => 'Confirm registration details',
    'new_admin_regist' => 'New administration details',
    'str_4'            => '4 or more single-byte alphanumeric characters',
    'str_10'           => 'Alphanumeric characters and symbols (@ - _ #) 10 characters or more',
    // admin/edit
    'edit_title'          => 'Change registration details',
    'current_pass'        => 'Please enter your current password',
    'update_admin_regist' => 'Updated the administrator registration contents',
    'confirm'             => 'Confirm',
    'edit_confirm'        => 'Confirm Changes',
    'new_password'        => 'New Password',
    'do_not_update'       => 'Password is incorrect',
    'change_password'     => 'Change Password',
    'edit_anotation'      => '※Changes will be applied when the register button is pressed※',
    // admin/delete
    'del_confirm'        => 'Delete this account',
    'delete_message'     => 'Admin account deleted',
    'not_delete_message' => 'Cannot delete yourself',
    // distribution/register
    'dist_period'             => 'Period',
    'current_time'            => 'Current Time',
    'dist_type'               => 'Distribution type',
    'file_input_display_name' => 'Select file',
    'preview'                 => 'Preview',
    'weather_forecast'        => 'Forecast',
    'image'                   => 'Stock Prices IMG',
    'text'                    => 'Text',
    'selectbox_default'       => 'Select Distribution Type',
    //// forecast type
    'weekly' => 'Weekly',
    'daily'  => 'Daily',
    //// weather type
    'weather' => [
        'sunny'             => 'sunny',
        'sunny_then_cloudy' => 'sunny then cloudy',
        'sunny_then_rain'   => 'sunny then rain',
        'cloudy'            => 'cloudy',
        'cloudy_then_sunny' => 'cloudy then sunny',
        'cloudy_then_rain'  => 'cloudy then rain',
        'rain'              => 'rain',
        'rain_then_cloudy'  => 'rain then cloudy',
        'rain_then_sunny'   => 'rain then sunny',
        'typhoon'           => 'typhoon',
    ],

    // top
    'top' => 'Top',

    // validation messages
    'require'         => 'Required',
    'format'          => 'Please enter in the specified format',
    'filesize'        => 'Too Large Filesize',
    'wrongmime'       => 'not jpg,jpeg,png',
    'template_error'  => 'template error',
    'atLeast1Require' => 'Fill at least 1 of these fields',
    'blankRemoved'    => 'Removed leading and trailing whitespaces, blank lines',

    // flash message
    'success'        => 'Successfully Registered',
    'delete_confirm' => 'Do you really want to delete this?',
];
