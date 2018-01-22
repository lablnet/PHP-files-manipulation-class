<?php
	/**
	 * This package can manipulate files and directories in several ways.
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link      https://github.com/Lablnet/PHP-files-manipulation-class
	 */
class Files
{		
		/**
		 * Getting server operaing system name.
		 */	
	private $ServerOS = PHP_OS;
		/**
		 * Create default directory outside of public
		 * Show dir path 
		 * @return string
		 */		
	public function DataDir(){
		global $MainDir;
		$settings = [
			'DataDir' => $MainDir['DataDir'],
			'subfolder' => $MainDir['subfolder'],
		];
		if(is_writable($settings['DataDir'])){
			if(!file_exists($settings['DataDir'].'/'.$settings['subfolder'].'/')){
				mkdir($settings['DataDir'].'/'.$settings['subfolder'].'/');
			}
			return $settings['DataDir'].'/'.$settings['subfolder'].'/';
		}else{
			return false;
		}
	}
		/**
		 * Create directory outside of public
		 *
		 * @param $name (string) string $name name of directory
		 * @return boolean
		 */		
	public function MkDir($name){
		if(!file_exists($this->DataDir().$name)){
			mkdir($this->DataDir().$name.'/',0755,true);
			return true;
		}else{
			return false;
		}
	}
		/**
		 * generate salts for files
		 * 
		 * @param string $length length of salts
		 * @return string
		 */			
	public function GenerateSalts($length){
		$somestrings = '0123456789abcdefghijklmnFGSGSGFGSVHVEHDSHVHVSVHDVGFDopqfgsfsfsfsfrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$stringlength = strlen($somestrings);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $somestrings[rand(0, $stringlength - 1)];
		}
		return $randomString;
	}	
		/**
		 * Change premission of file and folder
		 * @param $params (array) 
		 * 		 'source' => file or folder
		 *		 'premission' => premission set to be.		
		 * @return boolean
		 */			
	public function Premission($params){
		if($params){
			if(!empty($params['source']) and !empty($params['premission'])){
				chmod($this->DataDir().$params['source'], $params['premission']);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
		/**
		 * Copy files or folder 
		 * @param $params (array)
		 * $params['status'] files or dir
		 * $params['target'] => folder that file shoud copy 
		 * $params['files'] array of files one or multiple
		 * $params['dirs'] array of dir one or muktiple
		 * #issue folder not copying in windows
		 * @return boolean
		 */		
	public function CopyFilesAndFolder($params){
		if(is_array($params)){
			if($params['status'] === 'files'){
				if(!is_dir($this->DataDir().$params['target'].'/')){
					$this->MkDir($params['target'].'/');
				}
				foreach ($params['files'] as $file => $value) {
					if(file_exists($this->DataDir().$params['path'].'/'.$value)){
						copy($this->DataDir().$params['path'].'/'.$value, $this->DataDir().$params['target'].'/'.$value);
					}
				}
			}
			if($params['status'] === 'dir'){
				if(!is_dir($this->DataDir().$params['target'].'/')){
					$this->MkDir($params['target'].'/');
				}
				foreach ($params['dirs'] as $file => $from) {
					if(is_dir($this->DataDir().$value.'/')){
					if($this->ServerOS === 'WINNT' or $this->ServerOS ==='WIN32' or $this->ServerOS ==='Windows'){
								shell_exec("xcopy ". $this->DataDir().$from .' '. $this->DataDir().$params['to'].'/');
							}elseif($this->ServerOS === 'Linux' or $this->ServerOS ==='FreeBSD' or $this->ServerOS ==='OpenBSD'){
								shell_exec("cp -r ". $this->DataDir().$from .' '. $this->DataDir().$params['to'].'/');
							}elseif($this->ServerOS === 'Unix'){
								shell_exec("cp -r ". $this->DataDir().$from .' '. $this->DataDir().$params['to'].'/');
							}else{
								return "Sorry! Your operating system not supported copy command";
							}
					}
				}				
			}
		}else{
			return false;
		}
	}
		/**
		 * Delete the files or folder
		 * @param $params (array)
		 * $params['path'] string path
		 * $params['status'] => files and dir accpeted 
		 * $params['files'] array of files one or multiple
		 * $params['dir'] array of dir one or muktiple
		 *
		 * @return boolean
		 */		
	public function DelFilesAndFolders($params){
		if(is_array($params)){
			if($params['status'] === 'files'){
				foreach($params['files'] as $file=>$value){
					if(file_exists($this->DataDir().$params['path'].$value)){
						unlink($this->DataDir().$params['path'].$value);
					}else{
						return false;
					}
				}
				return true;
			}
			if($params['status'] === 'dir'){
				foreach($params['dir'] as $file=>$value){
					if(is_dir($this->DataDir().$params['path'].$value)){
						rmdir($this->DataDir().$params['path'].$value);
					}else{
						return false;
					}
				}
			}	
		}else{
			return false;
		}
	}	
		/**
			 * Move files from one directory to another
			 * 			 
			 * @param $params (array) 
			 * status required accpted files and dir
			 * in files case files => array('one.txt','two.txt','three.txt'); 
			 * to & from=> array is required provide full path in these to and from if select file form e.g F:\AndroidStudioProjects\AwesomeDictionary\.gradle\3.3\ you need add this in path then to add whatever want you move
			 * @return boolean
		 */		
	public function MovesFilesAndFolders($params){
			if(is_array($params)){
				if(isset($params['status']) and !empty($params['status'])){
					if($params['status'] === 'files'){
						if(!is_dir($params['to'])){
							if(!file_exists($params['to'])){
								$this->MkDir($params['to']);
							}
						}
						foreach($params['files'] as $file){
							rename($params['from'].'/'.$file,$params['to'].'/'.$file);
						}
					return true;	
				}elseif($params['status'] === 'dir'){
						if(!is_dir($params['to'])){
							if(!file_exists($params['to'])){
								$this->MkDir($params['to']);
							}	
						}
						foreach($params['from'] as $key => $from){
							if($this->ServerOS === 'WINNT' or $this->ServerOS ==='WIN32' or $this->ServerOS ==='Windows'){
								shell_exec("move ". $this->DataDir().$from .' '. $this->DataDir().$params['to'].'/');
							}elseif($this->ServerOS === 'Linux' or $this->ServerOS ==='FreeBSD' or $this->ServerOS ==='OpenBSD'){
								shell_exec("mv ". $this->DataDir().$from .' '. $this->DataDir().$params['to'].'/');
							}elseif($this->ServerOS === 'Unix'){
								shell_exec("mv ". $this->DataDir().$from .' '. $this->DataDir().$params['to'].'/');
							}else{
								return "Sorry! Your operating system not supported move command";
							}
						}
				}
			}
		}else{
			return false;
		}	
	}	
		/**
		 * Upload file
		 * @param $params (array)		
		 * $params string $params['file'] required file 
		 * $params string $params['target'] target dir sub dir of data folder
		 * $params string $params['filetype'] type e.g image,media etc
		 * errors possibles
		 * 2220 => extension not matched
		 * 222 => type not matched
		 *
		 * @return integar on fail fileName on success
		 */			
	public function FileUpload($params){
		if(is_array($params)){
			$exactName = basename($params['file']['name']);
			$fileTmp = $params['file']['tmp_name'];
			$fileSize = $params['file']['size'];
			$error = $params['file']['error'];
		    $type = $params['file']['type'];
			$ext = explode('.',$exactName);
			$ext = strtolower(end($ext));
			$newName = $this->GenerateSalts(30);
			$fileNewName = $newName.'.'.$ext;
			if($params['filetype'] === 'image'){
				$allowerd_ext = ['jpg','png','jpeg','gif','ico'];
			}elseif($params['filetype'] === 'zip'){
				$allowerd_ext = ['zip','tar','7zip','rar'];
			}elseif($params['filetype'] === 'docs'){
				$allowerd_ext = ['pdf','docs','docx'];
			}elseif($params['filetype'] === 'media'){
				$allowerd_ext = ['mp4','mp3','wav','3gp'];
			}else{
				// occur wrong skill of developers
				return $ext." File extension wrong";
			}
					$AccpetedTypes = [
									'application/msword',
									'application/vnd.openxmlformats-officedocu	ment.wordprocessingml.document',
									'image/gif',
									'image/jpeg',
									'image/jpeg',
									'audio/mpeg',
									'video/mp4',
									'application/pdf',
									'image/png',
									'application/zip',					'application/octet-stream'
					];
						if(in_array($type,$AccpetedTypes) === false){
							return $type." Not supported";
						}				
			if(in_array($ext,$allowerd_ext) === true){
				if($error === 0){
					if($fileSize <= 7992000000){
						if(!is_dir($this->DataDir().$params['target']) or !file_exists($this->DataDir().$params['target'])){
							$this->MkDir($params['target'].'/');
						}
						$fileRoot = $this->DataDir().$params['target'].'/'.$fileNewName;
						if(move_uploaded_file($fileTmp,$fileRoot)){
							return $fileNewName;
						}else{
							return "Something went wrong";
						}
						
					}else{
						return "File size exceeded the limits";
					}
				}else{
					return $error;			
			}
			}else{
				return $ext." this extension not alloewd";
			}
		}else{
			return false;
		}	
	}
		/**
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
		 */		
	public function FilesHandeling($params){
		if(is_array($params)){
				if($params['mods'] === 'readonly'){
					$mod = 'r';
				}elseif($params['mods'] === 'read+write'){
					$mod = 'r+';
				}elseif($params['mods'] === 'writeonly'){
					$mod = 'w';
				}elseif($params['mods'] === 'writeonlyoverride'){
					$mod = 'w+';
				}elseif($params['mods'] === 'writeonlynotoverride'){
					$mod = 'a';
				}elseif($params['mods'] === 'write+readnotoverride'){
					$mod = 'a+';
				}else{
					return false;
				}												
			$fopen = fopen($this->DataDir().$params['target'].'/'.$params['name'].'.'.$params['extension'], $mod);
			 fwrite($fopen, $params['text']);
			if($mod === 'r' or $mod === 'r+' or $mod === 'a+'){
				return fread($fopen, filesize($this->DataDir().$params['target'].'/'.$params['name'].'.'.$params['extension']));
			}elseif($mod === 'w' or $mod === 'w+' or $mod === 'a'){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}
