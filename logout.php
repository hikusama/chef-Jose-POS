<?php
require_once "function.php";

start_secure_session();
session_unset();
session_destroy();

header("Location: index.php");
exit();
