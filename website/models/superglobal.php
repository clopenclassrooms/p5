<?php 


namespace models;

class SuperGlobal{
    public static function get($superGlobal){
        switch ($superGlobal)
        {
            case "SESSION" :
                return (isset($_SESSION) ? $_SESSION : null);
            break;
            case "SERVER" :
                return (isset($_SERVER) ? $_SERVER : null);
            break;
            case "GET" :
                return (isset($_GET) ? $_GET : null);
            break;
            case "POST" :
                return (isset($_POST) ? $_POST : null);
            break;
        }
        
    }

    public static function set_key($superGlobal, $key, $value){
        switch ($superGlobal)
        {
            case "SESSION" :
                $_SESSION[$key] = $value;
                break;
            case "SERVER" :
                $_SERVER[$key] = $value;
                break;
        }
        
    }

    public static function get_key($superGlobal, $key){
        switch ($superGlobal)
        {
            case "SESSION" :
                return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
            break;
            case "SERVER" :
                return (isset($_SERVER[$key]) ? $_SERVER[$key] : null);
            break;
        }
        
    }

    public static function forget($superGlobal,$key){
        switch ($superGlobal)
        {
            case "SESSION" :
                unset($_SESSION[$key]);
            break;
            case "SERVER" :
                unset($_SERVER[$key]);
            break;
        }
        
    }

    public static function destroy($superGlobal){
        switch ($superGlobal)
        {
            case "SESSION" :
                unset($_SESSION);
            break;
        }
        
    }
}