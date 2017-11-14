<?php

  $data =  [
    'term' => $_GET['q']

  ];
 header('Content-type: application/json');

    echo json_encode($data, JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);

/**
 * Created by PhpStorm.
 * User: Joseph
 * Date: 10/28/2016
 * Time: 4:48 PM
 */