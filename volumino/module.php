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
                       online = $this->RegisterVariableBoolean("Volumio_On", "Volumio Server Online");
			$this->EnableAction("Volumio_On");
			//$this->RegisterTimer("GetStatus", 30000, 'Volumio_GetStatus($_IPS[\'TARGET\']);');
                     $this->RegisterTimer('INTERVAL', $this->ReadPropertyInteger('UpdateInterval'), 'Volumio_GetStatus($id)');
			
		}
		
		 protected function RegisterTimer($ident, $interval, $script) {
    $id = @IPS_GetObjectIDByIdent($ident, $this->InstanceID);
    if ($id && IPS_GetEvent($id)['EventType'] <> 1) {
      IPS_DeleteEvent($id);
      $id = 0;
    }
			 
			 
                public function GetStatus()
                {
                        $this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . "/api/v1/getstate";
   
                        $PING = Sys_Ping($this->IP, 1000);
                        SetValue($this->GetIDForIdent("Volumio_On"), $PING);
	
                }
        }
?>
