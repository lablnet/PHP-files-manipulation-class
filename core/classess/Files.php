<?php
	/**
	 * This package can manipulate files and directories in several ways.
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link      https://github.com/Lablnet/PHP-files-manipulation-class
	 */
	 

class Files {		
	
	//Declare Vars	
	
	//Getting server operating system name. //$this->ServerOS
	private $ServerOS = PHP_OS; 
	// For Usable Chars In $this->GenerateSalts Method //$this->chars
	private static $chars = array_merge(range(0,9), range('a', 'z'),range('A', 'Z')); 
	//File Upload Max Size //$this->fupmaxs
	private $fupmaxs = 7992000000; 
	//Class Error Codes //$this->cecodes[''] 
	private cecodes = array (
		'No_Support' => '[Error]: File Type Not Supported ',
		'Cant_Create' => '[Error]: Can\'t Create ',
		'No_Support_OS' => '[Error]: Sorry! Your Operating System Does Not Support The Command ',
		'Size_Limit' => '[Error:]File Size Exceeded The PreSet Limit ',
		'No_Upload' => '[Error]: Error Uploading File '
	);
	
	
	//Method __Construct
	/*************************************************************
		* Create default directory outside of public
		* Show dir path 
		* @return string
	*************************************************************/
	public function __construct(){
		
		//If our main directory exists & is writable
		if( file_exists( DATA_DIR ) && is_writable( DATA_DIR ) ){
			
			//Check if our sub directory was already created
			if( !file_exists( DATA_DIR.SUB_FOLDER.'/' ) ){
				
				//if not create our sub directory
				if( !mkdir( DATA_DIR.SUB_FOLDER.'/' )){
					
					//if sub directory creation not possible 
					trigger_error( $this->cecodes['Cant_Create']. "Sub Directory ((".SUB_FOLDER.")) In ".DATA_DIR );
					
				} else {
					
					//if it can be created then return the full path to the sub directory
					$this->fullDirPath =  DATA_DIR.SUB_FOLDER.'/';
					return $this->fullDirPath;
					
				}
				
			} else {
				
				//if it does exist then return the full path to the sub directory
				$this->fullDirPath =  DATA_DIR.SUB_FOLDER.'/';
				return $this->fullDirPath;
				
			}
			
		}else{
			
			//if our main directory doesn\'t exist then create our main directory
			if( !mkdir( DATA_DIR )){
					
				//if main directory creation not possible 
				trigger_error( $this->cecodes['Cant_Create']. "Main Directory ( ( ".DATA_DIR." ) ) On Host ".php_uname('n') );
					
			} else {
					
				//if it can be created then return back to the __construct
				return __construct();
					
			}
				
		}
		
	} // end method __construct
	
	
	//Method MkDirs	 
	/*************************************************************
		* Create directory outside of public
		*
		* @param $name (string) string $name name of directory
		* @return boolean
	*************************************************************/
	public function MkDirs( $name ){
		
		//if file doesnt exist
		if( !file_exists( $this->fullDirPath.$name ) ){
			
			//create it //also verify that it was created
			if( mkdir( $this->fullDirPath.$name.'/',0755,true ) ){
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		}else{
			
			return false;
			
		}
	} //end method
	
	
	//Method GenerateSalts
	/*************************************************************
		* generate salts for files
		* 
		* @param string $length length of salts
		* @return string
	*************************************************************/
	public function GenerateSalts( $length ){
		
		$stringlength = count( $this->chars  ); //Used Count because its array now
		
		$randomString = '';
		
		for ( $i = 0; $i < $length; $i++ ) {
			
			$randomString .= $this->chars[rand( 0, $stringlength - 1 )];
			
		}
		
		return $randomString;
		
	} //end method
	
	
	//Method Permission		
	/*************************************************************
		* Change premission of file and folder
		* @param $params (array) 
		* 		 'source' => file or folder
		*		 'premission' => premission set to be.		
		* @return boolean
	*************************************************************/
	public function Permission( $params ){
		
		if( $params ){
			
			if( !empty( $params['source'] ) and !empty( $params['Permission'] ) ){
				
				//verify chmod
				if( chmod( $this->fullDirPath.$params['source'], $params['Permission'] ) ){
				
					return true;
					
				} else{
					
					return false;
					
				}
				
			}else{
				
				return false;
				
			}
			
		}else{
			
			return false;
			
		}
	} //end method
	
	
	//Method CopyFilesAndFolder
	/*************************************************************
		* Copy files or folder 
		* @param $params (array)
		* $params['status'] files or dir
		* $params['target'] => folder that file shoud copy 
		* $params['files'] array of files one or multiple
		* $params['dirs'] array of dir one or muktiple
		* #issue folder not copying in windows
		* @return boolean
	*************************************************************/
	public function CopyFilesAndFolder( $params ){
		
		if( is_array( $params ) ){
			
			if( $params['status'] === 'files' ){
				
				if( !is_dir( $this->fullDirPath.$params['target'].'/' ) ){
					
					$this->MkDirs( $params['target'].'/' );
					
				}
				
				foreach ( $params['files'] as $file => $value ) {
					
					if( file_exists( $this->fullDirPath.$params['path'].'/'.$value ) ){
						
						copy( $this->fullDirPath.$params['path'].'/'.$value, $this->fullDirPath.$params['target'].'/'.$value );
						
					}
					
				}
				
			}
			
			if( $params['status'] === 'dir' ){
				
				if( !is_dir( $this->fullDirPath.$params['target'].'/' ) ){
					
					$this->MkDirs( $params['target'].'/' );
					
				}
				
				foreach ( $params['dirs'] as $file => $from ) {
					
					if( is_dir( $this->fullDirPath.$value.'/' ) ){
						
						if( $this->ServerOS === 'WINNT' or $this->ServerOS ==='WIN32' or $this->ServerOS ==='Windows' ){
								
							shell_exec( "xcopy ". $this->fullDirPath.$from .' '. $this->fullDirPath.$params['to'].'/' );
						
						}elseif( $this->ServerOS === 'Linux' or $this->ServerOS ==='FreeBSD' or $this->ServerOS ==='OpenBSD' ){
								
							shell_exec( "cp -r ". $this->fullDirPath.$from .' '. $this->fullDirPath.$params['to'].'/' );
						
						}elseif( $this->ServerOS === 'Unix' ){
								
							shell_exec( "cp -r ". $this->fullDirPath.$from .' '. $this->fullDirPath.$params['to'].'/' );
						
						}else{
							
							return $this->cecodes['No_Support_OS']."<b>COPY</b>";
						
						}
					}
				}				
			}
		}else{
			
			return false;
		
		}
	} //end method
	
	
	//Method DelFilesAndFolders
	/*************************************************************
		* Delete the files or folder
		* @param $params (array)
		* $params['path'] string path
		* $params['status'] => files and dir accpeted 
		* $params['files'] array of files one or multiple
		* $params['dir'] array of dir one or muktiple
		*
		* @return boolean
	*************************************************************/
	public function DelFilesAndFolders( $params ){
		
		if( is_array( $params ) ){
			
			if( $params['status'] === 'files' ){
				
				foreach( $params['files'] as $file=>$value ){
					
					if( file_exists( $this->fullDirPath.$params['path'].$value ) ){
						
						unlink( $this->fullDirPath.$params['path'].$value );
						
					}else{
						
						return false;
						
					}
				}
				return true;
				
			}
			
			if( $params['status'] === 'dir' ){
				
				foreach( $params['dir'] as $file=>$value ){
					
					if( is_dir( $this->fullDirPath.$params['path'].$value ) ){
						
						rmdir( $this->fullDirPath.$params['path'].$value );
						
					}else{
						
						return false;
						
					}
					
				}
				
			}	
			
		}else{
			
			return false;
			
		}
		
	} //end method
	
	
	//Method MovesFilesAndFolders
	/*************************************************************
		* Move files from one directory to another
		* 			 
		* @param $params (array) 
		* status required accpted files and dir
		* in files case files => array('one.txt','two.txt','three.txt'); 
		* to & from=> array is required provide full path in these to and from if select file form e.g F:\AndroidStudioProjects\AwesomeDictionary\.gradle\3.3\ you need add this in path then to add whatever want you move
		* @return boolean
	*************************************************************/
	public function MovesFilesAndFolders( $params ){
		
			if( is_array( $params ) ){
				
				if( isset( $params['status'] ) and !empty( $params['status'] ) ){
					
					if( $params['status'] === 'files'  ){
						
						if(  !is_dir(  $params['to']  )  ){
							
							if(  !file_exists(  $params['to']  )  ){
								
								$this->MkDirs( $params['to'] );
								
							}
						}
						foreach( $params['files'] as $file ){
							
							rename( $params['from'].'/'.$file,$params['to'].'/'.$file );
							
						}
					return true;	
					
				}elseif( $params['status'] === 'dir' ){
					
					if( !is_dir( $params['to'] ) ){
							
						if( !file_exists( $params['to'] ) ){
								
							$this->MkDirs( $params['to'] );
								
						}
						
					} //end if
					
					foreach( $params['from'] as $key => $from ){
							
						if( $this->ServerOS === 'WINNT' or $this->ServerOS ==='WIN32' or $this->ServerOS ==='Windows' ){
								
							shell_exec( "move ". $this->fullDirPath.$from .' '. $this->fullDirPath.$params['to'].'/' );
								
						}elseif( $this->ServerOS === 'Linux' or $this->ServerOS ==='FreeBSD' or $this->ServerOS ==='OpenBSD' ){
								
							shell_exec( "mv ". $this->fullDirPath.$from .' '. $this->fullDirPath.$params['to'].'/' );
								
						}elseif( $this->ServerOS === 'Unix' ){
								
							shell_exec( "mv ". $this->fullDirPath.$from .' '. $this->fullDirPath.$params['to'].'/' );
								
						}else{
								
							return $this->cecodes['No_Support_OS']."<b>MOVE</b>";
								
						}
							
					} // end foreach
						
				}
			}
			
		}else{
			
			return false;
			
		}	
		
	} //end method
	

	//Method FileUpload
	/*************************************************************
		* Upload file
		* @param $params (array)		
		* $params string $params['file'] required file 
		* $params string $params['target'] target dir sub dir of data folder
		* $params string $params['filetype'] type e.g image,media etc
		* errors possibles
		* 2220 => extension not matched
		* 222 => type not matched
		*
		* @return integer on fail fileName on success
	*************************************************************/
	public function FileUpload( $params ){
		
		if( is_array( $params ) ){
			
			$exactName = basename( $params['file']['name'] ); // pathinfo( $params['file']['name'], PATHINFO_BASENAME );
			
			$fileTmp = $params['file']['tmp_name'];
			
			$fileSize = $params['file']['size'];
			
			$error = $params['file']['error'];
			
		    $type = $params['file']['type'];
			
			$ext =  pathinfo( $params['file']['name'], PATHINFO_EXTENSION );
			
			$newName = $this->GenerateSalts( 30 );
			
			$fileNewName = $newName.'.'.$ext;
			
			switch( $params['filetype'] ){
				
				case 'image':
				
					$allowerd_ext = ['jpg','png','jpeg','gif','ico'];
					
					break;
					
				case 'zip':
				
					$allowerd_ext = ['zip','tar','7zip','rar'];
					
					break;
					
				case 'docs':
				
					$allowerd_ext = ['pdf','docs','docx'];
					
					break;
					
				case 'media':
				
					$allowerd_ext = ['mp4','mp3','wav','3gp'];
					
					break;
					
				default:
				
					// occur wrong skill of developers
					return $this->cecodes['No_Support']." <b>{$ext}</b>";
					
			} //end switch
			
					$AccpetedTypes = [
									'application/msword',
									'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
									'image/gif',
									'image/jpeg',
									'image/jpeg',
									'audio/mpeg',
									'video/mp4',
									'application/pdf',
									'image/png',
									'application/zip',			
									'application/octet-stream'
					];
						if( in_array( $type, $AccpetedTypes ) === false ){
							
							return $this->cecodes['No_Support']." <b>{$type}</b>";
							
						}				
			if( in_array( $ext,$allowerd_ext ) === true ){
				
				if( $error === 0 ){
					
					if( $fileSize <= $this->fupmaxs ){
						
						if( !is_dir( $this->fullDirPath.$params['target'] ) or !file_exists( $this->fullDirPath.$params['target'] ) ){
							
							$this->MkDirs( $params['target'].'/' );
							
						}
						
						$fileRoot = $this->fullDirPath.$params['target'].'/'.$fileNewName;
						
						if( move_uploaded_file( $fileTmp,$fileRoot ) ){
							
							return $fileNewName;
							
						}else{
							
							return $this->cecodes['No_Upload']. "{$fileRoot}";    
							
						}
						
					}else{ 
						
						return $this->cecodes['Size_Limit'];
						
					}
				}else{
					
					return $error;
					
			}
			
			}else{
				
				return $this->cecodes['No_Support']." <b>{$ext}</b>";
				
			}
			
		}else{
			
			return false;
			
		}
		
	} //end method
	
	
	//Method FilesHandeling	
	/*************************************************************
		* Handeling files
		*		
		* @params string $params['mods'] Support six different mods
		*	'readonly' => 
		*	'read+write' => 
		*	'writeonly' => 
		*	'writeonlyoverride' => 
		*	'writeonlynotoverride' => 
		*	'write+readnotoverride' => 
		* @params string $params['target'] target dir sub dir of data folder
		* @params string $params['name'] Name of file
		* @params string $params['extension'] Extension of file
		* @params text $params['text'] text or data that write in file	 
		* @return integar on fail fileName on success
	*************************************************************/
	public function FilesHandeling( $params ){
		
		if( is_array( $params ) ){
			
			switch ( $params['mods'] ){
				
				case 'readonly':
				
					$mod = 'r';
					
					break;
				
				case 'read+write':
				
					$mod = 'r+';
					
					break;
					
				case 'writeonly':
				
					$mod = 'w';
					
					break;
				
				case 'writeonlyoverride':
				
					$mod = 'w+';
					
					break;
					
				case 'writeonlynotoverride':
				
					$mod = 'a';
					
					break;
					
				case 'write+readnotoverride':

					$mod = 'a+';
				
					break;
					
				default:
				
					return false;
					
			} //end switch
				
			$fopen = fopen( $this->fullDirPath.$params['target'].'/'.$params['name'].'.'.$params['extension'], $mod );
			
			fwrite( $fopen, $params['text'] );
			
			switch ( $mod ){
				
				case 'r':
				case 'r+': 
				case 'a+':
				
					return fread( $fopen, filesize( $this->fullDirPath.$params['target'].'/'.$params['name'].'.'.$params['extension'] ) );
					
					break;
					
				case 'w':
				case 'w+':
				case 'a':

					return true;
					
					break;
					
				default:
				
				return false;
				
			} //end switch
			
		}else{
			
			return false;
			
		}
		
	} //end method
	
} //end class
