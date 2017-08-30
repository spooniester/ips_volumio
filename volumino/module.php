<?
	class Volumio extends IPSModule
	{
        
        var $IP;
                public function Create()
                {
                        //Never delete this line!
                        parent::Create();
        
                        //These lines are parsed on Symcon Startup or Instance creation
                        //You cannot use variables here. Just static values.
                        $this->RegisterPropertyString("IP-Address", "192.168.199.123");
       
                }
		
		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
                        $this->IP = $this->ReadPropertyString("IP-Adress");
                        $this->RegisterVariableBoolean("Volumio_On", "Volumio Server Online");
			$this->RegisterTimer("GetStatus", 30000, 'Volumio_GetStatus($_IPS[\'TARGET\']);');
                      
			
		}
                public function Getstatus()
                {
                        $this->IP = $this->ReadPropertyString("IP-Adress");
                        $URL = "http://" . $this->IP . "/api/v1/getstate";
   
                        $PING = Sys_Ping($this->IP, 1000);
                        SetValue($this->GetIDForIdent("Volumio_On"), $PING);
	
                }
        }
?>
