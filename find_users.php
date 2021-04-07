<?php

    set_time_limit(30000000);
    ini_set('memory_limit', '12800M');

    require_once 'vendor/autoload.php';
    include 'function.php';

    $vk = new VK\Client\VKApiClient('5.21');

    $token = 'token'; // Vk token;

    $id[] = 123456; // start id;
    $search_id = 123456;

    for ($i=0; $i < 100000; $i++) {
        sleep(0.5);
        try {
            $get = $vk->friends()->get($token, array('user_id' => $id[$i]));
            foreach ($get['items'] as $value){
                $res[$id[$i]][] = $value;
                $id[] = $value; 
                if ($search_id == $value){
                    echo 'Нашёл!'."\n";
                    $i = 100000;
                    break;
                } 
            }
            $id = array_unique($id);
        }catch(Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }

    foreach ($res as $key => $value) {
        if($key != $id[0]){
            $res = search($res, $key, $value);
            unset($res[$key]);
        }
    }

    findway($res, rand(100000, 999999), $search_id);