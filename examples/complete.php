<?php
/**
*	include FFmpeg class
**/
include DIRNAME(DIRNAME(__FILE__)).'/src/ffmpeg.class.php';

/**
*	get options from database
**/
$options = array(
	'duration'	=>	99,
	'position'	=>	0,
	'itsoffset'	=>	2,
);
/**
*	Create command
*/
$FFmpeg = new FFmpeg( '/usr/local/bin/ffmpeg' );
$FFmpeg->input( '/var/media/original.avi' );
$FFmpeg->transpose( 0 )->vflip()->grayScale()->vcodec('h264')->frameRate('30000/1001');
$FFmpeg->acodec( 'aac' )->audioBitrate( '192k' );
foreach( $options AS $option => $values )
{
	$FFmpeg->call( $option , $values );
}
$FFmpeg->output( '/var/media/new.mp4' , 'mp4' );
print($FFmpeg->command);
?>