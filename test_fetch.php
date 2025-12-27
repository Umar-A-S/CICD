<?php
ob_start();
$_POST = ['id'=>1,'ipk'=>3.5,'semester'=>2];
include __DIR__.'/fetch_requirements.php';
$output = ob_get_clean();
echo $output;
