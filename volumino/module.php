<?
	class Volumio extends IPSModule
	{
	var $IP;
	var $ONLINE;
	var $MUTE;
	var $SENDER;
	var $VOLUME;
	var $STATUS;
                public function Create()
                {
                        //Never delete this line!
                        parent::Create();

                        //These lines are parsed on Symcon Startup or Instance creation
                        //You cannot use variables here. Just static values.
                        $this->RegisterPropertyString("IPAddress", "127.0.0.1");
       			$this->RegisterPropertyInteger("UpdateInterval", 15);
			$this->RegisterPropertyString("Sender","Sender");
			$this->RegisterPropertyInteger("Lautstaerke", 30);
			$this->RegisterPropertyString("Status","Status");
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
						$this->MUTE = $this->RegisterVariableBoolean("Mute", "Mute");
						$this->SENDER = $this->RegisterVariableString("Sender","Sender");
						$this->VOLUME = $this->RegisterVariableInteger("Lautstaerke","Lautstaerke");
						$this->STATUS = $this->RegisterVariableString("Status","Status");
						$this->EnableAction("Mute");
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
						//var_dump($data);
						//IPS_LogMessage("VOLUMIO", $data->status);
						//IPS_LogMessage("VOLUMIO", $data->title);
						//IPS_LogMessage("VOLUMIO", $data->volume);
						IPS_LogMessage("VOLUMIO", $data->stream);
    					SetValue($this->GetIDForIdent("Lautstaerke"), $data->volume);
					SetValue($this->GetIDForIdent("Status"), $data->status);
					SetValue($this->GetIDForIdent("Sender"), $data->title);
                }

        public function GetOnline()
        {
        $this->IP = $this->ReadPropertyString("IPAddress");
        $PING = Sys_Ping($this->IP, 1000);
        SetValue($this->GetIDForIdent("Volumio_On"), $PING);
        }


		public function Play()
		{
		if ($this->ReadPropertyBoolean("Volumio_On") === true)
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

		public function Clear()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=clearQueue";
			$TEST = implode('', file($URL));
		}

		public function PlayEinslive()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=play&N=0";
			$TEST = implode('', file($URL));
		}

		public function PlayRadioLippeWelle()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=play&N=1";
			$TEST = implode('', file($URL));
		}

		public function PlayBallermann()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=play&N=2";
			$TEST = implode('', file($URL));
		}

		public function PlayWDR()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=play&N=3";
			$TEST = implode('', file($URL));
		}
		public function PlayMP3()
                {
                $this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=play&N=4";
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

		public function Mute()
		{
		$this->IP = $this->ReadPropertyString("IPAddress");
                        $URL = "http://" . $this->IP . ":3000/api/v1/commands/?cmd=volume&mute";
                        //SetValue(this->GetIDForIdent("Mute"), $value);
			$TEST = implode('', file($URL));
			IPS_LogMessage("VOLUMIO",$TEST);
		}
}
?>
