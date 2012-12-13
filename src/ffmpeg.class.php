<?php
/**
* FFmpeg PHP Class
* 
* @package		FFmpeg
* @version		0.0.1
* @license		http://opensource.org/licenses/gpl-license.php  GNU Public License
* @author		Olaf Erlandsen <olaftriskel@gmail.com>
*/
class FFmpeg
{
	private $as		=	array(
		'b'			=>	'bitrate',
		'r'			=>	'frameRate',
		'fs'		=>	'fileSizeLimit',
		'f'			=>	'forceFormat',
		'i'			=>	'input',
		's'			=>	'size',
		'ar'		=>	'audioSamplingFrequency',
		'acodec'	=>	'audioCodec',
		'vcodec'	=>	'videoCodec',
		'rotate'	=>	'transpose',
	);
	private $ffmpeg		=	'ffmpeg';
	private $options	=	array(
		'y'	=>	null,
	);
	public function __call( $method , $args )
	{
		if( array_key_exists( $method , $this->as ) )
		{
			return call_user_func_array( array( $this , $this->as[$method] ) , $args );
		}
	}
	public function __construct( $ffmpeg = null )
	{
		$this->ffmpeg( $ffmpeg );
	}
	/**
	* @param	string	$output			Output file path
	* @param	string	$forceFormat	Force format output
	* @return	object	Return self
	* @access	public
	*/
	public function output( $output , $forceFormat = null )
	{
		$this->forceFormat( $forceFormat );
		$options = array();
		foreach( $this->options AS $option => $values )
		{
			if( is_array( $values ) )
			{
				$items = array();
				foreach( $values AS $item => $val )
				{
					$items[] = $item."=".$val;
				}
				$options [] = "-".$option." ".join(' ',$items);
			}else{
				$options [] = "-".$option." ".$values;
			}
		}
		$this->command = $this->ffmpeg." ".join(' ',$options)." ".$output;
		return $this;
	}
	/**
	* @param	string	$forceFormat	Force format output
	* @return	object	Return self
	* @access	public
	*/
	public function forceFormat( $forceFormat )
	{
		if( !empty( $forceFormat ) )
		{
			$this->options['f'] = $forceFormat;
		}
		return $this;
	}
	/**
	* @param	string	$file	input file path
	* @return	object	Return self
	* @access	public
	*/
	public function input( $file )
	{
		if( file_exists( $file ) and is_file( $file ) )
		{
			if( is_readable( $file ) )
			{
				$this->options['i'] = $file;
			}
		}
		return $this;
	}
	/**
	* @param	string	$transpose	http://ffmpeg.org/ffmpeg.html#transpose
	* @return	object	Return self
	* @access	public
	*/
	public function transpose( $transpose = 0 )
	{
		if( !empty( $transpose ) AND is_numeric( $transpose ) AND intval( $transpose ) > 0 )
		{
			$this->options['vf']['transpose'] = $transpose;
		}
		return $this;
	}
	/**
	* @param	string	$aspect	sample aspect ratio
	* @return	object	Return self
	* @access	public
	*/
	public function aspect( $aspect )
	{
		$this->options[ 'aspect' ] = $aspect;
		return $this;
	}
	/**
	* @param	string	$b	set bitrate (in bits/s)
	* @return	object	Return self
	* @access	public
	*/
	public function bitrate( $b )
	{
		$this->options[ 'b' ] = $b;
		return $this;
	}
	/**
	* @param	string	$r	Set frame rate (Hz value, fraction or abbreviation).
	* @return	object	Return self
	* @access	public
	*/
	public function frameRate( $r )
	{
		if( preg_match( '/^([0-9]+\/[0-9]+)$/' , $r ) XOR is_numeric( $r ) )
		{
			$this->options['r'] = $r;
		}
		return $this;
	}
	/**
	* @param	string	$s	Set frame size.
	* @return	object	Return self
	* @access	public
	*/
	public function size( $s )
	{
		if( preg_match( '/^([0-9]+x[0-9]+)$/' , $s ) )
		{
			$this->options['s'] = $s;
		}
		return $this;
	}
	/**
	* When used as an input option (before "input"), seeks in this input file to position. When used as an output option (before an output filename), decodes but discards input until the timestamps reach position. This is slower, but more accurate.
	*
	* @param	string	$s	position may be either in seconds or in hh:mm:ss[.xxx] form.
	* @return	object	Return self
	* @access	public
	*/
	public function position( $ss )
	{
		$this->options['ss'] = $ss ;
		return $this;
	}
	/**
	* @param	string	$t	Stop writing the output after its duration reaches duration. duration may be a number in seconds, or in hh:mm:ss[.xxx] form.
	* @return	object	Return self
	* @access	public
	*/
	public function duration( $t )
	{
		$this->options['t'] = $t ;
		return $this;
	}
	/**
	* Set the input time offset in seconds. [-]hh:mm:ss[.xxx] syntax is also supported. The offset is added to the timestamps of the input files.
	*
	* @param	string	$t	Specifying a positive offset means that the corresponding streams are delayed by offset seconds.
	* @return	object	Return self
	* @access	public
	*/
	public function itsoffset( $itsoffset )
	{
		$this->options['itsoffset'] = $itsoffset ;
		return $this;
	}
	/**
	*	
	*/
	public function audioSamplingFrequency( $ar )
	{
		$this->options['ar'] = $ar;
		return $this;
	}
	/**
	*	
	*/
	public function audioBitrate( $ab )
	{
		$this->options['ab'] = $ab;
		return $this;
	}
	/**
	*	
	*/
	public function audioCodec( $acodec = 'copy' )
	{
		$this->options['acodec'] = $acodec;
		return $this;
	}
	/**
	*	
	*/
	public function audioChannels( $ac )
	{
		$this->options['ac'] = $ac;
		return $this;
	}
	/**
	*	
	*/
	public function audioQuality( $aq )
	{
		$this->options['aq'] = $a;
		return $this;
	}
	/**
	*	
	*/
	public function audioDisable()
	{
		$this->options['an'] = null;
		return $this;
	}
	/**
	*	
	*/
	public function videoCodec( $vcodec = 'copy' )
	{
		$this->options['vcodec'] = $vcodec;
	}
	/**
	*	
	*/
	public function videoDisable()
	{
		$this->options['vn'] = null;
		return $this;
	}
	/**
	*	
	*/
	public function overwrite()
	{
		$this->options['y'] = null;
		return $this;
	}
	/**
	*	
	*/
	public function fileSizeLimit( $fs )
	{
		$this->options['fs'] = $fs;
		return $this;
	}
	/**
	*	
	*/
	public function progress( $progress )
	{
		$this->options['progress'] = $progress;
		return $this;
	}
	/**
	*	
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
	*	
	*/
	public function ready(  )
	{
		return exec( $this->command );
	}
	/**
	*	
	*/
	public function ffmpeg( $ffmpeg )
	{
		if( !empty( $ffmpeg ) )
		{
			$this->ffmpeg = $ffmpeg;
		}
	}
	/**
	*	
	*/
	public function set( $key , $value )
	{
		if( !empty( $key ) )
		{
			if( is_array( $value ) OR !empty( $value ) or is_numeric( $value ) or is_null( $value ) )
			{
				$this->options[ $key ] = $value;
			}
		}
		return $this;
	}
}
?>