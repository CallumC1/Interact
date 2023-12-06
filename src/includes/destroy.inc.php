<?php

session_start();
session_destroy();

header("Location: /interact/src/pages/index.php");