<?php

class Blue_Crimson {

	const DEFAULT_DIR_PERMISSION = 777;

	protected $allow    = 'text/css';

	# Backup Origin File 
	protected $backup   = 'backup/';

	# Saving File
	protected $result   = 'result/';

	# Max Of Size file CSS
	protected $max_size = 800000;

	# Getting File / Force Dowload
	function getFile($name){

		header('Content-Type: text/css');
		header("Content-disposition: attachment; filename='".$name."'");
		header('Content-Length: ' . filesize($this->result.$name));
		ob_clean();
		flush();
		readfile($this->result.$name);
	}

	# backup
	function backup($file,$tmp,$status){

		$file_name  = explode(".",$file);
		$get_ext    = end($file_name);
		$file  		= $status.'__'.$file_name[0].'.BAK.'.$get_ext;
		
		$backup = copy($tmp,$this->backup.$file);
		return $backup;

	}

	# Extract
	function Extract($file,$action = "uncompress"){
		$name = $file['name'];
		$type = $file['type'];
		$size = $file['size'];
		$tmp  = $file['tmp_name'];


		if($type != $this->allow ){
			print "Sorry Your File Not CSS";
		}else if($size >= $this->max_size){

			print "Sorry, this file is very large";

		}else{

			if($action != "uncompress"){

				$this->Compress($tmp,$name);

			}else{

				$this->Uncompress($tmp,$name);
			}

				$this->backup($name,$tmp,$action);
		}

	}

	# Uncompress
	function Uncompress($file,$name){

		$script = file_get_contents($file); 

		$split  = explode('{', $script);
		$new    ='';

		for ($i=0; $i < count($split) ; $i++) { 
			$new .= $split[$i];
			$new .= "{". PHP_EOL;
		}

		$split_t=explode(';', $new);

		$new = '';

		for($i=0;$i < count($split_t)-1;$i++){
			$new .= $split_t[$i];
			$new .= ';'. PHP_EOL;
		}

		$split_r = explode('}', $new);

		$new ='';
		for ($i=0; $i < count($split_r); $i++) { 
			
			$new .= $split_r[$i];
			$new .= PHP_EOL.'}'. PHP_EOL;

		}

		$this->Render($name,$new);

	}


	# Compress
	function Compress($file,$name){
		$script = file_get_contents($file); 
		$script = preg_replace('/[\r|\n|\t]+/', "" , $script);
		#$script = preg_replace("/^\s*\/\*[^(\*\/)]*\*\//m", "" , $script);
		$script = str_replace(PHP_EOL,'', $script);

		$this->Render($name,$script);

	}

	# Render File
	function Render($name,$content){
		$create = fopen($this->result.$name, 'w+');
		$write  = fwrite($create, $content);
		fclose($create); 
		
		$this->getFile($name);
	}

}
