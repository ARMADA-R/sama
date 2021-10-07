<?php

if(!function_exists("AdminUrl")){
    function AdminUrl($url = null)
    {
        return url("admin/".$url);
    }
}

// if(!function_exists("RandomString")){
//     function RandomString($length = 8)
//     {
//         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//         $randstring = '';
//         for ($i = 0; $i < 10; $i++) {
//             $randstring = $characters[rand(0, strlen($characters))];
//         }
//         return $randstring;
//     }

// }