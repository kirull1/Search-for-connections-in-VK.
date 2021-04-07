<?php

    set_time_limit(30000000);

    require_once 'vendor/autoload.php';
    include 'function.php';

    $vk = new VK\Client\VKApiClient('5.21');

    $token = 'token'; // Vk token;

    $id[] = 123456; // start id;

    for ($i=0; $i < 10; $i++) {
        sleep(1);
        try {
            $get = $vk->friends()->get($token, array('user_id' => $id[$i]));
            foreach ($get['items'] as $value) $id[] = $value;
        }catch(Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }
    $id = array_unique($id);
    echo 'Всего '.count($id).' id'.' | Осталось ждать приблизительно '. secToStr(count($id)*1.3) . "\n";

    foreach ($id as $value) {
        sleep(1);
        try {
            $get = $vk->users()->get($token, array('user_ids' => $value));
            $get_count = $vk->friends()->get($token, array('user_id' => $get[0]['id'])) ?: 0;
        }catch(Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
        $result = 'id:'.$get[0]['id'].' | '.$get[0]['first_name'].' '.$get[0]['last_name'].' | Друзей: '. ($get_count['count'] ?: '---');
        file_put_contents('log/log'.$id[0].'.txt', $result."\n", FILE_APPEND);
        echo $result."\n";
        $res[] = $result;
        unset($get_count);
    }

    print_r($res);