<?php

interface SecretDao
{
    public function getCode($id);
    public function getLabel($id);
}

?>