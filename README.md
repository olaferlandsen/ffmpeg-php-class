# FFmpeg Class
A complete cross-platform class for using FFmpeg written in PHP 5.3+

## Requirements

* FFmpeg 0.5.12+
* PHP 5.3+
    * PCRE( Perl-Compatible )

## Examples

### Example #1: Input & output.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #2: Simple frame rate.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->frameRate( '30000/1001' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #3: Simple frame rate using method alias.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->i( '/var/media/original.mp4' )->r( '30000/1001' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #4: Rotate video.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->transpose( 2 )->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #5: Rotate video with alias "rotate".

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->rotate( 2 )->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #6: Force format.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->forceFormat( '3gp' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #7: Force format quickly.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' , '3gp' )->ready();
    ?>
```

### Example #8: Get command

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' )->command;
    ?>
```


### Example #9: Run command.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' )->ready();
    ?>
```


### Example #10: Gray Scale.

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->grayScale()->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #11: Set param.

```php
    <?php
    	$key = 'acodec';
    	$value = 'AAC';
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->set($key,$value)->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #12: Unset param.

```php
    <?php
    	$key = 'acodec';
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->unset($key)->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #13: Quick methods

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->sameq()->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #13: Flip ( V or H )

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->flip( 'v' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #13: hflip

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->hflip()->output( '/var/media/new.3gp' )->ready();
    ?>
```

### Example #14: vflip

```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->vflip()->output( '/var/media/new.3gp' )->ready();
    ?>
```


### Example #15: Complete

```php
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
```

```bash
/usr/local/bin/ffmpeg -y -vf transpose=0,vflip -pix_fmt gray -vcodec h264 -r 30000/1001 -acodec aac -ab 192k -t 99 -ss 0 -itsoffset 2 -f mp4 /var/media/new.mp4 /dev/null 2<&1
```

### Example #16: Clear

```php
	<?php
	$FFmpeg = new FFmpeg('/bin/ffmpeg','/var/media/original.mp4')->vflip()->output( '/var/media/new.3gp' )->clear()->input( '/var/www/file.3gp' );
	?>
```

### Example #17: Thumbs

```php
	<?php
	$size = '100x100';
	$start = 1;
	$frames = 10;
	
	$FFmpeg = new FFmpeg;
	$FFmpeg->input( '/var/www/video.mp4' )->thumb( $size , $start, $frames )->ready();
	?>
```

### Example #18: Image to video

```php
	<?php
	$FFmpeg = new FFmpeg;
	$FFmpeg->input( '/var/www/images/pref%04d.png' )->frameRate( '29,97' )->size( '1920x1080' )->force('image2');
	$FFmpeg->output( 'image2video.mp4' );
	$FFmpeg->ready();
	?>
```

### Example #19: Set the FFmpeg binary file on Windows

```php
	<?php
	$FFmpeg = new FFmpeg( "C:\ffmpeg\bin\ffmpeg.exe" );
	$FFmpeg->input( 'C:\xampp\input.mp4' )->output( 'output.3gp' );
	$FFmpeg->ready();
	?>
```

### Example #20: Set the FFmpeg binary file on Linux & Unix

```php
	<?php
	$FFmpeg = new FFmpeg( "/etc/bin/ffmpeg" );
	$FFmpeg->input( '/var/www/input.mp4' )->output( 'output.3gp' );
	$FFmpeg->ready();
	?>
```

### Example #21: Log level

```php
	<?php
	$FFmpeg = new FFmpeg;
	$FFmpeg->input( '/var/www/input.mp4' )->loglevel("debug")->output( 'output.3gp' );
	$FFmpeg->ready();
	?>
```

## Got more ideas? write us.

Need support? Write us, it's free! olaftriskel@gmail.com

## Want to donate or just give me a coffee?

* Use my Paypal account: olaftriskel@gmail.com
* [Donate a cofee via Paypal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CLJQ6GS4ZNLEG)

## Remember:

* This is an open source project and free.
* Share our repository.
* If possible, write a letter of recommendation.
* The support is free! Please contact us if you have questions or a problem.

## Author

* Author	:	Olaf Erlandsen
* Contact	:	olaftriskel@gmail.com <Olaf Erlandsen>
* Skype		:	olaferlandsen
* Version	:	0.1.3
* Date		:	11.18.2013( mm.dd.yyyy )
* License	:	http://opensource.org/licenses/gpl-license.php
* Home Page:	http://erlandsen.github.io/FFmpeg-PHP-Class/