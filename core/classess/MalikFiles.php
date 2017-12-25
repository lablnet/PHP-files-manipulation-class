<?php
		/**
		 * @author    Malik Umer Farooq<lablnet01@gmail.com>
		 * @copyright MIT
		 */
class Files
{		
		/**
		 * Getting server operaing system name.
		 */	
	private $MalikServerOS = PHP_OS;
		/**
		 * Create default directory outside of public
		 * Show dir path 
		 * @return string
		 */		
	public function MalikDataDir(){
		global $Malik;
		$settings = [
			'MalikDataDir' => $Malik['MalikDataDir'],
			'subfolder' => $Malik['subfolder'],
		];
		if(is_writable($settings['MalikDataDir'])){
			if(!file_exists($settings['MalikDataDir'].'/'.$settings['subfolder'].'/')){
				mkdir($settings['MalikDataDir'].'/'.$settings['subfolder'].'/');
			}
			return $settings['MalikDataDir'].'/'.$settings['subfolder'].'/';
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
	public function MalikMkDir($name){
		if(!file_exists($this->MalikDataDir().$name)){
			mkdir($this->MalikDataDir().$name.'/',0755,true);
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
	public function MalikGenerateSalts($length){
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
	public function MalikPremission($params){
		if($params){
			if(!empty($params['source']) and !empty($params['premission'])){
				chmod($this->MalikDataDir().$params['source'], $params['premission']);
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
	public function MalikCopyFilesAndFolder($params){
		if(is_array($params)){
			if($params['status'] === 'files'){
				if(!is_dir($this->MalikDataDir().$params['target'].'/')){
					$this->MalikMkDir($params['target'].'/');
				}
				foreach ($params['files'] as $file => $value) {
					if(file_exists($this->MalikDataDir().$params['path'].'/'.$value)){
						copy($this->MalikDataDir().$params['path'].'/'.$value, $this->MalikDataDir().$params['target'].'/'.$value);
					}
				}
			}
			if($params['status'] === 'dir'){
				if(!is_dir($this->MalikDataDir().$params['target'].'/')){
					$this->MalikMkDir($params['target'].'/');
				}
				foreach ($params['dirs'] as $file => $from) {
					if(is_dir($this->MalikDataDir().$value.'/')){
					if($this->MalikServerOS === 'WINNT' or $this->MalikServerOS ==='WIN32' or $this->MalikServerOS ==='Windows'){
								shell_exec("xcopy ". $this->MalikDataDir().$from .' '. $this->MalikDataDir().$params['to'].'/');
							}elseif($this->MalikServerOS === 'Linux' or $this->MalikServerOS ==='FreeBSD' or $this->MalikServerOS ==='OpenBSD'){
								shell_exec("cp -r ". $this->MalikDataDir().$from .' '. $this->MalikDataDir().$params['to'].'/');
							}elseif($this->MalikServerOS === 'Unix'){
								shell_exec("cp -r ". $this->MalikDataDir().$from .' '. $this->MalikDataDir().$params['to'].'/');
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
	public function MalikDelFilesAndFolders($params){
		if(is_array($params)){
			if($params['status'] === 'files'){
				foreach($params['files'] as $file=>$value){
					if(file_exists($this->MalikDataDir().$params['path'].$value)){
						unlink($this->MalikDataDir().$params['path'].$value);
					}else{
						return false;
					}
				}
				return true;
			}
			if($params['status'] === 'dir'){
				foreach($params['dir'] as $file=>$value){
					if(is_dir($this->MalikDataDir().$params['path'].$value)){
						rmdir($this->MalikDataDir().$params['path'].$value);
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
	public function MalikMovesFilesAndFolders($params){
			if(is_array($params)){
				if(isset($params['status']) and !empty($params['status'])){
					if($params['status'] === 'files'){
						if(!is_dir($params['to'])){
							if(!file_exists($params['to'])){
								$this->MalikMkDir($params['to']);
							}
						}
						foreach($params['files'] as $file){
							rename($params['from'].'/'.$file,$params['to'].'/'.$file);
						}
					return true;	
				}elseif($params['status'] === 'dir'){
						if(!is_dir($params['to'])){
							if(!file_exists($params['to'])){
								$this->MalikMkDir($params['to']);
							}	
						}
						foreach($params['from'] as $key => $from){
							if($this->MalikServerOS === 'WINNT' or $this->MalikServerOS ==='WIN32' or $this->MalikServerOS ==='Windows'){
								shell_exec("move ". $this->MalikDataDir().$from .' '. $this->MalikDataDir().$params['to'].'/');
							}elseif($this->MalikServerOS === 'Linux' or $this->MalikServerOS ==='FreeBSD' or $this->MalikServerOS ==='OpenBSD'){
								shell_exec("mv ". $this->MalikDataDir().$from .' '. $this->MalikDataDir().$params['to'].'/');
							}elseif($this->MalikServerOS === 'Unix'){
								shell_exec("mv ". $this->MalikDataDir().$from .' '. $this->MalikDataDir().$params['to'].'/');
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
	public function MalikFileUpload($params){
		if(is_array($params)){
			$exactName = basename($params['file']['name']);
			$fileTmp = $params['file']['tmp_name'];
			$fileSize = $params['file']['size'];
			$error = $params['file']['error'];
		    $type = $params['file']['type'];
			$ext = explode('.',$exactName);
			$ext = strtolower(end($ext));
			$newName = $this->MalikGenerateSalts(30);
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
						if(!is_dir($this->MalikDataDir().$params['target']) or !file_exists($this->MalikDataDir().$params['target'])){
							$this->MalikMkDir($params['target'].'/');
						}
						$fileRoot = $this->MalikDataDir().$params['target'].'/'.$fileNewName;
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
	public function MalikFilesHandeling($params){
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
			$fopen = fopen($this->MalikDataDir().$params['target'].'/'.$params['name'].'.'.$params['extension'], $mod);
			 fwrite($fopen, $params['text']);
			if($mod === 'r' or $mod === 'r+' or $mod === 'a+'){
				return fread($fopen, filesize($this->MalikDataDir().$params['target'].'/'.$params['name'].'.'.$params['extension']));
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
