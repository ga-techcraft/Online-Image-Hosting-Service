<?php

namespace Database;

use Helpers\Settings;
use mysqli;

class MySQLWrapper extends mysqli{

  public function __construct(){
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      
    $host = Settings::readEnvInfo('DATABASE_HOST');
    $user = Settings::readEnvInfo('DATABASE_USER');
    $password = Settings::readEnvInfo('DATABASE_PASSWORD');
    $database = Settings::readEnvInfo('DATABASE_NAME');
    parent::__construct($host, $user, $password, $database);

  }
}
