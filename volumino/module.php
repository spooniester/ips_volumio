<?
	class Volumio extends IPSModule
	{	
	var $IP;
	var $ONLINE;
                public function Create()
                {
                        //Never delete this line!
                        parent::Create();
        
                        //These lines are parsed on Symcon Startup or Instance creation
                        //You cannot use variables here. Just static values.
                        $this->RegisterPropertyString("IPAddress", "127.0.0.1");
       					$this->RegisterPropertyInteger("UpdateInterval", 15);	
						
                }
		
		public function Destroy()
    {
        //Never delete this line!
        parent::Destroy();
    }
		
		
		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
                        $this->IP = $this->ReadPropertyString("IPAddress");
                       $this->ONLINE = $this->RegisterVariableBoolean("Volumio_On", "Volumio Server Online");
						$this->EnableAction("Volumio_On");
						//$this->RegisterTimer("GetStatus", 30000, 'Volumio_GetStatus($_IPS[\'TARGET\']);');
                    	 //$this->RegisterTimer('INTERVAL', $this->ReadPropertyInteger('UpdateInterval'), 'Volumio_GetStatus($id)');
                    	 
                    	$varID = $this->RegisterVariableInteger("Volume", "Lautstärke");
						IPS_SetVariableCustomProfile($varID,"~Intensity.100");
						$this->EnableAction("Volume"); 
			
		}
		
			 
                public function GetStatus()
                {
                        $this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/getstate";
   						$BUFFER = implode('', file($URL));
						echo $BUFFER;
                        //$PING = Sys_Ping($this->IP, 1000);
                        //SetValue($this->GetIDForIdent("Volumio_On"), $PING);
	
                }
				
		
		public function Play()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=play";
			$TEST = implode('', file($URL));
		}
		
		public function Stop()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=stop";
			$TEST = implode('', file($URL));
		}
		public function Next()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=next";
			$TEST = implode('', file($URL));
		}
		public function Pause()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=pause";
			$TEST = implode('', file($URL));
		}
		public function Prev()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=prev";
			$TEST = implode('', file($URL));
		}
		
		public function SetVolume($volume)
		{
			$URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=volume&volume=".$volume;
			echo $URL;
			$TEST = implode('', file($URL));
		}
		
		public function Mute()
		{
			$URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=volume&volume=mute";
			echo $URL;
			$TEST = implode('', file($URL));
		}
		
		
 
}
?>
