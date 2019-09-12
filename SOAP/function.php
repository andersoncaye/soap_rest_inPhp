<?php
    include 'system/config.php';
    require 'system/Database.php';

    //Database
    $this->database = new \system\Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

    function price ($name)
    {
        $details = array
        (
            'abc' => 100;
            'xyz' => 200;
        );

        foreach ($details as $n=>$p)
        {
            if ($name == $n)
                $price = $p;
        }

        return $price;
    }

    function countbooks()
    {

    }

?>