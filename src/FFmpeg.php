<?php
/**
*   FFmpeg PHP Class
* 
*   With this class you can use FFmpeg with PHP without installing php-ffmpeg extension.
*
*   @package        FFmpeg
*   @version        0.1.4
*   @license        http://opensource.org/licenses/gpl-license.php  GNU Public License
*   @author         Olaf Erlandsen <olaftriskel@gmail.com>
*/
class FFmpeg
{
	/**
	*	
	*/
	private $STD = ' 2<&1';
	/**
	*	
	*/
	private $quickMethods = array(
		'sameq'
	);
	/**
	*	
	*/
	private $as		=	array(
		'b'			=>	'bitrate',
		'r'			=>	'frameRate',
		'fs'		=>	'fileSizeLimit',
		'f'			=>	'forceFormat',
		'force'		=>	'forceFormat',
		'i'			=>	'input',
		's'			=>	'size',
		'ar'		=>	'audioSamplingFrequency',
		'ab'		=>	'audioBitrate',
		'acodec'	=>	'audioCodec',
		'vcodec'	=>	'videoCodec',
		'std'		=>	'redirectOutput',
		'unset'		=>	'_unset',
		'number'	=>	'videoFrames',
		'vframes'	=>	'videoFrames',
		'y'			=>	'overwrite',
		'log'		=>	'logLevel',
	);
	/**
	*	
	*/
	private $FFmpegOptionsAS = array(
		'position'			=>	'ss',
		'duration'			=>	't',
		'filename'			=>	'i',
		'offset'			=>	'itsoffset',
		'time'				=>	'timestamp',
		'number'			=>	'vframes',
	);
	/**
	*	
	*/
	private $ffmpeg		=	'ffmpeg';
	/**
	*	
	*/
	private $options	=	array(
		'y'	=>	null,
	);
	/**
	*	
	*/
	private $fixForceFormat = array(
		"ogv"	=>	'ogg',
		"jpeg"	=>	'mjpeg',
		"jpg"	=>	'mjpeg',
		"flash"	=>	"flv",
	);
	public $command;
	/**
	*	
	*/
	public function __call( $method , $args )
	{
		if (array_key_exists($method, $this->as)) {
			return call_user_func_array(
			    array($this, $this->as[$method]),
			    ( is_array( $args ) ) ? $args : array( $args )
			);
		} elseif (in_array($method, $this->quickMethods)) {
			return call_user_func_array(
			    array($this, 'set'),
			    ( is_array( $args ) ) ? $args : array( $args )
			);
		} else {
			throw new Exception( 'The method "'. $method .'" doesnt exist' );
		}
	}
	/**
	*	
	*/
	public function call( $method , $args = array() )
	{
		if (method_exists ($this, $method)) {
			return call_user_func_array( array( $this , $method )  , 
				( is_array( $args ) ) ? $args : array( $args )
			);
		} else {
			throw new Exception( 'method doesnt exist' );
		}
		return $this;
	}
	/**
	*	
	*/
	public function __construct( $ffmpeg = null ,$input = false )
	{
		$this->ffmpeg( $ffmpeg );
		if (!empty($input)) {
			$this->input( $input );
		}
		return $this;
	}
	/**
	*   @param	string	$std
	*   @return	object
	*   @access	public
	*/
	public function redirectOutput( $std )
	{
		if (!empty($std)) {
			$this->STD = ' '.$std;
		}
		return $this;
	}
	/**
	*   @param	string	$output			Output file path
	*   @param	string	$forceFormat	Force format output
	*   @return	object
	*   @access	public
	*/
	public function output( $output = null , $forceFormat = null )
	{
		$this->forceFormat( $forceFormat );
		$options = array();
		foreach ($this->options AS $option => $values) {
			if (is_array($values)) {
				$items = array();
				foreach ($values AS $item => $val) {
					if (!is_null($val)) {
						if (is_array($val)) {
							print_r( $val );
							$val = join( ',' , $val );
						}
						$val = strval( $val );
						if (is_numeric( $item ) AND is_integer($item)) {
							$items[] = $val;
						} else {
							$items[] = $item."=". $val;
						}
					} else {
						$items[] = $item;
					}
				}
				$options [] = "-".$option." ".join(',',$items);
			} else {
				$options [] = "-".$option." ".strval($values);
			}
		}
		$this->command = $this->ffmpeg." ".join(' ',$options)." ".$output . $this->STD;
		return $this;
	}
	/**
	*   @param	string	$forceFormat	Force format output
	*   @return	object
	*   @access	public
	*/
	public function forceFormat( $forceFormat )
	{
		if (!empty($forceFormat)) {
			$forceFormat = strtolower( $forceFormat );
			if (array_key_exists( $forceFormat, $this->fixForceFormat)) {
				$forceFormat = $this->fixForceFormat[ $forceFormat ];
			}
			$this->set('f',$forceFormat,false);
		}
		return $this;
	}
	/**
	*   @param	string	$file	input file path
	*   @return	object
	*   @access	public
	*   @version	1.2	Fix by @propertunist
	*/
	public function input ($file)
	{
		if (file_exists($file) AND is_file($file)) {
			$this->set('i', '"'.$file.'"', false);
		} else {
			if (strstr($file, '%') !== false) {
				$this->set('i', '"'.$file.'"', false);
			} else {
				trigger_error ("File $file doesn't exist", E_USER_ERROR);
			}
		}
		return $this;
	}
	/**
	*   ATENTION!: This method is experimental
	*
	*   @param	string	$size
	*   @param	string	$start
	*   @param	string	$videoFrames
	*   @return	object
	*   @access	public
	*   @version	1.2	Fix by @propertunist 
	*/
	public function thumb ($size, $start, $videoFrames = 1)
	{
		//$input = false;
	        if (!is_numeric( $videoFrames ) OR $videoFrames <= 0) {
	        	$videoFrames = 1;
	        }
	        $this->audioDisable ();
	        $this->size ($size);
	        $this->position ($start);
	        $this->videoFrames ($videoFrames);
	        $this->frameRate (1);
	        return $this;
	}
	/**
	*   @return	object
	*   @access	public
	*/
	public function clear()
	{
		$this->options = array();
		return $this;
	}
	/**
	*   @param	string	$transpose	http://ffmpeg.org/ffmpeg.html#transpose
	*   @return	object
	*   @access	public
	*/
	public function transpose( $transpose = 0 )
	{
		if( is_numeric( $transpose )  )
		{
			$this->options['vf']['transpose'] = strval($transpose);
		}
		return $this;
	}
	/**
	*   @return	object
	*   @access	public
	*/
	public function vFlip()
	{
		$this->options['vf']['vflip'] = null;
		return $this;
	}
	/**
	*   @return	object
	*   @access	public
	*/
	public function hFlip()
	{
		$this->options['vf']['hflip'] = null;
		return $this;
	}
	/**
	*   @return     object
	*   @param      $flip	v=vertial OR h=horizontal
	*   @access     public
	*   @example    $ffmpeg->flip('v'); 
	*/
	public function flip( $flip )
	{
		if( !empty( $flip ) )
		{
			$flip = strtolower( $flip );
			if( $flip == 'v' )
			{
				return $this->vFlip();
			}
			else if( $flip == 'h' )
			{
				$this->hFlip();
			}
		}
		return false;
	}
	/**
	*   @param	string	$aspect	sample aspect ratio
	*   @return	object
	*   @access	public
	*/
	public function aspect( $aspect )
	{
		$this->set('aspect',$aspect,false);
	}
	/**
	*   @param	string	$b	set bitrate (in bits/s)
	*   @return	object
	*   @access	public
	*   @example    $ffmpeg->bitrate('3000/1000');
	
	*/
	public function bitrate( $b )
	{
		return $this->set('b',$b,false);
	}
	/**
	*   @param	string	$r	Set frame rate (Hz value, fraction or abbreviation).
	*   @return	object
	*   @access	public
	*/
	public function frameRate( $r )
	{
		if( !empty( $r ) AND preg_match( '/^([0-9]+\/[0-9]+)$/' , $r ) XOR is_numeric( $r ) )
		{
			$this->set('r',$r,false);
		}
		return $this;
	}
	/**
	*   @param	string	$s	Set frame size.
	*   @return	object
	*   @access	public
	*/
	public function size( $s )
	{
		if (!empty($s) AND preg_match( '/^([0-9]+x[0-9]+)$/', $s)) {
			$this->set('s',$s,false);
		}
		return $this;
	}
	/**
	* When used as an input option (before "input"), seeks in this input file to position. When used as an output option (before an output filename), decodes but discards input until the timestamps reach position. This is slower, but more accurate.
	*
	*   @param	string	$s	position may be either in seconds or in hh:mm:ss[.xxx] form.
	*   @return	object
	*   @access	public
	*/
	public function position( $ss )
	{
		return $this->set('ss',$ss,false);
	}
	/**
	*   @param	string	$t	Stop writing the output after its duration reaches duration. duration may be a number in seconds, or in hh:mm:ss[.xxx] form.
	*   @return	object
	*   @access	public
	*/
	public function duration( $t )
	{
		return $this->set('t',$t,false);
	}
	/**
	* Set the input time offset in seconds. [-]hh:mm:ss[.xxx] syntax is also supported. The offset is added to the timestamps of the input files.
	*
	*   @param	string	$t	Specifying a positive offset means that the corresponding streams are delayed by offset seconds.
	*   @return	object
	*   @access	public
	*/
	public function itsoffset( $itsoffset )
	{
		return $this->set('itsoffset',$itsoffset,false);
	}
	/**
	*	
	*/
	public function audioSamplingFrequency( $ar )
	{
		return $this->set('ar',$ar,false);
	}
	/**
	*	
	*/
	public function audioBitrate( $ab )
	{
		return $this->set('ab', $ab , false );
	}
	/**
	*	
	*/
	public function audioCodec( $acodec = 'copy' )
	{
		return $this->set('acodec',$acodec,false);
	}
	/**
	*	
	*/
	public function audioChannels( $ac )
	{
		$this->set('ac',$ac,false);
	}
	/**
	*	
	*/
	public function audioQuality( $aq )
	{
		return $this->set('aq', $a , false );
	}
	/**
	*	
	*/
	public function audioDisable()
	{
		return $this->set('an',null,false);
	}
	/**
	*   @param	string	$number
	*   @return	object
	*   @access	public
	*/
	public function videoFrames( $number )
	{
		return $this->set( 'vframes' , $number );
	}
	/**
	*	@param string	$vcodec
	*	@return object Self
	*/
	public function videoCodec( $vcodec = 'copy' )
	{
		return $this->set('vcodec' , $vcodec );
	}
	/**
	*	@return object Self
	*/
	public function videoDisable()
	{
		return $this->set('vn',null,false);
	}
	/**
	*	@return object Self
	*/
	public function overwrite()
	{
		return $this->set('y',null,false);
	}
	/**
	*	@param string	$fs
	*	@return object Self
	*/
	public function fileSizeLimit( $fs )
	{
		return $this->set('fs' , $fs , false );
	}
	/**
	*	@param string	$progress
	*	@return object Self
	*/
	public function progress( $progress )
	{
		return $this->set('progress',$progress);
	}
	/**
	*	@param integer	$pass
	*	@return object Self
	*/
	public function pass( $pass )
	{
		if( is_numeric( $pass ) )
		{
			$pass = intval( $pass );
			if( $pass == 1 OR $pass == 2 )
			{
				$this->options['pass'] = $pass;
			}
		}
		return $this;
	}
	/**
	*   @return	object
	*   @param	string	$append
	*   @access	public
	*/
	public function ready( $append = null )
	{
		/**
		*	Check if command is empty
		*/
		if( empty( $this->command ) )
		{
			$this->output();
		}
		if(empty( $this->command ))
		{
			trigger_error("Cannot execute a blank command",E_USER_ERROR);
			return false;
		}else{
			return exec( $this->command . $append );
		}
	}
	/**
	*   @return	object
	*   @param	string	ffmpeg
	*   @access	public
	*/
	public function ffmpeg( $ffmpeg )
	{
		if (!empty( $ffmpeg)) {
			$this->ffmpeg = $ffmpeg;
		}
	}
	/**
	*	@param string	$key
	*	@param string	$value
	*	@param boolen	$append
	*	@return object Self
	*/
	public function set( $key , $value = null , $append = false )
	{
		$key = preg_replace( '/^(\-+)/' , '' , $key );
		if( !empty( $key ) )
		{
			if( array_key_exists( $key , $this->FFmpegOptionsAS ) )
			{
				$key = $this->FFmpegOptionsAS[ $key ];
			}
			if( $append === false )
			{
				$this->options[ $key ] = $value;
			}else{
				if( !array_key_exists( $key , $this->options )  )
				{
					$this->options[ $key ] = array($value);
				}else if( !is_array( $this->options[ $key ] ) )
				{	
					$this->options[ $key ] = array($this->options[ $key ],$value);
				}else{
					$this->options[ $key ][] = $value;
				}
			}
		}
		return $this;
	}
	/**
	*	@param string	$key
	*	@return object Self
	*/
	public function _unset( $key )
	{
		if( array_key_exists( $key , $this->options ) )
		{
			unset( $this->options[ $key ] ) ;
		}
		return $this;
	}
	/**
	*	@return object Self
	*	@access	public
	*/
	public function grayScale( )
	{
		return $this->set('pix_fmt','gray');
	}
	
	/**
	*   @param	string	$level
	*   @return	object
	*   @access	public
	*/
	public function logLevel( $level = "verbose" )
	{
		$level = strtolower( $level );
		if( in_array( $level , array("quiet","panic","fatal","error","warning","info","verbose","debug") ) )
		{
			return $this->set('loglevel',$level );
		}else{
			trigger_error(  "The option does not valid in loglevel" );
		}
	}
}