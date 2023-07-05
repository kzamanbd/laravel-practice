<?php

return [
    'default_permissions' => [
        'view' => 'Description', // TODO Add permission description
        'create' => 'Description', // TODO Add permission description
        'update' => 'Description', // TODO Add permission description
        'show' => 'Description', // TODO Add permission description
        'delete' => 'Description', // TODO Add permission description
    ],

    'available' => [
        'dashboard' => [
            'name' => 'Dashboard',
            'except_permissions' => ['create', 'update', 'show', 'trash', 'delete'], // Example: ['store', 'update']
            'additional_permissions' => [// Example ['action' => 'Action description']

            ],
        ],

        'user' => [
            'name' => 'Users',
            'except_permissions' => [], // Example: ['store', 'update']
            'additional_permissions' => [// Example ['action' => 'Action description']

            ],
        ],

        'permission' => [
            'name' => 'Permission',
            'except_permissions' => [], // Example: ['store', 'update']
            'additional_permissions' => [// Example ['action' => 'Action description']

            ],
        ],

        'role' => [
            'name' => 'Role',
            'except_permissions' => [], // Example: ['store', 'update']
            'additional_permissions' => [// Example ['action' => 'Action description']

            ],
        ],
    ],
];
