<?php

namespace Models;

class Database extends \PDO
{
    public function __construct($file = 'config/bdd_config.ini')
    {
        if (!$settings = @parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');
       
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ';port=' . $settings['database']['port'] .
        ';dbname=' . $settings['database']['schema'];

        $options = [
            Database::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            Database::ATTR_ERRMODE            => Database::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            Database::ATTR_DEFAULT_FETCH_MODE => Database::FETCH_ASSOC, //make the default fetch be an associative array
          ];

        parent::__construct($dns, $settings['database']['username'], $settings['database']['password'],$options);
    }
}