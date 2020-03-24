<?php

define('PERMISSIONS', array(
    'librarian' => array(
        'inheritance' => '',
        'permissions' => array(
            'home',
            'transactions',
            'reports',
            'libraries',
            'about'
        )
    ),
    'admin' => array(
        'inheritance' => 'librarian',
        'permissions' => array(
            'members',
            'settings'
        )
    )
));
