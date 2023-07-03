<?php

namespace App\Constants;

class FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This class  basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo(){

        $data['advertisement'] = [
            'path' => 'assets/images/advertisement'
        ];
        $data['withdrawVerify'] = [
            'path'=>'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path' =>'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path' =>'assets/verify'
        ];
        $data['default'] = [
            'path' => 'assets/images/default.png',
        ];
        $data['withdrawMethod'] = [
            'path' => 'assets/images/withdraw/method',
            'size' => '800x800',
        ];
        $data['ticket'] = [
            'path' => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path' => 'assets/images/logoIcon',
        ];
        $data['favicon'] = [
            'size' => '128x128',
        ];
        $data['extensions'] = [
            'path' => 'assets/images/extensions',
            'size' => '36x36',
        ];
        $data['seo'] = [
            'path' => 'assets/images/seo',
            'size' => '1180x600',
        ];
        $data['userProfile'] = [
            'path' =>'assets/images/user/profile',
            'size' =>'350x300',
        ];
        $data['userBgImage'] = [
            'path' =>'assets/images/user/profile',
            'size' =>'590x300',
        ];
        $data['adminProfile'] = [
            'path' =>'assets/admin/images/profile',
            'size' =>'400x400',
        ];
        $data['subcategory'] = [
            'path' => 'assets/images/subcategory',
            'size' => '200x200',
        ];
        $data['service'] = [
            'path' => 'assets/images/service',
            'size' => '920x470',
        ];
        $data['software'] = [
            'path' => 'assets/images/software',
            'size' => '920x470',
        ];
        $data['extraImage'] = [
            'path' => 'assets/images/extraImage',
            'size' => '920x470',
        ];
        $data['documentFile'] = [
            'path' => 'assets/file/software/document',
        ];
        $data['softwareFile'] = [
            'path' => 'assets/file/software',
        ];
        $data['job'] = [
            'path' => 'assets/images/job',
            'size' => '920x470',
        ];
        $data['workFile'] = [
            'path' => 'assets/file/workFile',
        ];
        $data['chatFile'] = [
	        'path' => 'assets/file/chatFile',
	    ];
        $data['messageFile'] = [
	        'path' => 'assets/file/messageFile',
	    ];
        return $data;
	}

}
