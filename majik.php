<?php
	class MajikBox extends Imagick {
		static $filters;

		function __construct() {
			
		}

		static function add($name, iMajikEffect $effect) {
			self::$filters[$name] = $effect;
		}

		function __call($name,$arguments) {
			self::$filters[$name]->setHost($this);
			return call_user_func_array( array(self::$filters[$name],'process'), $arguments);
		}
		
		function loadEffects($directory) {
			$b = glob($directory."/*.php");
			foreach($b as $inc) {
				include_once($inc);
			}
		}
	}


	interface iMajikEffect {
		function process(Imagick $target);
	}

	class MajikEffect implements iMajikEffect {
		var $host;

		function setHost(MajikBox $host) {
			$this->host = $host;
		}	

		function process(Imagick $target) {
		}
	}

?>
