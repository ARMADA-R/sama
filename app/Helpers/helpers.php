<?php

if(!function_exists("AdminUrl")){
    function AdminUrl($url = null)
    {
        return url("admin/".$url);
    }
}