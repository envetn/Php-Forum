<?php
	class ADFGVX{
		//FLC1X2RAH0GTSEM9JK6QBO7VZ38UI5WNDP4Y
		private $key1;
		private $key2;
		private $text;
	
		private $adfgvx1;
		private $adfgvx2;
		
		private $output = "";
	
		public function __construct()
		{
			$this->key1 = array();
			$this->key2 = null;
			$this->text = null;
			//lättare i början att använda två strängar ist för 2d array.
			$this->adfgvx1 = "ADFGVX";
			$this->adfgvx2 = "ADFGVX";
			
			//$this->init();
			//$this->checkKey1($this->key1);
			
		}
		public function init()
		{
		//FLC1X2RAH0GTSEM9JK6QBO7VZ38UI5WNDP4Y
			$this->key1 = range('A', 'Z');
			array_push($this->key1, 0,1,2,3,4,5,6,7,8,9);
			shuffle($this->key1);
			$this->key2 = "raynor";
			$this->text = "The quick brown fox jumps over the lazy dog";
		}
		
		public function checkKey1($key)
		{
			$uniq = false;
			
			//om unique levererar 36 så finns det 36 uniqa tecken. 
			//Tänker inte hantera !"#¤% just nu
			if( strlen($key) == 36)
			{
				
				for($i=0;$i<36;$i++)
				{
					$this->key1[$i] = $key[$i];
				}
				if(sizeof(array_unique($this->key1)) == 36)
				{
					$uniq = true;
					
				}
				else 
				{
					empty($this->key1);
				}
			}
			
			return $uniq;
			
		}
		
		public function insertValues($key1, $key2, $text)
		{
			if($this->checkKey1($key1))
			{
				for($i=0;$i<36;$i++)
				{
					$this->key1[$i] = $key1[$i];
				}
				$this->key2 = $key2;
				$this->text = $text;
			}
			
		}
	
		public function cipherStep1()
		{
			//steg 1, gör en matris av de 36 unika tecknen
			//gör om till uppercase.
			$this->text = strtoupper($this->text); 
			
			$message = "";
			$tmpKey1[][] = array();
			$k = 0;
			for($i=0;$i<6;$i++)
			{
				for($j=0;$j<6;$j++)
				{
					$tmpKey1[$i][$j] = $this->key1[$k];
					$k++;
				}
			}
		
			for($i=0;$i<strlen($this->text);$i++)
			{
				for($x=0;$x<6;$x++)
				{
					for($y=0;$y<6;$y++)
					{
					//	echo $this->text[$i] . " == " . $tmpKey1[$x][$y] . "<br/>";
						if($this->text[$i] == $tmpKey1[$x][$y])
						{
							$message .= $this->adfgvx1[$x];
							$message .= $this->adfgvx1[$y];
							//bry x och y loopen
							$x = 6;
							$y = 6;
						}
						if($this->text[$i] == " ")
						{
					//	$message .= ' ';
						}
					}
				}
				
			}
			echo "steg 1 kryptera: " . $message ;
			
			//FLC1X2RAH0GTSEM9JK6QBO7VZ38UI5WNDP4Y
			//inkommande
			//DXDFFDGDVGVVAFFXGFDAGGXAXDAAGGAVFVVGFFXGFAGGGXFDDADXDFFDADDDVAXXXFGGDV
			/*
			r	a	y	n	o	r
			D	X	D	F	F	D
			G	D	V	G	V	V
			A	F	F	X	G	F	
			osv.
			*/
			$count = 0;
			$arr = array();
			/*offset error försvinner om jag gör så här*/
			for($j=0; $j<strlen($this->key2) ;$j++)
			{
				$arr[$j] = "";
			}
			
			for($i=0;$i<strlen($message); $i++)
			{
				$arr[$count] .= $message[$i];
				$count ++;
				if(strlen($this->key2) <= $count)
				{
					$count = 0;
				}
			}
			var_dump($arr);
			
			
			/*
			r	a	y	n	o	r
			D	X	D	F	F	D
			G	D	V	G	V	V
			A	F	F	X	G	F	
			
			a	n	o	r	r	y
			X	F	F	D	D	D
			D	G	V	G	V	V
			F	X	G 	A	F	F
			
			
			*/
		
	
			for($i=0;$i<strlen($this->key2);$i++)
			{	
				for($j=0;$j<strlen($this->key2);$j++)
				{
					if($this->key2[$i] < $this->key2[$j])
					{
						/* swap key */
						$tmp = $this->key2[$i];
						$this->key2[$i] = $this->key2[$j];
						$this->key2[$j] = $tmp;
						/*Saknar swap(a,b);*/
						
						/*swapa platserna i arr samtidgt*/
						$tmpArr = $arr[$i];
						$arr[$i] = $arr[$j];
						$arr[$j] = $tmpArr;
					
					}
				}
			}
			
			//return as string
			$message = "";
			for($i=0;$i<sizeof($arr); $i++)
			{
				$message .= $arr[$i] ;//. ' ';
			}
				echo "<br>steg 2 kryptera: " . $message ;
					var_dump($arr);
			return $message;
		
		}
		
//FLC1X2RAH0GTSEM9JK6QBO7VZ38UI5WNDP4Y
		public function deCipherStep1()
		{
		/*läser in på fel sätt*/
		//in med att i array
			$count = 0;
			$arr = array();
			/*offset error försvinner om jag gör så här*/
			for($j=0; $j<strlen($this->key2) ;$j++)
			{
				$arr[$j] = "";
			}
			
			for($i=0;$i<strlen($this->key2);)
			{
				if(strlen($this->key2) <= $count)
				{
					$i++;
					$count = 0;
				}
				$arr[$count] .= $this->text[$i];
				$count ++;
				
			}
			echo "läst in till array";
			var_dump($arr);
			var_dump($this->text);
			echo "<hr>";
		
		//sortera nyckeln i bokstavsordning
			$tmpKey2 = $this->key2;
			 //test
			for($i=0;$i<strlen($this->key2);$i++)
			{
				for($j=0;$j<strlen($this->key2);$j++)
				{
					if($this->key2[$i] < $this->key2[$j])
					{
						/* swap key */
						$tmp = $this->key2[$i];
						$this->key2[$i] = $this->key2[$j];
						$this->key2[$j] = $tmp;
					}
				}
			}
			
	
			var_dump($this->text);
			var_dump($arr);
			var_dump($this->key2);
			echo "<hr>";
		
			$tmpKey22 = $this->key2;//presentera stegen.
			//tmpKey2 orginal nyckel.
			//this->key2 sorterad nyckel
			
			for($i=0;$i<strlen($this->key2);$i++)
			{
				for($j=$i;$j<strlen($this->key2);$j++) // j = i
				{
					if($tmpKey2[$i] == $this->key2[$j])
					{
						$tmp = $arr[$j];
						$arr[$j] = $arr[$i];
						$arr[$i] = $tmp;
						
						$tmp2 = $this->key2[$j];
						$this->key2[$j] = $this->key2[$i];
						$this->key2[$i] = $tmp2;
						$j = strlen($this->key2); //bryt loopen
						
					}
				}
			}
			
			var_dump($arr);
			$this->text ="";
			for($i=0;$i<sizeof($arr);$i++)
			{
					$this->text .= $arr[$i];
			}
			var_dump($this->text);
			
			
			
			//second step
			$message = "";
			$tmpKey1[][] = array();
			//in med det i 2d array
			$k = 0;
			for($i=0;$i<6;$i++)
			{
				for($j=0;$j<6;$j++)
				{
					$tmpKey1[$i][$j] = $this->key1[$k];
					$k++;
				}
			}
			
			
			for($i=0;$i<strlen($this->text)-1;$i++)
			{
				for($x=0;$x<6;$x++)
				{
					for($y=0;$y<6;$y++)
					{
					//	echo $this->text[$i] . " == " . $tmpKey1[$x][$y] ."   " ;
						if( ( $this->text[$i] == $this->adfgvx1[$x] ) && ($this->text[$i+1] == $this->adfgvx2[$y]) ) 
						{
							$message .= $tmpKey1[$x][$y];
							$x = 6;
							$y = 6;
							$i ++; // har i+1 i ifsatsen
						}
						if($this->text[$i] == " ")
						{
							$message .= ' ';
						}
						
					}
				}
				
			}
				
			return $message;
		
		}
		
		
		
		
		
		public function setOutput($value)
		{
			$this->output = $value;
		}
	
		public function getOutput()
		{
			return $this->output;
		}
		

		//get values
		public function getKey1()
		{
			$tmp = "";
			for($i=0;$i<36;$i++)
			{
				$tmp .= $this->key1[$i];
			}
			return $tmp;
		}	
		public function getKey2()
		{
			return $this->key2;
		}	
		public function getText()
		{
		return $this->text;
		}
	
	
	}

?>