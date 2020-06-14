<?php
    return [
        #home permission
        [
            'name'        => 'Home',
            'route'       => 'home',
            'permissions' => ['view'],
            'parent'      => 'Home'
        ],
        #user permission
        [
            'name'        => 'Users',
            'route'       => 'users',
            'permissions' => ['view', 'create', 'update', 'delete'],
            'parent'      => 'Users'
        ],
        #role permission
        [
            'name'        => 'Role',
            'route'       => 'role',
            'permissions' => ['view', 'create', 'update', 'delete'],
            'parent'      => 'Role'
        ]
    ];