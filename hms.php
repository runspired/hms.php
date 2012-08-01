<?php
/*
 Class hms by James Thoburn http://jthoburn.com
 
 hms is a PHP class designed for use in applications that
 handle times and paces in an athletic context.

 e.g. where times and paces are often displayed in some
 variation of hh:mm:ss.000 format.
 
 There is no specific tolerance defined, so your time will retain
 as much precision as you define it with.
 
 */
class hms {
		//no vars are public as updates need to be value controlled
		private $h = 0;
		private $m = 0;
		private $s = 0;
		private $format = '';
		
		//accepts up to three parameters
		//h,m,s  m,s or s
		public function __construct() {
			$n = func_num_args();
			switch($n) {
				case 3 :
					$this->hours(func_get_arg(0));
					$this->minutes(func_get_arg(1));
					$this->seconds(func_get_arg(2));
					break;
				case 2 :
					$this->hours(0);
					$this->minutes(func_get_arg(0));
					$this->seconds(func_get_arg(1));
					break;
				case 1 :
					$this->hours(0);
					$this->minutes(0);
					$this->seconds(func_get_arg(0));
					break;
				default :
					$this->hours(0);
					$this->minutes(0);
					$this->seconds(0);
					break;
			}
		}
		
		//fixes values
		private function refactorHMS() {
			$h = $this->h;
			$m = $this->m;
			$s = $this->s;
			
			if(intval($h) != floatval($h)) {
				$s += (($h - floor($h)) * 3600);
				$h = floor($h);
				}
			
			if(intval($m) != floatval($m)) {
				$s += (($m - floor($m)) * 60);
				$m = floor($m);
				}
			
			while($s >= 3600) {
				$h++;
				$s -= 3600;
			}
			while($s >= 60) {
				$m++;
				$s -= 60;
			}
			while($m >= 60) {
				$h++;
				$m -= 60;
			}
			$this->h = $h;
			$this->m = $m;
			$this->s = $s;
		}
		
		//no argument or boolean false returns $this->h.
		//boolean true returns $this->s / 3600 + $this->m / 60 + $this->h
		//numeric arguments update $this->h and increment m,s
		//passing true as a second argument uses h as the sole time value for h,m,s.  minutes() and seconds() have similar logic.
		public function hours() {
			if(func_num_args() == 0)
				return $this->h;
			else {
				$arg = func_get_arg(0);
				
				$resetOthers = false;
				if( func_num_args() > 1 )
					$resetOthers = (bool) func_get_arg(1);
					
				if($arg === false || $arg === "false")
					return $this->h;
				if($arg === true || $arg === "true")
					return ($this->s / 3600) + ($this->m/60) + $this->h;
				
				if( is_numeric($arg) ) {
					//clear fields
					if($resetOthers) {
						$this->h = 0;
						$this->m = 0;
						$this->s = 0;
						}
					
					if(is_int($arg) || intval($arg) == $arg)
						$this->h = intval($arg);
					else
						$this->h = floatval($arg);
					
					$this->refactorHMS();
					return true;
				}
				else
					return false;
			}
		}
		
		public function minutes() {
			if(func_num_args() == 0)
				return $this->m;
			else {
				$arg = func_get_arg(0);
				
				$resetOthers = false;
				if( func_num_args() > 1 )
					$resetOthers = (bool) func_get_arg(1);
					
				if($arg === false || $arg === "false")
					return $this->m;
				if($arg === true || $arg === "true")
					return ($this->s / 60) + ($this->h*60) + $this->m;
				
				if( is_numeric($arg) ) {
					
					//clear fields
					if($resetOthers) {
						$this->h = 0;
						$this->m = 0;
						$this->s = 0;
						}
					
					if(is_int($arg) || intval($arg) == $arg)
						$this->m = intval($arg);
					else
						$this->m = floatval($arg);
					
					$this->refactorHMS();
					return true;
				}
				else
					return false;
			}
		}
		
		public function seconds() {
			if(func_num_args() === 0)
				return $this->s;
			else {
				$arg = func_get_arg(0);
				
				$resetOthers = false;
				if( func_num_args() > 1 )
					$resetOthers = (bool) func_get_arg(1);
					
				if($arg === false || $arg === "false")
					return $this->s;
				if($arg === true || $arg === "true")
					return ($this->m * 60) + ($this->h*3600) + $this->s;
				
				if( is_numeric($arg) ) {
					
					//clear fields
					if($resetOthers) {
						$this->h = 0;
						$this->m = 0;
						$this->s = 0;
						}
					
					$this->s = floatval($arg);
					$this->refactorHMS();
					return true;
				}
				else
					return false;
			}
		}
		
		//returns what would be the format of a toString() call.
		public function getFormat() {
			if($this->h != 0)
				return 'hh:mm:ss';
			if($this->m != 0)
				return 'm:ss';
			if($this->s != 0)
				return 'seconds';
			return 'hh:mm:ss';
		}
		
		//returns the actual last format of a toString() call.
		public function lastFormat() {
			return $this->format;
		}
		
		public function toString() {
			$return = '';
			if($this->h != 0) {
				$return .= $this->h.':';
				$this->format = 'hh:mm:ss';
				
				//add minutes
				$i = strlen($this->m.'');
				$m = '';
				while($i++ < 2)
						$m .= '0';
				$return .=$m.$this->m.':';
				
				//add seconds
				$i = strlen(floor($this->s).'');
				$s = '';
				while($i++ < 2)
					$s .= '0';
				$return .= $s.$this->s;
				}
			else {
				if($this->m != 0) {
					$return .= $this->m . ':';
					$this->format = 'm:ss';
					}
				if($return != '') {
					$i = strlen(floor($this->s).'');
					$s = '';
					while($i++ < 2)
						$s .= '0';
					$return .= $s.$this->s;
				}
				elseif($return == '' && $this->s != 0) {
					$return = $this->s;
					$this->format = 'seconds';
					}
				else {
					$return = '0:00:00.000';
					$this->format = 'hh:mm:ss';
					}
				}
			
			return $return;
			
		} //end toString()
		
	} //end class
?>