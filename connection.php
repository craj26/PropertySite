<?php

    class DbCon
    {
        private $server = 'localhost:3308';
        private $user = 'root';
        private $pwd = 'root';
        private $db = 'propertydb';

        private $con = '';

        function connect()
        {
            $this->con = new mysqli($this->server,$this->user, $this->pwd, $this->db);

            if($this->con->connect_error)
            {
                die ('Error : ' . $this->con->connect_error );
            }
            else
            {
                return $this->con;
            }

        }

        function dissconnect()
        {
            $this->con->close();
        }


    }

?>