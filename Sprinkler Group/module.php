<?php

declare(strict_types=1);
	class SprinklerGroup extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$i = 10;

			$this->RegisterVariableBoolean('GroupActive', $this->Translate('Group Active'), "~Switch", $i++);
			$this->RegisterVariableInteger('AutomaticActivation', $this->Translate('Group Operation Mode'),"IC.GroupAutomaticActivation", $i++);
			$this->RegisterVariableInteger('StartTime', $this->Translate('Auto Starttime'), "~UnixTimestampTime", $i++);
			SetValue($this->GetIDForIdent("StartTime"), "1619380800");
			$this->RegisterVariableInteger('Interval', $this->Translate('Auto Interval'),'',$i++);
			SetValue($this->GetIDForIdent("Interval"), "2");
			$this->RegisterVariableInteger('CurrentStatus', $this->Translate('Current Status'),"IC.CurrentStatus", $i++);
			$this->RegisterVariableBoolean('ManualBlock', $this->Translate('Block or Stop Sprinkler'),'IC.GroupBlock',$i++);
			
			$this->RegisterPropertyString('GroupName', 'Sprinkler Group');
			$this->RegisterPropertyInteger('ControllerVariable');
			$this->RegisterPropertyBoolean("WriteToLog",0);
			$this->RegisterPropertyBoolean("Notification",0);

			$this->RegisterPropertyBoolean("MasterValveActive", 0);
			$this->RegisterPropertyInteger("MasterValveWaitTime", 0); 
			$this->RegisterPropertyString("MasterValveGroup", 0); 

			$this->RegisterPropertyBoolean("String1Active", 0);
			$this->RegisterPropertyInteger("String1Time", 0); 
			$this->RegisterPropertyString("String1ValveGroup", 0);
			$this->RegisterPropertyString("String1Name", "String 1");

			$this->RegisterPropertyBoolean("String2Active", 0);
			$this->RegisterPropertyInteger("String2Time", 0); 
			$this->RegisterPropertyString("String2ValveGroup", 0);
			$this->RegisterPropertyString("String2Name", "String 2"); 

			$this->RegisterPropertyBoolean("String3Active", 0);
			$this->RegisterPropertyInteger("String3Time", 0); 
			$this->RegisterPropertyString("String3ValveGroup", 0); 
			$this->RegisterPropertyString("String3Name", "String 3");

			$this->RegisterPropertyBoolean("String4Active", 0);
			$this->RegisterPropertyInteger("String4Time", 0); 
			$this->RegisterPropertyString("String4ValveGroup", 0); 
			$this->RegisterPropertyString("String4Name", "String 4");
		
			$this->RegisterPropertyBoolean("String5Active", 0);
			$this->RegisterPropertyInteger("String5Time", 0); 
			$this->RegisterPropertyString("String5ValveGroup", 0); 
			$this->RegisterPropertyString("String5Name", "String 5");

			$this->RegisterPropertyBoolean("String6Active", 0);
			$this->RegisterPropertyInteger("String6Time", 0); 
			$this->RegisterPropertyString("String6ValveGroup", 0); 
			$this->RegisterPropertyString("String6Name", "String 6");

			$this->RegisterPropertyBoolean("String7Active", 0);
			$this->RegisterPropertyInteger("String7Time", 0); 
			$this->RegisterPropertyString("String7ValveGroup", 0);
			$this->RegisterPropertyString("String7Name", "String 7"); 

			$this->RegisterPropertyBoolean("String8Active", 0);
			$this->RegisterPropertyInteger("String8Time", 0); 
			$this->RegisterPropertyString("String8ValveGroup", 0); 
			$this->RegisterPropertyString("String8Name", "String 8");

			$this->RegisterPropertyBoolean("String9Active", 0);
			$this->RegisterPropertyInteger("String9Time", 0); 
			$this->RegisterPropertyString("String9ValveGroup", 0);
			$this->RegisterPropertyString("String9Name", "String 9"); 

			$this->RegisterPropertyBoolean("String10Active", 0);
			$this->RegisterPropertyInteger("String10Time", 0); 
			$this->RegisterPropertyString("String10ValveGroup", 0); 
			$this->RegisterPropertyString("String10Name", "String 10");

			if (IPS_VariableProfileExists("IC.CurrentStatus") == false) {
			IPS_CreateVariableProfile("IC.CurrentStatus", 1);
			IPS_SetVariableProfileIcon("IC.CurrentStatus", "Gear");
			IPS_SetVariableProfileAssociation("IC.CurrentStatus", 0, $this->Translate("Inactive"), "", -1);
			IPS_SetVariableProfileAssociation("IC.CurrentStatus", 1, $this->Translate("Running Automatically"), "", -1);
			IPS_SetVariableProfileAssociation("IC.CurrentStatus", 2, $this->Translate("Running Manually"), "", -1);
			}

			if (IPS_VariableProfileExists("IC.StringRun") == false) {
				IPS_CreateVariableProfile("IC.StringRun", 1);
				IPS_SetVariableProfileIcon("IC.StringRun", "Gear");
				IPS_SetVariableProfileAssociation("IC.StringRun", 0, $this->Translate("No"), "", -1);
				IPS_SetVariableProfileAssociation("IC.StringRun", 1, $this->Translate("Yes"), "", -1);
				IPS_SetVariableProfileAssociation("IC.StringRun", 2, $this->Translate("Runnig"), "", -1);
			}
			
			if (IPS_VariableProfileExists("IC.MasterValve") == false) {
				IPS_CreateVariableProfile("IC.MasterValve", 0);
				IPS_SetVariableProfileIcon("IC.MasterValve", "Drops");
				IPS_SetVariableProfileAssociation("IC.MasterValve", 0, $this->Translate("Closed"), "", -1);
				IPS_SetVariableProfileAssociation("IC.MasterValve", 1, $this->Translate("Open"), "", -1);
			}

			if (IPS_VariableProfileExists("IC.GroupAutomaticActivation") == false) {
				IPS_CreateVariableProfile("IC.GroupAutomaticActivation", 1);
				IPS_SetVariableProfileIcon("IC.GroupAutomaticActivation", "Robot");
				IPS_SetVariableProfileAssociation("IC.GroupAutomaticActivation", 0, $this->Translate("Manual"), "", -1);
				IPS_SetVariableProfileAssociation("IC.GroupAutomaticActivation", 1, $this->Translate("Group Timer"), "", -1);
				IPS_SetVariableProfileAssociation("IC.GroupAutomaticActivation", 2, $this->Translate("Group Timer + Controller"), "", -1);
			}

			if (IPS_VariableProfileExists("IC.GroupBlock") == false) {
				IPS_CreateVariableProfile("IC.GroupBlock", 1);
				IPS_SetVariableProfileIcon("IC.GroupBlock", "Robot");
				IPS_SetVariableProfileAssociation("IC.GroupBlock", 0, $this->Translate("No Block"), "", -1);
				IPS_SetVariableProfileAssociation("IC.GroupBlock", 1, $this->Translate("Blocked Manually"), "", -1);
				IPS_SetVariableProfileAssociation("IC.GroupBlock", 2, $this->Translate("Blocked by Controller"), "", -1);
			}

			if (IPS_VariableProfileExists("IC.ManualString") == false) {
				IPS_CreateVariableProfile("IC.ManualString", 1);
				IPS_SetVariableProfileIcon("IC.ManualString", "Gear");
				IPS_SetVariableProfileAssociation("IC.ManualString", 0, $this->Translate("Alle Strings"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 1, $this->Translate("String 1"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 2, $this->Translate("String 2"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 3, $this->Translate("String 3"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 4, $this->Translate("String 4"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 5, $this->Translate("String 5"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 6, $this->Translate("String 6"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 6, $this->Translate("String 7"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 6, $this->Translate("String 8"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 6, $this->Translate("String 9"), "", -1);
				IPS_SetVariableProfileAssociation("IC.ManualString", 6, $this->Translate("String 10"), "", -1);
			}
			
			if (IPS_VariableProfileExists("IC.Timer") == false) {
				IPS_CreateVariableProfile("IC.Timer", 1);
				IPS_SetVariableProfileIcon("IC.Timer", "Clock");
				IPS_SetVariableProfileDigits("IC.Timer", 0);
				IPS_SetVariableProfileValues("IC.Timer", 0, 60, 1);
			}

			$i = 80;

			$this->RegisterVariableBoolean('ManualActivationSprinkler', $this->Translate('WF Manual Sprinkler Activation'),"~Switch", $i++);		
			$this->RegisterVariableInteger('ManualActivationRunTime', $this->Translate('WF Manual Sprinkler Runtime'),"IC.Timer", $i++);
			$this->RegisterVariableInteger('ManualActivationString', $this->Translate('WF Manual Sprinkler String'),"IC.ManualString", $i++);
			//$this->RegisterVariableBoolean('ManualBlockSprinkler', $this->Translate('WF Manual Sprinkler Block'),"~Switch");
						
			$i = 100;
			$this->RegisterVariableInteger('CurrentString', $this->Translate('Current String'),"",$i++);
			$this->RegisterVariableInteger('String1HasRun', $this->Translate('String 1 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String2HasRun', $this->Translate('String 2 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String3HasRun', $this->Translate('String 3 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String4HasRun', $this->Translate('String 4 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String5HasRun', $this->Translate('String 5 Has Run'),"IC.StringRun", $i++);					
			$this->RegisterVariableInteger('String6HasRun', $this->Translate('String 6 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String7HasRun', $this->Translate('String 7 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String8HasRun', $this->Translate('String 8 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String9HasRun', $this->Translate('String 9 Has Run'),"IC.StringRun", $i++);
			$this->RegisterVariableInteger('String10HasRun', $this->Translate('String 10 Has Run'),"IC.StringRun", $i++);


			//timer stuff
			$this->RegisterPropertyBoolean("ComponentActive", 0);
			$this->RegisterPropertyInteger("Hour","03");
			$this->RegisterPropertyInteger("Minute","00");
			
			//Properties
			$this->RegisterTimer('SprinklerOperation', 0, 'SG_SprinklerOperation($_IPS["TARGET"]);'); //Test
			//$this->RegisterTimer('Watchdog', 0, 'IC_Watchdog($_IPS["TARGET"]);'); //Timer to monitor things and perform frequent tasks
			$this->RegisterTimer('SprinklerStringStop', 0, 'SG_SprinklerStringStop($_IPS["TARGET"]);'); //Timer stopping Irrigation



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

			// - Auslesen für manuellen Stop
			$BlockVariableID = @IPS_GetObjectIDByIdent("ManualBlock", $this->InstanceID);	
			if (IPS_GetObject($BlockVariableID)['ObjectType'] == 2) {
					$this->RegisterMessage($BlockVariableID, VM_UPDATE);
			}

			$TimerVariableID = @IPS_GetObjectIDByIdent("StartTime", $this->InstanceID);	
			if (IPS_GetObject($TimerVariableID)['ObjectType'] == 2) {
					$this->RegisterMessage($TimerVariableID, VM_UPDATE);
			}
			
			$GroupActiveVariableID = @IPS_GetObjectIDByIdent("GroupActive", $this->InstanceID);
			if (IPS_GetObject($GroupActiveVariableID)['ObjectType'] == 2) {
					$this->RegisterMessage($GroupActiveVariableID, VM_UPDATE);
			}

			$IntervalVariableID = @IPS_GetObjectIDByIdent("Interval", $this->InstanceID);
			if (IPS_GetObject($IntervalVariableID)['ObjectType'] == 2) {
					$this->RegisterMessage($IntervalVariableID, VM_UPDATE);
			}

			$ManualActivationSprinklerID = @IPS_GetObjectIDByIdent("ManualActivationSprinkler", $this->InstanceID);	
			if (IPS_GetObject($ManualActivationSprinklerID)['ObjectType'] == 2) {
					$this->RegisterMessage($ManualActivationSprinklerID, VM_UPDATE);
			}

			$AutomaticActivationID = @IPS_GetObjectIDByIdent("AutomaticActivation", $this->InstanceID);	
			if (IPS_GetObject($AutomaticActivationID)['ObjectType'] == 2) {
					$this->RegisterMessage($AutomaticActivationID, VM_UPDATE);
			}

			$ControllerVariableSet = GetValue($this->GetIDForIdent("ControllerVariable"));
			if (isset($ControllerVariableSet)) {
				$ControllerVariableID = @IPS_GetObjectIDByIdent("ControllerVariable", $this->InstanceID);	
				if (IPS_GetObject($ControllerVariableID)['ObjectType'] == 2) {
						$this->RegisterMessage($ControllerVariableID, VM_UPDATE);
				}
			}



		}

		
		//function which is sending push messages in case it is activated
		//***************************************************************

		public function NotifyApp() {
			$NotifierTitle = $this->GetBuffer("NotifierTitle");
			$NotifierMessage = $this->GetBuffer("NotifierMessage");
			$WebFrontMobile = IPS_GetInstanceListByModuleID('{3565B1F2-8F7B-4311-A4B6-1BF1D868F39E}')[0];
			// to send notifications
			$this->SendDebug("Notifier","********** App Notifier **********", 0);
			$this->SendDebug("Notifier","Message: ".$NotifierMessage." was sent", 0);			
			WFC_PushNotification($WebFrontMobile, $NotifierTitle, $NotifierMessage , "", 0);
		}

		//function to check for changes via webfront 
		//******************************************
		public function MessageSink($TimeStamp, $SenderID, $Message, $Data)	{
			//echo $SenderId." ".$Data;
			$this->SetResetTimerInterval();


			if ($SenderID == $this->GetIDForIdent("ManualActivationSprinkler")) {

				$ManualActivationSprinkler = GetValue($this->GetIDForIdent("ManualActivationSprinkler"));
				$ManualActivationRunTime = GetValue($this->GetIDForIdent("ManualActivationRunTime"));
				$ManualActivationString = GetValue($this->GetIDForIdent("ManualActivationString"));
				$WriteToLog = $this->ReadPropertyBoolean("WriteToLog");
				$CurrentStatus = GetValue($this->GetIDForIdent("CurrentStatus"));
						
				if ($ManualActivationSprinkler == 1){
					if ($ManualActivationString == 0) {
						//starte bei String 0
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SetBuffer("ActivationManual", 1);
						$this->SetBuffer("ActivationManualTimer", $ManualActivationRunTime);
						if ($WriteToLog == 1) {
							IPS_LogMessage("Beregnungssteuerung", "!!! Manueller Start der Beregnung - Alle Abschnitte werden für ".$ManualActivationRunTime." Minuten beregnet");
						}
						$this->SendDebug($this->Translate('Manual Activation'),$this->Translate('All Strings'),0);
						SetValue($this->GetIDForIdent("CurrentStatus"), 2);
						SetValue($this->GetIDForIdent("ManualActivationSprinkler"), 0);
						$this->SprinklerOperation();
					}
					else if ($ManualActivationString > 0) { //will only run 1 specific string
						SetValue($this->GetIDForIdent("CurrentString"), $ManualActivationString);
						$this->SetBuffer("ManualActivationSingleString", 1);
						$this->SetBuffer("ActivationManual", 1);
						$this->SetBuffer("ActivationManualTimer", $ManualActivationRunTime);
						SetValue($this->GetIDForIdent("ManualActivationSprinkler"), 0); // in case irrigation was manually started
						if ($WriteToLog == 1) {
							IPS_LogMessage("Beregnungssteuerung", "!!! Manueller Start der Beregnung - Abschnitt ".$ManualActivationString." wird für ".$ManualActivationRunTime." Minuten beregnet");
						}
						//$this->SendDebug($this->Translate('Manual Activation'),$this->Translate('Single String Number: ').$ManualActivationString,0);
						SetValue($this->GetIDForIdent("CurrentStatus"), 2);
						$this->SprinklerOperation();
					}
					
				}
				
				else if ($ManualActivationSprinkler == 0 AND $CurrentStatus == 0){ // set manual buffer variables with 0 to avoid empty values
					$this->SetBuffer("ManualActivationSingleString", 0);
					$this->SetBuffer("ActivationManual", 0);
					$this->SetBuffer("ActivationManualTimer", 0);
				}

			}

			elseif ($SenderID == $this->GetIDForIdent("ManualBlock")) {

				$ManualBlock = GetValue($this->GetIDForIdent("ManualBlock"));
				
				if ($ManualBlock == 1) {
					$this->SendDebug($this->Translate('Manual Stop'),$this->Translate('Manual Stop Triggered'),0);
					$this->SprinklerStringStop();
				}
				else {
					//do nothing - block is released
				}

			}

			elseif ($SenderID == $this->GetIDForIdent("AutomaticActivation")) {

				$AutomaticActivationStatus = GetValue($this->GetIDForIdent("AutomaticActivation"));

				if ($AutomaticActivationStatus == 0) {
					
				}
			}

			elseif ($SenderID == $this->GetIDForIdent("ControllerVariable")) {

				$ControllerStatus = GetValue($this->GetIDForIdent("ControllerVariable"));

				if ($ControllerStatus == 0) {
					// Aus
				}
				elseif ($ControllerStatus == 1) {
					//An
				} 

			}


			else {
				//nix
			}



		}

		//function sets timer for Module
		//******************************

		public function SetResetTimerInterval() {
			$GroupActive = GetValue($this->GetIDForIdent("GroupActive"));
			$WateringTime = date("H:i",GetValue($this->GetIDForIdent("StartTime")));
			//echo $WateringTime;

			if ($GroupActive == 1) {
				$Hour = (integer)date("H",GetValue($this->GetIDForIdent("StartTime")));
				$Minute = (integer)date("i",GetValue($this->GetIDForIdent("StartTime")));
				$GroupExecutionInterval = GetValue($this->GetIDForIdent("Interval"));
				$NewTime = $Hour.":".$Minute;
				$now = new DateTime();
				$target = new DateTime();
				
				if ($NewTime < date("H:i")) {
					$target->modify('+1 day');	
				}
				
				if ($GroupExecutionInterval == 1) {
					$target->modify('+'.$GroupExecutionInterval.' day');
				}
				if ($GroupExecutionInterval > 1) {
					$target->modify('+'.$GroupExecutionInterval.' days');
				}
				$target->setTime((int)$Hour, (int)$Minute, 0);
				$diff = $target->getTimestamp() - $now->getTimestamp();
				$GroupTimer = $diff * 1000;
				$this->SetTimerInterval('SprinklerOperation', $GroupTimer);
			}
			else if ($GroupActive == 0) {
				$this->SetTimerInterval('SprinklerOperation', 0);
			}
			
		} 

	public function SprinklerOperation() {
		
		$GroupActive = GetValue($this->GetIDForIdent("GroupActive"));
		$GroupName = $this->ReadPropertyString("GroupName");
		$ManualBlockSprinkler = GetValue(@IPS_GetObjectIDByIdent("ManualBlock", $this->InstanceID));

		$Notification = $this->ReadPropertyBoolean("Notification");
		$WriteToLog = $this->ReadPropertyBoolean("WriteToLog");

		$String1Active = $this->ReadPropertyBoolean("String1Active"); 
		$String2Active = $this->ReadPropertyBoolean("String2Active"); 
		$String3Active = $this->ReadPropertyBoolean("String3Active"); 
		$String4Active = $this->ReadPropertyBoolean("String4Active"); 
		$String5Active = $this->ReadPropertyBoolean("String5Active"); 
		$String6Active = $this->ReadPropertyBoolean("String6Active"); 
		$String7Active = $this->ReadPropertyBoolean("String7Active");
		$String8Active = $this->ReadPropertyBoolean("String8Active");
		$String9Active = $this->ReadPropertyBoolean("String9Active");
		$String10Active = $this->ReadPropertyBoolean("String10Active");
		
		//Öffnen Hauptventil - wartezeit
		
		$CurrentString = GetValue($this->GetIDForIdent("CurrentString"));

		$String1HasRun = GetValue($this->GetIDForIdent("String1HasRun"));
		$String2HasRun = GetValue($this->GetIDForIdent("String2HasRun"));
		$String3HasRun = GetValue($this->GetIDForIdent("String3HasRun"));
		$String4HasRun = GetValue($this->GetIDForIdent("String4HasRun"));
		$String5HasRun = GetValue($this->GetIDForIdent("String5HasRun"));
		$String6HasRun = GetValue($this->GetIDForIdent("String6HasRun"));
		$String7HasRun = GetValue($this->GetIDForIdent("String7HasRun"));
		$String8HasRun = GetValue($this->GetIDForIdent("String8HasRun"));
		$String9HasRun = GetValue($this->GetIDForIdent("String9HasRun"));
		$String10HasRun = GetValue($this->GetIDForIdent("String10HasRun"));
		
		//$this->SendDebug($this->Translate('Sprinkler'),$this->Translate('Current String - Entry before reset: '.$CurrentString),0);
		
		if ($CurrentString == 0 AND $String1HasRun == 0 AND $String2HasRun == 0 AND $String3HasRun == 0 AND $String4HasRun == 0 AND $String5HasRun == 0 AND $String6HasRun == 0 AND $String7HasRun == 0 AND $String8HasRun == 0 AND $String9HasRun == 0 AND $String10HasRun == 0) {
			SetValue($this->GetIDForIdent("CurrentString"), 1);
			if ($WriteToLog == 1) {
				IPS_LogMessage("Beregnungssteuerung", "Automatischer Start der Beregnung Sprinklergruppe ".$GroupName);
			}
			if ($Notification == 1) {
				$this->SetBuffer("NotifierTitle", "Beregnung");
				$this->SetBuffer("NotifierMessage", "Beregnung automatisch gestartet für Gruppe ".$GroupName);
				$this->NotifyApp();
			}
			
			$CurrentString = GetValue($this->GetIDForIdent("CurrentString"));
			$this->SendDebug($this->Translate('Sprinkler'),$this->Translate('Current String - was 0 and is now '.$CurrentString),0);
			
		}
		else {
			//nix
		}
		
		if ($GroupActive == 1 AND $ManualBlockSprinkler == 0) {

			//Master Valves open
			$arrStringMasterValves = $this->ReadPropertyString("MasterValveGroup");
			$arrMasterValves = json_decode($arrStringMasterValves);

			$i = 0;
			
			foreach ($arrMasterValves as $valves) {
				$i++;
				$valve = $valves->InstanceID;
				RequestAction($valve, true);	
			}



			switch ($CurrentString) {
				case 0:
					$this->SendDebug($this->Translate('Group 1'),$this->Translate('All strings have run - irrigation completed'),0);
					$this->SetTimerInterval("SprinklerStringStop",0); // Stoppt timer
					SetValue($this->GetIDForIdent("CurrentStatus"), 0); // Sets Sprinkler Status back to 0 - off
					SetValue($this->GetIDForIdent("String1HasRun"), 0);
					SetValue($this->GetIDForIdent("String2HasRun"), 0);
					SetValue($this->GetIDForIdent("String3HasRun"), 0);
					SetValue($this->GetIDForIdent("String4HasRun"), 0);
					SetValue($this->GetIDForIdent("String5HasRun"), 0);
					SetValue($this->GetIDForIdent("String6HasRun"), 0);
					SetValue($this->GetIDForIdent("String7HasRun"), 0);
					SetValue($this->GetIDForIdent("String8HasRun"), 0);
					SetValue($this->GetIDForIdent("String9HasRun"), 0);
					SetValue($this->GetIDForIdent("String10HasRun"), 0);
					
					$this->SendDebug($this->Translate('Group 1'),$this->Translate('Master Valves closed'),0);
					$arrStringMasterValves = $this->ReadPropertyString("MasterValveGroup");
					$arrMasterValves = json_decode($arrStringMasterValves);

					$i = 0;
					
					foreach ($arrMasterValves as $valves) {
						$i++;
						$valve = $valves->InstanceID;
						RequestAction($valve, false);
					}

					
					SetValue($this->GetIDForIdent("CurrentString"), 0);
					SetValue($this->GetIDForIdent("ManualActivationSprinkler"), 0);
					if ($WriteToLog == 1) {
						IPS_LogMessage("Beregnungssteuerung", "Automatischer Stop der Beregnung - Gruppe ".$GroupName);
					}
					if ($Notification == 1) {
						$this->SetBuffer("NotifierTitle", "Beregnung");
						$this->SetBuffer("NotifierMessage", "Beregnung automatisch beendet");
						$this->NotifyApp();
					}
				break;
				case 1:
					if ($String1Active == 1 AND $String1HasRun == 0) {
						$StringName = $this->ReadPropertyString("String1Name");
						$this->SendDebug($GroupName,'$StringName'.$this->Translate(' is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 1);
						SetValue($this->GetIDForIdent("String1HasRun"), 2);
						$this->SetBuffer("CurrentString", 1);
						$this->SetBuffer("CurrentStringName", $StringName);
						$this->SprinklerStringStart();
					}
					if ($String1Active == 0)  {
						SetValue($this->GetIDForIdent("CurrentString"), 2);
						$this->SprinklerOperation();
					}
				break;
				case 2:
					if ($String2Active == 1 AND $String2HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 2 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 2);
						SetValue($this->GetIDForIdent("String2HasRun"), 2);
						$this->SetBuffer("CurrentString", 2);
						$this->SprinklerStringStart();
					}
					if ($String2Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 3);
						$this->SprinklerOperation();
					}
				break;
				case 3:
					if ($String3Active == 1 AND $String3HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 3 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 3);
						SetValue($this->GetIDForIdent("String3HasRun"), 2);
						$this->SetBuffer("CurrentString", 3);
						$this->SprinklerStringStart();
					}
					if ($String3Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 4);
						$this->SprinklerOperation();
					}
				break;
				case 4:
					if ($String4Active == 1 AND $String4HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 4 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 4);
						SetValue($this->GetIDForIdent("String4HasRun"), 2);
						$this->SetBuffer("CurrentString", 4);
						$this->SprinklerStringStart();
					}
					if ($String4Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SprinklerOperation();
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('F1'),0);
					}
				break;
				case 5:
					if ($String5Active == 1 AND $String5HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 5 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 5);
						SetValue($this->GetIDForIdent("String5HasRun"), 2);
						$this->SetBuffer("CurrentString", 5);
						$this->SprinklerStringStart();
					}
					if ($String5Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SprinklerOperation();
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('F1'),0);
					}
				break;
				case 6:
					if ($String6Active == 1 AND $String6HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 6 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 6);
						SetValue($this->GetIDForIdent("String6HasRun"), 2);
						$this->SetBuffer("CurrentString", 6);
						$this->SprinklerStringStart();
					}
					if ($String6Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SprinklerOperation();
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('F1'),0);
					}
				break;
				case 7:
					if ($String7Active == 1 AND $String7HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 7 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 7);
						SetValue($this->GetIDForIdent("String7HasRun"), 2);
						$this->SetBuffer("CurrentString", 7);
						$this->SprinklerStringStart();
					}
					if ($String7Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SprinklerOperation();
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('F1'),0);
					}
				break;
				case 8:
					if ($String8Active == 1 AND $String8HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 8 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 8);
						SetValue($this->GetIDForIdent("String8HasRun"), 2);
						$this->SetBuffer("CurrentString", 8);
						$this->SprinklerStringStart();
					}
					if ($String8Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SprinklerOperation();
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('F1'),0);
					}
				break;
				case 9:
					if ($String9Active == 1 AND $String9HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 9 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 9);
						SetValue($this->GetIDForIdent("String9HasRun"), 2);
						$this->SetBuffer("CurrentString", 9);
						$this->SprinklerStringStart();
					}
					if ($String8Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SprinklerOperation();
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('F1'),0);
					}
				break;
				case 10:
					if ($String10Active == 1 AND $String10HasRun == 0){
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('String 10 is triggered to start watering'),0);
						SetValue($this->GetIDForIdent("CurrentString"), 10);
						SetValue($this->GetIDForIdent("String10HasRun"), 2);
						$this->SetBuffer("CurrentString", 10);
						$this->SprinklerStringStart();
					}
					if ($String10Active == 0) {
						SetValue($this->GetIDForIdent("CurrentString"), 0);
						$this->SprinklerOperation();
						$this->SendDebug($this->Translate('Group 1'),$this->Translate('F1'),0);
					}
				break;			
			} 
		}
		else {
			$this->SendDebug($this->Translate('Group 1'),$this->Translate('Currently disabled or manually blocked by setting in Webfront'),0);
			SetValue($this->GetIDForIdent("String1HasRun"), 0);
			SetValue($this->GetIDForIdent("String2HasRun"), 0);
			SetValue($this->GetIDForIdent("String3HasRun"), 0);
			SetValue($this->GetIDForIdent("String4HasRun"), 0);
			SetValue($this->GetIDForIdent("String5HasRun"), 0);
			SetValue($this->GetIDForIdent("String6HasRun"), 0);
			SetValue($this->GetIDForIdent("String7HasRun"), 0);
			SetValue($this->GetIDForIdent("String8HasRun"), 0);
			SetValue($this->GetIDForIdent("String9HasRun"), 0);
			SetValue($this->GetIDForIdent("String10HasRun"), 0);
			SetValue($this->GetIDForIdent("CurrentString"), 0);
			$this->SendDebug($this->Translate('Group 1'),$this->Translate('F2'),0);
		}


	}

	public function SprinklerStringStart(){

		$this->SendDebug($this->Translate('Group 1'),$this->Translate('**********************************'),0);
		$CurrentStringName = $this->GetBuffer('CurrentStringName');		
		$CurrentString = GetValue($this->GetIDForIdent("CurrentString"));
		$StringTime = $this->ReadPropertyInteger("String".$CurrentString."Time");
		//$StringLiterPerHour = $this->GetBuffer("StringLiterPerHour");
		
		$ActivationManual = $this->GetBuffer("ActivationManual");
		$ActivationManualTimer = $this->GetBuffer("ActivationManualTimer");
	
		$arrCurrentStringValves = $this->ReadPropertyString("String".$CurrentString."ValveGroup");
		$arrValves = json_decode($arrCurrentStringValves);
		
		$i = 0;
		
		foreach ($arrValves as $valves) {
			$i++;
			$valve = $valves->InstanceID;
			RequestAction($valve, true);
		}

		$this->SendDebug($this->Translate('Group 1'),$this->Translate('Current String - Start Section: '.$CurrentString),0);
		
		if ($ActivationManual == 0) {
			$this->SendDebug($this->Translate('Group 1'),$this->Translate('Automatic Timer: '.$StringTime.' for String '.$CurrentString.' with Name '.$CurrentStringName),0);
			$StringRunTime = $StringTime * 60000;
			SetValue($this->GetIDForIdent("CurrentStatus"), 1);
			$this->SetTimerInterval("SprinklerStringStop",$StringRunTime);
		}
		else if ($ActivationManual == 1) {
			$this->SendDebug($this->Translate('Group 1'),$this->Translate('Manual Timer: '.$StringTime.' for String '.$CurrentString.' with Name '.$CurrentStringName),0);
			$StringRunTime = $ActivationManualTimer * 60000;
			SetValue($this->GetIDForIdent("CurrentStatus"), 2);
			$this->SetTimerInterval("SprinklerStringStop",$StringRunTime);
		}

	}


	public function SprinklerStringStop() {

		$this->SendDebug($this->Translate('Group 1'),$this->Translate('**********************************'),0);		
		$CurrentString = GetValue($this->GetIDForIdent("CurrentString"));
		$CurrentStringName = $this->GetBuffer('CurrentStringName');	
		//$this->SendDebug($this->Translate('Group 1'),$this->Translate('Current String - Stop: '.$CurrentString),0);
		$ManualActivationSingleString = $this->GetBuffer("ManualActivationSingleString");

		$this->SendDebug($this->Translate('Group 1'),$this->Translate('Current String - Stop Sprinkler: '.$CurrentString.' with Name '.$CurrentStringName),0);		
		
		$arrCurrentStringValves = $this->ReadPropertyString("String".$CurrentString."ValveGroup");
		$arrValves = json_decode($arrCurrentStringValves);
		
		$i = 0;
		
		foreach ($arrValves as $valves) {
			$i++;
			$valve = $valves->InstanceID;
			RequestAction($valve, false);
		}

		$this->SetTimerInterval("SprinklerStringStop",0); // Stoppt timer

	
		$this->SendDebug($this->Translate('Group 1'),$this->Translate('String '.$CurrentString.' with Name'.$CurrentStringName.' has stopped watering'),0);
		$this->SendDebug($this->Translate('Manual Activation'),$this->Translate('Status Manual Activation ').$ManualActivationSingleString,0);
		

		switch ($CurrentString) {
		case 1:
			SetValue($this->GetIDForIdent("String1HasRun"), 1);
			if ($ManualActivationSingleString == 0) {
				SetValue($this->GetIDForIdent("CurrentString"), 2);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;

		case 2:
			SetValue($this->GetIDForIdent("String2HasRun"), 1);
			if ($ManualActivationSingleString == 0) {
				SetValue($this->GetIDForIdent("CurrentString"), 3);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;

		case 3:
			SetValue($this->GetIDForIdent("String3HasRun"), 1);
			if ($ManualActivationSingleString == 0) {
				SetValue($this->GetIDForIdent("CurrentString"), 4);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;

		case 4:
			SetValue($this->GetIDForIdent("String4HasRun"), 1);
			if ($ManualActivationSingleString == 0) {
				SetValue($this->GetIDForIdent("CurrentString"), 5);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;
		case 5:
			SetValue($this->GetIDForIdent("String5HasRun"), 1);
			if ($ManualActivationSingleString == 0) {
				SetValue($this->GetIDForIdent("CurrentString"), 6);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;
		case 6:
			SetValue($this->GetIDForIdent("String6HasRun"), 1);
			if ($ManualActivationSingleString == 0) { 
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;
		case 7:
			SetValue($this->GetIDForIdent("String7HasRun"), 1);
			if ($ManualActivationSingleString == 0) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;
		case 8:
			SetValue($this->GetIDForIdent("String8HasRun"), 1);
			if ($ManualActivationSingleString == 0) { 
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;
		case 9:
			SetValue($this->GetIDForIdent("String9HasRun"), 1);
			if ($ManualActivationSingleString == 0) { 
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;
		case 10:
			SetValue($this->GetIDForIdent("String10HasRun"), 1);
			if ($ManualActivationSingleString == 0) { 
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			else if ($ManualActivationSingleString == 1) {
				SetValue($this->GetIDForIdent("CurrentString"), 0);
			}
			$this->SprinklerOperation();
		break;
		}

	}


}