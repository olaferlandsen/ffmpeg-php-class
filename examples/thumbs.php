<?php
/**
*	include FFmpeg class
**/
include DIRNAME(DIRNAME(__FILE__)).'/src/FFmpeg.php';
$start = 1;
$frames = 10;
$size = '100x100';
$file = '/var/www/file.mp4';
$FFmpeg = new FFmpeg;
$FFmpeg->input( $file )->thumb($size, $start , $frames )->ready();