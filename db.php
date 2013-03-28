<?php

function ConnectDb()
{
return new PDO('sqlite:/var/databases/apartment_manager.sqlite');
}
?>
