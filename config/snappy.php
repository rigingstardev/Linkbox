<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => env('SNAPPY_BINARY_PATH', 'C:/wkhtmltopdf'),
        'timeout' => 600,
        'options' => array(
            'lowquality' => false,
            'footer-line' => false,
            'margin-top' => 15,
            'margin-left' => 15,
            'margin-right' => 15,
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => 'D:/xampp/htdocs/LinkBox/Trunk/vendor/h4cc/wkhtmltoimage-amd64/bin',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
