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
       					$this->RegisterProfileIntegerEx("Status.SONOS", "Information", "", "", Array(
                                Array(0, "Prev", "", -1),
                                Array(1, "Play", "", -1),
                                Array(2, "Pause", "", -1),
                                Array(3, "Stop", "", -1),
                                Array(4, "Next", "", -1)
                        ));	
                        
                        $this->RegisterProfileIntegerEx("Station.SONOS", "Information", "", "", Array(
                                Array(0, $this->ReadPropertyString("Radio1Name"), "", -1),
                                Array(1, $this->ReadPropertyString("Radio2Name"), "", -1),
                                Array(2, $this->ReadPropertyString("Radio3Name"), "", -1),
                                Array(3, $this->ReadPropertyString("Radio4Name"), "", -1),
                                Array(4, $this->ReadPropertyString("Radio5Name"), "", -1),
                        ));
                        
                        $this->RegisterVariableInteger("Mute", "Mute", "Schalter.SONOS");
                        $this->EnableAction("Mute");
                        $this->RegisterVariableInteger("Station", "Station", "Station.SONOS");
                        $this->EnableAction("Station");
                        $this->RegisterVariableString("Radiotitel", "Radiotitel", "");
                        $this->RegisterVariableString("Radiotitel_alt", "Radiotitel_alt", "");
                        $this->RegisterVariableString("Sender", "Sender", "");

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
						//IP Prüfen
		$ip = $this->ReadPropertyString('IPAddress');
		if (!filter_var($ip, FILTER_VALIDATE_IP) === false)
				{
				$this->SetStatus(102); //IP Adresse ist gültig -> aktiv
				}
				$this->RegisterTimer('INTERVAL', $this->ReadPropertyInteger('UpdateInterval'), 'volumio_GetOnline($id)');
		}
		
		protected function RegisterTimer($ident, $interval, $script) {
    $id = @IPS_GetObjectIDByIdent($ident, $this->InstanceID);
    if ($id && IPS_GetEvent($id)['EventType'] <> 1) {
      IPS_DeleteEvent($id);
      $id = 0;
    }
    if (!$id) {
      $id = IPS_CreateEvent(1);
      IPS_SetParent($id, $this->InstanceID);
      IPS_SetIdent($id, $ident);
    }
    IPS_SetName($id, $ident);
    IPS_SetHidden($id, true);
    IPS_SetEventScript($id, "\$id = \$_IPS['TARGET'];\n$script;");
    if (!IPS_EventExists($id)) throw new Exception("Ident with name $ident is used for wrong object type");
    if (!($interval > 0)) {
      IPS_SetEventCyclic($id, 0, 0, 0, 0, 1, 1);
      IPS_SetEventActive($id, false);
    } else {
      IPS_SetEventCyclic($id, 0, 0, 0, 0, 1, $interval);
      IPS_SetEventActive($id, true);
    }
  }
		
		
		
		
		public function GetStatus()
                {
                        $this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/getstate";
   						$BUFFER = implode('', file($URL));
						$data = json_decode($BUFFER);
						var_dump($data);
                }
                
        public function GetOnline()
        {
        $this->IP = $this->ReadPropertyString("IPAddress");
        $PING = Sys_Ping($this->IP, 1000);
        SetValue($this->GetIDForIdent("Volumio_On"), $PING);
        }
				
		
		public function Play()
		{
		if $this->ReadPropertyBoolean("Volumio_On") == true
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=play";
			$TEST = implode('', file($URL));
			}
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
		
		
		public function RequestAction($Ident, $Value)
                {
                        switch($Ident) {
                                case "Station":
                                        switch($Value) {
                                                case 0:
                                                        $this->SetRadio($this->ReadPropertyString("Radio1"),"");
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;
                                                case 1:
                                                        $this->SetRadio($this->ReadPropertyString("Radio2"),"");
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;
                                                case 2:
                                                        $this->SetRadio($this->ReadPropertyString("Radio3"),"");
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;
                                                case 3:
                                                        $this->SetRadio($this->ReadPropertyString("Radio4"),"");
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;
                                                case 4:
                                                        $this->SetRadio($this->ReadPropertyString("Radio5"),"");
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;

                                        }
                                        break;
                                case "Status":
                                        switch($Value) {
                                                case 0: //Prev
                                                        $this->Previous();
                                                        break;
                                                case 1: //Play
                                                        $this->Play();
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;
                                                case 2: //Pause
                                                        $this->Pause();
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;
                                                case 3: //Stop
                                                        $this->Stop();
                                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                                        break;
                                                case 4: //Next
                                                        $this->Next();
                                                        break;
                                        }
                                        break;
                                case "Volume":
                                        $this->SetVolume($Value);
                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                        break;
                                case "Mute":
                                        $this->SetMute($Value);
                                        SetValue($this->GetIDForIdent($Ident), $Value);
                                        break;

                                default:
                                        throw new Exception("Invalid ident");
                        }

                }
                
                //Remove on next Symcon update
                protected function RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize) {

                        if(!IPS_VariableProfileExists($Name)) {
                                IPS_CreateVariableProfile($Name, 1);
                        } else {
                                $profile = IPS_GetVariableProfile($Name);
                                if($profile['ProfileType'] != 1)
                                        throw new Exception("Variable profile type does not match for profile ".$Name);
                        }

                        IPS_SetVariableProfileIcon($Name, $Icon);
                        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
                        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);

                }

                protected function RegisterProfileIntegerEx($Name, $Icon, $Prefix, $Suffix, $Associations) {

                        $this->RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $Associations[0][0], $Associations[sizeof($Associations)-1][0], 0);

                        foreach($Associations as $Association) {
                                IPS_SetVariableProfileAssociation($Name, $Association[0], $Association[1], $Association[2], $Association[3]);
                        }

                }
		
		
		
 
}
?>
