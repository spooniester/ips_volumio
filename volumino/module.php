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
		}
		public function GetStatus()
                {
                        $this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/getstate";
   						$BUFFER = implode('', file($URL));
						//echo $BUFFER;
						$data = json_decode($BUFFER);
						var_dump($data);
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
		
		
		
 
}
?>
