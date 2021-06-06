<?php

interface UserDao
{
    public function getUser($username, $status);
    public function exist($username, $status);
    public function getClientUser($clientCode);
}


?>