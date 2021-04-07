<?php

    function num_word($value, $words, $show = true) {
        $num = $value % 100;
        if ($num > 19) { 
            $num = $num % 10; 
        }
        
        $out = ($show) ?  $value . ' ' : '';
        switch ($num) {
            case 1:  $out .= $words[0]; break;
            case 2: 
            case 3: 
            case 4:  $out .= $words[1]; break;
            default: $out .= $words[2]; break;
        }
        
        return $out;
    }
    
    function secToStr($secs){
        $res = '';
        
        $days = floor($secs / 86400);
        $secs = $secs % 86400;
        $res .= num_word($days, array('день', 'дня', 'дней')) . ', ';
        
        $hours = floor($secs / 3600);
        $secs = $secs % 3600;
        $res .= num_word($hours, array('час', 'часа', 'часов')) . ', ';
    
        $minutes = floor($secs / 60);
        $secs = $secs % 60;
        $res .= num_word($minutes, array('минута', 'минуты', 'минут')) . ', ';
    
        $res .= num_word($secs, array('секунда', 'секунды', 'секунд'));
        
        return $res;
    }

    function search($array, $search, $array_rep){
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result[strval($key)] = search($value, $search, $array_rep);
            }else{
                if ($value == $search) {
                    $result[strval($search)] = $array_rep;
                }else $result[] = $value;
            }
        }
        return $result;
    }

    function replarray($array, $file_name, $pos = 1){
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                file_put_contents('log/log'.$file_name.'.txt', str_repeat('  ', $pos).'['.$key.'] {'."\n", FILE_APPEND);
                replarray($value, $file_name, $pos+2);
                file_put_contents('log/log'.$file_name.'.txt', str_repeat('  ', $pos).'}'."\n", FILE_APPEND);
            }else{
                file_put_contents('log/log'.$file_name.'.txt', str_repeat('  ', $pos).$value."\n", FILE_APPEND);
            }
        }
        return true;
    }

    function findway($array, $file_name, $find_id){
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $res = findway($value, $file_name, $find_id);
                if (!empty($res)) {
                    file_put_contents('log/log'.$file_name.'.txt', $res);
                    return $key.' -> '.$res;
                }
            }else{
                if ($value == $find_id) {
                    return $value;
                }
            }
        }
        return false;
    }