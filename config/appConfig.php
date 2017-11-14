<?php
function getAppConfig(){
    return [
        'forms' => [
            'login' => [
                'name' => 'login',
                'id' => '',
                'method' => 'post',
                'action' => 'login.php',
                'fields' => [
                    'username' => [
                        'type' => 'text',
                        'name' => 'username',
                        'required' => true,
                        'maxlength' => 30,
                        'value' => ''
                    ],
                    'password' => [
                        'type' => 'password',
                        'name' => 'password',
                        'required' => true,
                        'maxlength' => 30,
                        'value' => ''
                    ],
                    'submit' => [
                        'type' => 'submit',
                        'name' => 'submit',
                        'value' => 'Login'
                    ]
                ]
            ],
            'addPatient' => [
                'name' => 'addpatient',
                'id' => '',
                'method' => 'post',
                'action' => 'add_patient.php',
                'fields' => [
                    'firstname' => [
                        'type' => 'text',
                        'name' => 'firstname',
                        'required' => true,
                        'maxlength' => 50,
                        'value' => ''
                    ],
                    'lastname' => [
                        'type' => 'text',
                        'name' => 'lastname',
                        'required' => true,
                        'maxlength' => 50,
                        'value' => ''
                    ],
                    'date' => [
                        'type' => 'date',
                        'name' => 'dateofbirth',
                        'maxlength' => 20,
                        'value' => ''
                    ],
                    'chartnumber' => [
                        'type' => 'text',
                        'name' => 'chartnumber',
                        'required' => true,
                        'maxlength' => 50,
                        'value' => ''
                    ],
                    'homezip' => [
                        'type' => 'text',
                        'name' => 'homezip',
                        'required' => false,
                        'maxlength' => 5,
                        'value' => ''
                    ],
                    'workzip' => [
                        'type' => 'text',
                        'name' => 'workzip',
                        'required' => false,
                        'maxlength' => 5,
                        'value' => ''
                    ],
                    'sex' => [
                        'type' => 'select',
                        'name' => 'sex',
                        'required' => false,
                        'maxlength' => 1,
                        'value' => '',
                        'options' => ['names' => ['male', 'female'],
                            'values' => ['M', 'F']
                        ]
                    ],
                    'tester' => [
                        'type' => 'text',
                        'name' => 'tester',
                        'required' => false,
                        'maxlength' => 50,
                        'value' => ''
                    ],
                    'email' => [
                        'type' => 'text',
                        'name' => 'email',
                        'required' => false,
                        'maxlength' => 100,
                        'value' => ''
                    ]

                ]
            ],
            'allergens' => [
                'name' => 'allergens',
                'id' => '',
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'fields' => [
                    'allergenname' => [
                        'type' => 'text',
                        'name' => 'allergenname',
                        'maxlength' => 50,
                        'value' => ''
                    ],
                    'expdate' => [
                        'type' => 'text',
                        'name' => 'expdate',
                        'maxlength' => 5,
                        'value' => ''
                    ],
                    'groupid' => [
                        'type' => 'text',
                        'name' => 'groupid',
                        'maxlength' => 1,
                        'value' => ''
                    ],
                    'groupname' => [
                        'type' => 'text',
                        'name' => 'groupname',
                        'maxlength' => 20,
                        'readonly' => true,
                        'value' => ''
                    ],
                    'lotnumber' => [
                        'type' => 'text',
                        'name' => 'lotnumber',
                        'maxlength' => 10,
                        'value' => ''
                    ],
                    'batteryname' => [
                        'type' => 'text',
                        'name' => 'batteryname',
                        'maxlength' => 1,
                        'value' => ''
                    ],
                    'fileupload' => [
                        'type' => 'file',
                        'name' => 'fileupload',
                        'value' => 'Choose File'
                    ],
                    'submit' => [
                        'type' => 'submit',
                        'name' => 'submit',
                        'value' => 'Submit New Allergen'
                    ],
                    'update' => [
                        'type' => 'submit',
                        'name' => 'update',
                        'value' => 'Update Allergen',
                        'disabled' => 'disabled'
                    ],
                    'cancel' => [
                        'type' => 'submit',
                        'name' => 'cancel',
                        'value' => 'Cancel',
                        'disabled' => 'disabled'
                    ],
                    'allergenid' => [
                        'type' => 'hidden',
                        'name' => 'allergenid',
                        'value' => ''
                    ]
                ]
            ],
            'newuser' => [
                'name' => 'newuser',
                'id' => '',
                'method' => 'post',
                'fields' => [
                    'username' => [
                        'type' => 'text',
                        'name' => 'username',
                        'value' => '',
                        'maxlength' => 30
                    ],
                    'password' => [
                        'type' => 'text',
                        'name' => 'password',
                        'value' => '',
                        'maxlength' => 30
                    ],
                    'adduser' => [
                        'type' => 'submit',
                        'name' => 'adduser',
                        'value' => 'Add User',
                    ]
                ]
            ],
            'navagation' => [
                'name' => 'topNav',
                'id' => '',
                'method' => 'post',
                'action' => 'list_patient.php',
                'fields' => [
                    'search' => [
                        'type' => 'text',
                        'name' => 'search',
                        'value' => ''
                    ],
                    'submit' => [
                        'type' => 'submit',
                        'name' => 'submit',
                        'value' => 'Submit'
                    ]
                ]
            ]
        ],
        'reports' => [
            'immunoTherapy' => [
            ],
            'userReport' => [
            ]
        ]
    ];
}
