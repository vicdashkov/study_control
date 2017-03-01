<?php
echo password_hash("12345",PASSWORD_BCRYPT);
//$hash = "$2y$10$0SMohIM2oT8D9pnCSPYHYeB09y8Am85BtGnMrJZDdvrYn4sFdEJ2W";
//
//if (password_verify("5025", $hash)) {
//    echo 'good';
//} else {
//    echo 'not good';
//}