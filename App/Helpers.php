<?php

/**
 * @params string|null $params
 * @return string
 */
function site(string $params = null):string 
{
    if ($params && !empty(SITE[$params])) {
        return SITE[$params];
    }
    return SITE['root'];
}
function routeImage(string $imageUrl):string
{
    return "https://via.placeholder.com/1200x628/0984e3/FFF?text={$imageUrl}";
}
function asset(string $path, $time = true):string
{    
    $file = SITE['root']."/views/assets/{$path}";
    $fileOnDir = dirname(__DIR__, 1)."/views/assets/{$path}";    
    if ($time && file_exists($fileOnDir)) {        
        $file .= "?times=".filemtime($fileOnDir);
    }
    return $file;
}

function flash(string $type = null, string $message = null ):?string
{
    if ($type && $message) {
        $_SESSION["flash"] = [
            "type" => $type,
            "message" => $message,
        ];
        return null;
    } 
    if (!empty($_SESSION["flash"]) && $flash = $_SESSION["flash"]) {
        unset($_SESSION["flash"]);
        return "<div class=\"message {$flash["type"]}\">{$flash["message"]}</div>";
        
    }
    return null;
    
}

function dd($data)
{
    echo "<pre>";
    var_dump($data);die;
}
