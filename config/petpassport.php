<?php

return [
    'apiPath' => 'api',
    'filemanager' => [
        'limits' => [
            'storage' => env('PETPASSPORT_STORAGE_LIMIT', 0),
            'files' => [
                'image' => [
                    'translate' => 'Изображения',
                    'maxSize' => 10240,
                    'resolution' => [
                        'maxWidth' => 1920,
                        'maxHeight' => 1080
                    ],
                    'extensions' => ['jpg', 'jpeg', 'png', 'bmp']
                ],
                'video' => [
                    'translate' => 'Видео',
                    'maxSize' => 51200,
                    'resolution' => [
                        'maxWidth' => 1920,
                        'maxHeight' => 1080
                    ],
                    'extensions' => ['mp4', 'avi', 'mov', 'mkv', 'wmv', 'flv']
                ]
            ],
        ],
        'disk' => env('FILEMANAGER_DISK', 'public'),
        'order' => env('FILEMANAGER_ORDER', 'mime'),
        'direction' => env('FILEMANAGER_DIRECTION', 'asc'),
        'cache' => env('FILEMANAGER_CACHE', false),
        'buttons' => [
            'create_folder' => true,
            'upload_button' => true,
            'select_multiple' => true,
            'rename_folder' => true,
            'delete_folder' => true,
            'rename_file' => true,
            'delete_file' => true,
        ],
        'filters' => [
            'Images' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'bmp', 'tiff'],
            'Documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pps', 'pptx', 'odt', 'rtf', 'md', 'txt', 'css'],
            'Videos' => ['mp4', 'avi', 'mov', 'mkv', 'wmv', 'flv', '3gp', 'h264'],
            'Audios' => ['mp3', 'ogg', 'wav', 'wma', 'midi'],
            'Compressed' => ['zip', 'rar', 'tar', 'gz', '7z', 'pkg'],
        ],
        'filter' => false,
        'naming' => \App\PetPassport\Services\DefaultNamingStrategy::class,
        'jobs' => [],
    ],
];
