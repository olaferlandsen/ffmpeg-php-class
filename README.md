FFmpeg Class
------------
Author	:	Olaf Erlandsen

Contact	:	olaftriskel@gmail.com

Version	:	0.0.2

license	:	http://opensource.org/licenses/gpl-license.php


Example #1: Input & output.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #2: Simple frame rate.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->frameRate( '30000/1001' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #3: Simple frame rate using method alias.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->i( '/var/media/original.mp4' )->r( '30000/1001' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #4: Rotate video.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->transpose( 2 )->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #5: Rotate video with alias "rotate".
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->rotate( 2 )->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #6: Force format.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->forceFormat( '3gp' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #7: Force format quickly.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' , '3gp' )->ready();
    ?>
```

Example #8: Get command
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' )->command;
    ?>
```


Example #9: Run command.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->output( '/var/media/new.3gp' )->ready();
    ?>
```


Example #10: Gray Scale.
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->grayScale()->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #11: Set param.
------------
    PHP FILE
```php
    <?php
    	$key = 'acodec';
    	$value = 'AAC';
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->set($key,$value)->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #12: Unset param.
------------
    PHP FILE
```php
    <?php
    	$key = 'acodec';
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->unset($key)->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #13: Quick methods
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->sameq()->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #13: Flip ( V or H )
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->flip( 'v' )->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #13: hflip
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->hflip()->output( '/var/media/new.3gp' )->ready();
    ?>
```

Example #14: vflip
------------
    PHP FILE
```php
    <?php
    	$FFmpeg = new FFmpeg;
    	$FFmpeg->input( '/var/media/original.mp4' )->vflip()->output( '/var/media/new.3gp' )->ready();
    ?>
```


Example #14: Complete
------------
    PHP FILE
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

	Output
	
```bash
/usr/local/bin/ffmpeg -y -vf transpose=0,vflip -pix_fmt gray -vcodec h264 -r 30000/1001 -acodec aac -ab 192k -t 99 -ss 0 -itsoffset 2 -f mp4 /var/media/new.mp4 /dev/null 2<&1
```