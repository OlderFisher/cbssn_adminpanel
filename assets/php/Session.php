<?php

/**
 * Created by PhpStorm.
 * User: aleksandrlilik
 * Date: 12.07.17
 * Time: 09:38
 */
/**

 *  Class Session v. 0.1.0.0
 *      Удобная оберка для стандартных сессий

 *  Примечание:
 *      Класс статичный, потому любой метод надо вызывать через двойное двоеточие, например:
 *      Session::start();
 *      $user = Session::get('user');
 *      Session::set('var', $variable);

 *  Метод isCreated ()
 *      Проверяет, установленны ли Cookie сессии и правильные ли они
 *      @ Return boolean

 *  Метод start ()
 *      Инициирует сессию. Перед любой попыткой вызвать метод ниже надо обязательно стартовать сессию!
 *      Если вы не уверены, была ли сессия начата - можете вызвать этот метод снова.
 *      Если сессия не была начата, метод ее начнет. Иначе - вызов будет проинорирован

 *  Метод set (String $name, Mixed $value)
 *      Добавляет в сессию переменную с именем $name и значением $value

 *  Метод get (String $name)
 *      Возвращает значение переменной $name или null
 *      @ Return Mixed

 *  Метод del (String $name)
 *      Удаляет переменную с именем $name

 *  Метод clear ()
 *      Очищает все значения, переданные сессии, но сессию не уничтожает

 *  Метод destroy ()
 *      Уничтожает сессию, при этом стираются Cookie, и все значения, переданные в сессию

 *  Метод restart ()
 *      Уничтожает, а потом стартует сессию

 *  Метод getArray ()
 *      Возвращает массив всех переменных, переданных в сессию.
 *      Рекомендуется использовать только для отладки, а все значения
 *      получать при помощи метода get
 *      @ Return Array

 *  Метод commit ()
 *      Сохраняет все значения и закрывает сессию. После вызова этого
 *      метода работа с сессией невозможна, пока сессия не будет снова
 *      запущенна методом start()

 */

class Session {
    private static $lifetime = 1200000; // 14 дней
    private static $cookieName = "cid";
    private static $started = false;

    public static function isCreated () {
        return (!empty($_COOKIE[self::$cookieName]) and ctype_alnum($_COOKIE[self::$cookieName])) ? true : false;
    }

    public static function start () {
        if(!self::$started) {
            // Если содержи
            if(!empty($_COOKIE[self::$cookieName]) and !ctype_alnum($_COOKIE[self::$cookieName])) {
                unset($_COOKIE[self::$cookieName]);
            }
            session_set_cookie_params (self::$lifetime, '/');
            session_name (self::$cookieName);
            session_start ();
            self::$started = true;
        }
    }

    public static function set ($name, $value) {
        if(self::$started) {
            $_SESSION[$name] = $value;
        } else {
            trigger_error('You should start Session first', E_USER_WARNING);
        }
    }

    public static function get ($name) {
        if(self::$started) {
            return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
        } else {
            trigger_error('You should start Session first', E_USER_WARNING);
        }
    }

    public static function del ($name) {
        if(self::$started) {
            unset($_SESSION[$name]);
        } else {
            trigger_error('You should start Session first', E_USER_WARNING);
        }
    }

    public static function clear () {
        if(self::$started) {
            unset($_SESSION);
        } else {
            trigger_error('You should start Session first', E_USER_WARNING);
        }
    }

    public static function destroy () {
        if(self::$started) {
            self::$started = false;
            unset($_COOKIE[self::$cookieName]);
            setcookie(self::$cookieName, '', 1, '/');
            session_destroy();
        } else {
            trigger_error('Session is not started!', E_USER_WARNING);
        }
    }

    public static function restart () {
        self::destroy();
        self::start();
    }

    public static function getArray () {
        if(self::$started) {
            return $_SESSION;
        } else {
            trigger_error('You should start Session first', E_USER_WARNING);
        }
    }

    public static function commit () {
        if(self::$started) {
            session_write_close();
            self::$started = false;
        } else {
            trigger_error('You should start Session first', E_USER_WARNING);
        }
    }
}

?>





