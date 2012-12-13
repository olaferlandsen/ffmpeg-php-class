FFmpeg Class
------------
http://opensource.org/licenses/gpl-license.php

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