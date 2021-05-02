<?php

declare(strict_types=1);
	class SprinklerController extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->RegisterPropertyBoolean("ComponentActive", 0);
			$this->RegisterPropertyInteger("SensorRain",0);
			$this->RegisterPropertyBoolean("RainStopsIrrigation", 0);
			$this->RegisterPropertyInteger("SensorRainAmount",0);
			$this->RegisterPropertyInteger("SensorTemperature",0);
			$this->RegisterPropertyInteger("SensorHumidity",0);
			$this->RegisterPropertyInteger("SensorWind",0);
			$this->RegisterPropertyInteger("InformationRainInXDays",0);
			
			//Configuration
			$this->RegisterPropertyString("MethodToEstimateDryout", 1); //Soil humidity = default ... maybe in the future Evotranspiration


			//Definitions
			//Humidity
			$this->RegisterPropertyBoolean("HumiditySensorActive", 0);
			$this->RegisterPropertyInteger("SensorSoilHumidity", 0);
			$this->RegisterPropertyInteger("EstimateDryoutDryingThreshold", 20);
			$this->RegisterPropertyInteger("EstimateDryoutDryThreshold", 50);
			$this->RegisterPropertyInteger("Group1AutomaticActivationThresholdHumidity", 0);

			$this->RegisterPropertyInteger("RainInXDaysMinimumDryingOutThreshold", 15);
			$this->RegisterPropertyInteger("RainInXDaysMinimumDryThreshold", 40);

			$this->RegisterPropertyBoolean("WriteToLog",0);
			$this->RegisterPropertyBoolean("Notification",0); //To be fill with warning messages

			//Properties
			$this->RegisterTimer('Watchdog', 0, 'SC_Watchdog($_IPS["TARGET"]);'); //Timer to monitor things and perform frequent tasks
			$this->RegisterTimer('Evapotranspiration', 0, 'SC_Evapotranspiration($_IPS["TARGET"]);'); //Timer to monitor soil humidity and collect weather data

			if (IPS_VariableProfileExists("SC.SoilHumidity") == false) {
				IPS_CreateVariableProfile("SC.SoilHumidity", 1);
				IPS_SetVariableProfileIcon("SC.SoilHumidity", "Drops");
				IPS_SetVariableProfileAssociation("SC.SoilHumidity", 0, $this->Translate("Wet"), "", -1);
				IPS_SetVariableProfileAssociation("SC.SoilHumidity", 1, $this->Translate("Drying Out"), "", -1);
				IPS_SetVariableProfileAssociation("SC.SoilHumidity", 2, $this->Translate("Dry"), "", -1);
			}
	
			if (IPS_VariableProfileExists("SC.CurrentStatus") == false) {
				IPS_CreateVariableProfile("SC.CurrentStatus", 1);
				IPS_SetVariableProfileIcon("SC.CurrentStatus", "Gear");
				IPS_SetVariableProfileAssociation("SC.CurrentStatus", 0, $this->Translate("Inactive"), "", -1);
				IPS_SetVariableProfileAssociation("SC.CurrentStatus", 1, $this->Translate("Running Automatically"), "", -1);
				IPS_SetVariableProfileAssociation("SC.CurrentStatus", 2, $this->Translate("Running Manually"), "", -1);
			}
	
			if (IPS_VariableProfileExists("SC.ManualGroup") == false) {
				IPS_CreateVariableProfile("SC.ManualGroup", 1);
				IPS_SetVariableProfileIcon("SC.ManualGroup", "Gear");
				IPS_SetVariableProfileAssociation("SC.ManualGroup", 1, $this->Translate("Group 1"), "", -1);
				IPS_SetVariableProfileAssociation("SC.ManualGroup", 2, $this->Translate("Group 2"), "", -1);
			}
			
			if (IPS_VariableProfileExists("SC.StringRun") == false) {
				IPS_CreateVariableProfile("SC.StringRun", 1);
				IPS_SetVariableProfileIcon("SC.StringRun", "Gear");
				IPS_SetVariableProfileAssociation("SC.StringRun", 0, $this->Translate("No"), "", -1);
				IPS_SetVariableProfileAssociation("SC.StringRun", 1, $this->Translate("Yes"), "", -1);
				IPS_SetVariableProfileAssociation("SC.StringRun", 2, $this->Translate("Runnig"), "", -1);
			}
			
			if (IPS_VariableProfileExists("SC.MasterValve") == false) {
				IPS_CreateVariableProfile("SC.MasterValve", 0);
				IPS_SetVariableProfileIcon("SC.MasterValve", "Drops");
				IPS_SetVariableProfileAssociation("SC.MasterValve", 0, $this->Translate("Closed"), "", -1);
				IPS_SetVariableProfileAssociation("SC.MasterValve", 1, $this->Translate("Open"), "", -1);
			}
	
	
			if (IPS_VariableProfileExists("SC.GroupAutomaticActivation") == false) {
				IPS_CreateVariableProfile("SC.GroupAutomaticActivation", 1);
				IPS_SetVariableProfileIcon("SC.GroupAutomaticActivation", "Robot");
				IPS_SetVariableProfileAssociation("SC.GroupAutomaticActivation", 0, $this->Translate("No Automation"), "", -1);
				IPS_SetVariableProfileAssociation("SC.GroupAutomaticActivation", 1, $this->Translate("Auto Enabled"), "", -1);
				IPS_SetVariableProfileAssociation("SC.GroupAutomaticActivation", 2, $this->Translate("Auto Disabled"), "", -1);
			}
	
			if (IPS_VariableProfileExists("SC.ManualString") == false) {
				IPS_CreateVariableProfile("SC.ManualString", 1);
				IPS_SetVariableProfileIcon("SC.ManualString", "Gear");
				IPS_SetVariableProfileAssociation("SC.ManualString", 0, $this->Translate("Alle Strings"), "", -1);
				IPS_SetVariableProfileAssociation("SC.ManualString", 1, $this->Translate("String 1"), "", -1);
				IPS_SetVariableProfileAssociation("SC.ManualString", 2, $this->Translate("String 2"), "", -1);
				IPS_SetVariableProfileAssociation("SC.ManualString", 3, $this->Translate("String 3"), "", -1);
				IPS_SetVariableProfileAssociation("SC.ManualString", 4, $this->Translate("String 4"), "", -1);
				IPS_SetVariableProfileAssociation("SC.ManualString", 5, $this->Translate("String 5"), "", -1);
				IPS_SetVariableProfileAssociation("SC.ManualString", 6, $this->Translate("String 6"), "", -1);
			}
			
			if (IPS_VariableProfileExists("SC.Timer") == false) {
				IPS_CreateVariableProfile("SC.Timer", 1);
				IPS_SetVariableProfileIcon("SC.Timer", "Clock");
				IPS_SetVariableProfileDigits("SC.Timer", 0);
				IPS_SetVariableProfileValues("SC.Timer", 0, 60, 1);
			}
	
			//$this->RegisterVariableBoolean('ManualActivationSprinkler', $this->Translate('WF Manual Sprinkler Activation'),"~Switch");		
			//$this->RegisterVariableInteger('ManualActivationRunTime', $this->Translate('WF Manual Sprinkler Runtime'),"SC.Timer");
			//$this->RegisterVariableInteger('ManualActivationGroup', $this->Translate('WF Manual Sprinkler Group'),"SC.ManualGroup");
			//$this->RegisterVariableInteger('ManualActivationString', $this->Translate('WF Manual Sprinkler String'),"SC.ManualString");
			//$this->RegisterVariableBoolean('ManualBlockSprinkler', $this->Translate('WF Manual Sprinkler Block'),"~Switch");
			$this->RegisterVariableInteger('Group1CurrentStatus', $this->Translate('Group 1 Current Status'),"SC.CurrentStatus");
			$this->RegisterVariableBoolean('CurrentRainBlockIrrigation', $this->Translate('Irrigation blocked by rain'), "~Switch");
			//$this->RegisterVariableInteger('Group1AutomaticActivation', $this->Translate('Group 1 Automation'),"SC.GroupAutomaticActivation");				
			$this->RegisterVariableInteger('SoilHumidity', $this->Translate('Soil Humidity'), "SC.SoilHumidity");
			$this->RegisterVariableFloat('Evapotranspiration', $this->Translate('Evapotranspiration Grass'),"~Rainfall");
			//$this->RegisterVariableString('SprinklerDescisionText', $this->Translate('Sprinkler Descision Text'));	
			//$this->RegisterVariableInteger('Group1CurrentString', $this->Translate('Group 1 Current String'));
			//$this->RegisterVariableBoolean('Group1MasterValve1', $this->Translate('Group 1 Master Valve 1'),"SC.MasterValve");
			//$this->RegisterVariableBoolean('Group1MasterValve2', $this->Translate('Group 1 Master Valve 2'),"SC.MasterValve");
			//$this->RegisterVariableInteger('Group1String1HasRun', $this->Translate('Group 1 String 1 Has Run'),"SC.StringRun");
			//$this->RegisterVariableInteger('Group1String2HasRun', $this->Translate('Group 1 String 2 Has Run'),"SC.StringRun");
			//$this->RegisterVariableInteger('Group1String3HasRun', $this->Translate('Group 1 String 3 Has Run'),"SC.StringRun");
			//$this->RegisterVariableInteger('Group1String4HasRun', $this->Translate('Group 1 String 4 Has Run'),"SC.StringRun");
			//$this->RegisterVariableInteger('Group1String5HasRun', $this->Translate('Group 1 String 5 Has Run'),"SC.StringRun");					
			//$this->RegisterVariableInteger('Group1String6HasRun', $this->Translate('Group 1 String 6 Has Run'),"SC.StringRun");
			
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

			$ComponentActive = $this->ReadPropertyBoolean("ComponentActive");

			if ($ComponentActive == 1) {
				$this->SetTimerInterval("Watchdog",10000);
				$this->SetTimerInterval("Evapotranspiration",18000000);
				$now = new DateTime();
				$target = new DateTime();
				if ("14:00:00" < date("H:i")) {
					$target->modify('+1 day');
				}
				$target->setTime(14, 00, 0);
				$diff = $target->getTimestamp() - $now->getTimestamp();
				$EvaTimer = $diff * 1000;
				$this->SetTimerInterval('Evapotranspiration', $EvaTimer);
			}
			else if ($ComponentActive == 0) {
				$this->SetTimerInterval("Watchdog",0);
				$this->SetTimerInterval("Evapotranspiration",0);
			}

		}

		public function Evapotranspiration() {

			$temp=GetValue($this->ReadPropertyInteger("SensorTemperature"));
			$feucht=GetValue($this->ReadPropertyInteger("SensorHumidity"));
	
			$z1=7.602*$temp;
			$z2=241.2+$temp;
			$satt = 6.11213 * pow(10,($z1/$z2)); //Sttigungsdampfdruck
			$dampf = ($satt * $feucht) / 100;  //Wasserdampfdruck
			$sattdef = $satt - $dampf;    //Sttigungsdefizit
			$verdunst = 0.24 * $sattdef;  //Verdunstungsrate pro Tag
			$verdunst = round($verdunst, 2);
			if ($verdunst > 7) {
			$verdunst = 7;
			}
			SetValue($this->GetIDForIdent("Evapotranspiration"), (FLOAT)$verdunst);
	
		}
	
		public function Watchdog() {
	
			$Notification = $this->ReadPropertyBoolean("Notification");
			$WriteToLog = $this->ReadPropertyBoolean("WriteToLog");
			$CurrentString = GetValue($this->GetIDForIdent("Group1CurrentString"));
			
			$this->DisableIrrigationDueToRainForecast(); // evaluates the needed rain in case it is due to rain in x days to deactivate automatic irrigation
			$this->RainInLastHour();
			$this->AutomaticActivationDeactivation();
			$this->EstimateSoilWetness();
			
			$SensorRain = GetValue($this->ReadPropertyInteger("SensorRain"));
			$CurrentRainBlockIrrigation = GetValue($this->GetIDForIdent("CurrentRainBlockIrrigation"));
			$Group1CurrentString = GetValue($this->GetIDForIdent("Group1CurrentString"));
	
			if ($SensorRain == 1  AND $CurrentRainBlockIrrigation ==  0 AND $CurrentString > 0) { // it rains ... stop operation
				$this->SendDebug($this->Translate('Current Rain'),$this->Translate('Rain detected - irrigation is stopped'),0);
				$this->SetTimerInterval("Group1SprinklerStringStop",0); //stops timer
				SetValue($this->GetIDForIdent("CurrentRainBlockIrrigation"), 1);
				$this->SetBuffer("RainStoppedAtGroup1String", $Group1CurrentString);
				//SetValue($this->GetIDForIdent("SprinklerDescisionText"),"Irrigation stopped due to rain at String: ".$Group1CurrentString,0);
				$this->Group1SprinklerStringStop();
			}
			else if ($SensorRain == 0 AND $CurrentRainBlockIrrigation == 1 AND $CurrentString > 0) { // rain has stopped ... evaluate if further watering is need by soil humidity or amount of rain fallen
				$this->SendDebug($this->Translate('Current Rain'),$this->Translate('************************************'),0);
				SetValue($this->GetIDForIdent("CurrentRainBlockIrrigation"), 0);
				$CurrentRainBlocksIrrigation = $this->GetBuffer("CurrentRainBlocksIrrigation");
	
				if ($CurrentRainBlocksIrrigation == 1) {
					$this->SendDebug($this->Translate('Current Rain'),$this->Translate('Rain has stopped - no further irrigation needed'),0);
					SetValue($this->GetIDForIdent("Group1CurrentString"), 0); // places current string into waiting state = 0
					if ($WriteToLog == 1) {
						IPS_LogMessage("Beregnungssteuerung", "Regen hat aufgehört - Beregnung wird aufgrund von ausreichend Regen nicht fortgesetzt");							
					}
					$this->SprinklerOperationGroup1();
				}
				else if ($CurrentRainBlocksIrrigation == 0 ) {
					//Get from buffer where irrigation stopped
					$this->SendDebug($this->Translate('Current Rain'),$this->Translate('Rain has stopped - not enough rain - irrigation will continue'),0);
					$RainStoppedAtGroup1String = $this->GetBuffer("RainStoppedAtGroup1String");
					SetValue($this->GetIDForIdent("Group1CurrentString"), $RainStoppedAtGroup1String);
					if ($WriteToLog == 1) {
						IPS_LogMessage("Beregnungssteuerung", "Regen hat aufgehört - Es hat nicht ausreichend geregnet um Boden zu bewässern, Beregnung wird fortgesetzt");						
					}
					$this->SprinklerOperationGroup1();
				}
			}
			
	
			//set via webfront and will block any sprinkler operation until disabled
			//**********************************************************************
	
			$ManualBlockSprinkler = GetValue($this->GetIDForIdent("ManualBlockSprinkler"));
			
			if ($ManualBlockSprinkler == 1) { 
				$this->SetTimerInterval("Group1SprinklerStringStop",0); //stops timer
				/*
				if ($WriteToLog == 1 AND $LogManualBlockSprinkler == 0 ) {
					IPS_LogMessage("Beregnungssteuerung", "!!! Manuelle Blockade der Beregnung - alle Vorgänge wurden unterbrochen");
					$LogManualBlockSprinkler = 1;
				}
				*/
				$this->Group1SprinklerStringStop();
			}
			else if ($ManualBlockSprinkler == 0) {
				/*
				if ($WriteToLog == 1 AND $LogManualBlockSprinkler == 1) {
					IPS_LogMessage("Beregnungssteuerung", "!!! Manuelle Blockade der Beregnung aufgehoben");
					$LogManualBlockSprinkler = 0;
				}
				*/
			}
	
	
			//manually start sprinkler via webfront
			//*************************************
	
			$ManualActivationSprinkler = GetValue($this->GetIDForIdent("ManualActivationSprinkler"));
			$ManualActivationRunTime = GetValue($this->GetIDForIdent("ManualActivationRunTime"));
			$ManualActivationGroup = GetValue($this->GetIDForIdent("ManualActivationGroup"));
			$ManualActivationString = GetValue($this->GetIDForIdent("ManualActivationString"));
			$Group1CurrentStatus = GetValue($this->GetIDForIdent("Group1CurrentStatus"));
					
			if ($ManualActivationSprinkler == 1){
				if ($ManualActivationGroup == 1) {
					if ($ManualActivationString == 0) {
						//starte bei String 0
						SetValue($this->GetIDForIdent("Group1CurrentString"), 0);
						$this->SetBuffer("Group1ActivationManual", 1);
						$this->SetBuffer("Group1ActivationManualTimer", $ManualActivationRunTime);
						if ($WriteToLog == 1) {
							IPS_LogMessage("Beregnungssteuerung", "!!! Manueller Start der Beregnung - Alle Abschnitte werden für ".$ManualActivationRunTime." Minuten beregnet");
						}
						$this->SendDebug($this->Translate('Manual Activation'),$this->Translate('All Strings'),0);
						SetValue($this->GetIDForIdent("Group1CurrentStatus"), 2);
						SetValue($this->GetIDForIdent("ManualActivationSprinkler"), 0);
						$this->SprinklerOperationGroup1();
					}
					else if ($ManualActivationString > 0) { //will only run 1 specific string
						SetValue($this->GetIDForIdent("Group1CurrentString"), $ManualActivationString);
						$this->SetBuffer("Group1ManualActivationSingleString", 1);
						$this->SetBuffer("Group1ActivationManual", 1);
						$this->SetBuffer("Group1ActivationManualTimer", $ManualActivationRunTime);
						SetValue($this->GetIDForIdent("ManualActivationSprinkler"), 0); // in case irrigation was manually started
						if ($WriteToLog == 1) {
							IPS_LogMessage("Beregnungssteuerung", "!!! Manueller Start der Beregnung - Abschnitt ".$ManualActivationString." wird für ".$ManualActivationRunTime." Minuten beregnet");
						}
						//$this->SendDebug($this->Translate('Manual Activation'),$this->Translate('Single String Number: ').$ManualActivationString,0);
						SetValue($this->GetIDForIdent("Group1CurrentStatus"), 2);
						$this->SprinklerOperationGroup1();
					}
				}
				// Activation for Group 2 goes here
			}
			
			else if ($ManualActivationSprinkler == 0 AND $Group1CurrentStatus == 0){ // set manual buffer variables with 0 to avoid empty values
				$this->SetBuffer("Group1ManualActivationSingleString", 0);
				$this->SetBuffer("Group1ActivationManual", 0);
				$this->SetBuffer("Group1ActivationManualTimer", 0);
			}
			
	
			
		}
		
	
		//function enables or disables automatic execution of watering
		//************************************************************
	
		public function AutomaticActivationDeactivation() {
	
			$Notification = $this->ReadPropertyBoolean("Notification");
			$WriteToLog = $this->ReadPropertyBoolean("WriteToLog");
	
			$DescissionSoilHumidity = $this->GetBuffer("SoilHumidity"); //0 Wet, 1 Drying out, 2 dry
			$DescissionFutureRainBlocksIrrigation = $this->GetBuffer("FutureRainBlocksIrrigation");
			
			$Group1AutomaticActivationThresholdHumidity = $this->ReadPropertyInteger("Group1AutomaticActivationThresholdHumidity");
			$Group1AutomaticActivationThresholdHumidityCurrentStatus = GetValue($this->GetIDForIdent("Group1AutomaticActivation"));
			$SensorSoilHumidity = GetValue($this->ReadPropertyInteger("SensorSoilHumidity"));
	
			if ($Group1AutomaticActivationThresholdHumidity == 0) {
				//Automatic activation of Group 1 is disabled
				//$this->SendDebug($this->Translate('Automation'),$this->Translate('Automatic Group Activation disabled'),0);
				SetValue($this->GetIDForIdent("Group1AutomaticActivation"), 0);
				$Group1AutomaticMode = 0;
			}
			else if ($Group1AutomaticActivationThresholdHumidity !== 0) {
				if ($SensorSoilHumidity > $Group1AutomaticActivationThresholdHumidity) {
					//$this->SendDebug($this->Translate('Automation'),$this->Translate('Automatic Group Activation enabled and turned ON since above threshold'),0);
					if ($Group1AutomaticActivationThresholdHumidityCurrentStatus !== 1) {
						if ($WriteToLog == 1) {
							//IPS_LogMessage("Beregnungssteuerung", "Gruppe 1 automatisch aktiviert - Bodenfeuchte ".$SensorSoilHumidity." Schwellwert ".$Group1AutomaticActivationThresholdHumidity);
						}
						if ($Notification == 1) {
							$this->SetBuffer("NotifierTitle", "Beregnungssteuerung");
							$this->SetBuffer("NotifierMessage", "Gruppe 1 automatisch aktiviert");
							$this->NotifyApp();
						}
					}
					$Group1AutomaticMode = 1;
					SetValue($this->GetIDForIdent("Group1AutomaticActivation"), 1);
					//Soil in Group 1 is above group threshold => Turn on
				}
				else if ($SensorSoilHumidity <= $Group1AutomaticActivationThresholdHumidity) {
					//$this->SendDebug($this->Translate('Automation'),$this->Translate('Automatic Group Activation enabled and turned OFF since below threshold'),0);
					if ($Group1AutomaticActivationThresholdHumidityCurrentStatus !== 2) {
						if ($WriteToLog == 1) {
							//IPS_LogMessage("Beregnungssteuerung", "Gruppe 1 automatisch deaktiviert - Bodenfeuchte ".$SensorSoilHumidity." Schwellwert ".$Group1AutomaticActivationThresholdHumidity);
						}
						if ($Notification == 1) {
							$this->SetBuffer("NotifierTitle", "Beregnungssteuerung");
							$this->SetBuffer("NotifierMessage", "Gruppe 1 automatisch deaktiviert");
							$this->NotifyApp();
						}
					}
					$Group1AutomaticMode = 2;
					SetValue($this->GetIDForIdent("Group1AutomaticActivation"), 2);
					//Soil in Group 1 is below group threshold => Turn off
				}
			}
	
	
			if ($DescissionSoilHumidity == 0) { //soil is wet - no irrigation needed
				//$this->SendDebug($this->Translate('Automation'),$this->Translate('Soil is wet ... no irrigation needed'),0);
				$this->SetTimerInterval('SprinklerOperationGroup1', 0);
			}
			else if ($DescissionSoilHumidity > 0) {
				if ($DescissionFutureRainBlocksIrrigation == 0 AND $Group1AutomaticMode == 1) { //soil is dry - no rain inbound => irrigate
					//$this->SendDebug($this->Translate('Automation'),$this->Translate('Soil is dry ... automatic irrigation turned on group activation ENABLED'),0);
					$this->SetResetTimerInterval();
				}
				if ($DescissionFutureRainBlocksIrrigation == 1 OR $Group1AutomaticMode == 2) {  //soil is dry - rain is inbound => stop irrigation
					//$this->SendDebug($this->Translate('Automation'),$this->Translate('Soil is dry ... rain is inbound or automatic group activation disabled => stop irrigation'),0);
					$this->SetTimerInterval('SprinklerOperationGroup1', 0);
				}
			}
	
		}
			
		//function check how dry the soil is
		//**********************************
	
		public function EstimateSoilWetness() {
	
			$Notification = $this->ReadPropertyBoolean("Notification");
			$WriteToLog = $this->ReadPropertyBoolean("WriteToLog");
	
			$SensorSoilHumidty = GetValue($this->ReadPropertyInteger("SensorSoilHumidity"));
			$EstimateDryoutDryingThreshold = $this->ReadPropertyInteger("EstimateDryoutDryingThreshold");
			$EstimateDryoutDryThreshold = $this->ReadPropertyInteger("EstimateDryoutDryThreshold");
			$CurrentStatusSoilHumidity = GetValue($this->GetIDForIdent("SoilHumidity"));
			
			$Group1AutomaticActivationThresholdHumidity = $this->ReadPropertyInteger("Group1AutomaticActivationThresholdHumidity");
	
			if ($SensorSoilHumidty < $EstimateDryoutDryingThreshold) {
				//$this->SendDebug($this->Translate('Soil Humidity'),$this->Translate('Soil Humidity Sensor: ').$SensorSoilHumidty.$this->Translate(' cb - translates to soil is wet'),0);
				if ($CurrentStatusSoilHumidity !== 0) {
					SetValue($this->GetIDForIdent("SoilHumidity"), 0);
					if ($WriteToLog == 1) {
						IPS_LogMessage("Beregnungssteuerung", "Bodenfeuchte hat gewechselt auf feucht");
					}
					if ($Notification == 1) {
						$this->SetBuffer("NotifierTitle", "Beregnungssteuerung");
						$this->SetBuffer("NotifierMessage", "Bodenfeuchte hat gewechselt auf feucht");
						$this->NotifyApp();
					}
				}
				$this->SetBuffer("SoilHumidity", 0); //Sprinkler Mode??
			}
			else if ($SensorSoilHumidty >= $EstimateDryoutDryingThreshold AND $SensorSoilHumidty <= $EstimateDryoutDryThreshold) {
				//$this->SendDebug($this->Translate('Soil Humidity'),$this->Translate('Soil Humidity Sensor: ').$SensorSoilHumidty.$this->Translate(' cb - translates to soil is drying out'),0);
				if ($CurrentStatusSoilHumidity !== 1) {
					SetValue($this->GetIDForIdent("SoilHumidity"), 1);
					if ($WriteToLog == 1) {
						IPS_LogMessage("Beregnungssteuerung", "Bodenfeuchte hat gewechselt auf trocknet aus");
					}
					if ($Notification == 1) {
						$this->SetBuffer("NotifierTitle", "Beregnungssteuerung");
						$this->SetBuffer("NotifierMessage", "Bodenfeuchte hat gewechselt auf trocknet aus");
						$this->NotifyApp();
					}
				}	
				$this->SetBuffer("SoilHumidity", 1);
			}
			else if ($SensorSoilHumidty > $EstimateDryoutDryThreshold) {
				//$this->SendDebug($this->Translate('Soil Humidity'),$this->Translate('Soil Humidity Sensor: ').$SensorSoilHumidty.$this->Translate(' cb - translates to soil is dry'),0);
				if ($CurrentStatusSoilHumidity !== 2) {
					SetValue($this->GetIDForIdent("SoilHumidity"), 2);
					if ($WriteToLog == 1) {
						IPS_LogMessage("Beregnungssteuerung", "Bodenfeuchte hat gewechselt auf trocken");
					}
					if ($Notification == 1) {
						$this->SetBuffer("NotifierTitle", "Beregnungssteuerung");
						$this->SetBuffer("NotifierMessage", "Bodenfeuchte hat gewechselt auf trocken");
						$this->NotifyApp();
					}
				}
				$this->SetBuffer("SoilHumidity", 2);
			}
		}
	
		//function disables irrigation when rain starts 
		//*********************************************
	
		public function DisableIrrigationDueToRainForecast() {
			$SoilCurrentStatus = $this->GetBuffer("SoilHumidity");
			$EstimateDryoutDryingOutThreshold = $this->ReadPropertyInteger("RainInXDaysMinimumDryingOutThreshold");
			$EstimateDryoutDryingThreshold = $this->ReadPropertyInteger("RainInXDaysMinimumDryThreshold");
			$InformationRainInXDays = GetValue($this->ReadPropertyInteger("InformationRainInXDays"));
			
		
			switch ($SoilCurrentStatus) {
				case 0: //boden nass
					//$this->SendDebug($this->Translate('Estimated Rain'),$this->Translate('Soil wet - incoming rain will be ignored'),0);
					$this->SetBuffer("FutureRainBlocksIrrigation", 1);
				break;
					
				case 1: //boden trocknet aus
					if ($InformationRainInXDays > $EstimateDryoutDryingOutThreshold ){
						//$this->SendDebug($this->Translate('Estimated Rain'),$this->Translate('Amount: ').$InformationRainInXDays.$this->Translate(' mm - enough to water the soil which is currently drying out'),0);
						$this->SetBuffer("FutureRainBlocksIrrigation", 1);
					}
					else {
						//$this->SendDebug($this->Translate('Estimated Rain'),$this->Translate('Amount: ').$InformationRainInXDays.$this->Translate(' mm - no or not enough rain in the coming days - IRRIGATION NEEDED'),0);
						$this->SetBuffer("FutureRainBlocksIrrigation", 0);
					}
				break;
	
				case 2: //boden trocken
					if ($InformationRainInXDays > $EstimateDryoutDryingThreshold ){
						//$this->SendDebug($this->Translate('Estimated Rain'),$this->Translate('Amount: ').$InformationRainInXDays.$this->Translate(' mm - enough to water the soil which is currently dry'),0);
						$this->SetBuffer("FutureRainBlocksIrrigation", 1);
					}
					else {
						//$this->SendDebug($this->Translate('Estimated Rain'),$this->Translate('Amount: ').$InformationRainInXDays.$this->Translate(' mm - no or not enough rain in the coming days - IRRIGATION NEEDED'),0);
						$this->SetBuffer("FutureRainBlocksIrrigation", 0);
					}
				break;
			}
		}
	
	
		// Checks if enough rain has fallen to interupt irrigation
		//********************************************************
	
		public function RainInLastHour() { 
			$archiveID = IPS_GetInstanceListByModuleID('{43192F0B-135B-4CE7-A0A7-1475603F3060}')[0];
			$SensorRainAmount = $this->ReadPropertyInteger("SensorRainAmount");
			$DelayTime = 3600; //Regen in einer Stunde
	
				$endtime = time(); // time() for "now"
				$starttime = time()-($DelayTime); // for n minutes ago
				$limit = 0; // kein Limit
	
				$buffer = AC_GetLoggedValues($archiveID, $SensorRainAmount, $starttime, $endtime, $limit);
				$anzahl = 0;
				$summe = 0;
				foreach ($buffer as $werte){
					$wert = $werte["Value"];
					$anzahl = $anzahl +1;
					$summe = $summe + $wert;
				}
				if ($anzahl > 1) {
					$RainAmount = $summe;
					//$this->SendDebug($this->Translate('Rain Amount'),'Rain fall in 1 hour '.$summe.' mm',0);
					$this->SetBuffer("RainAmount", $RainAmount);
				}
				else {
					$RainAmount = 0;
					//$this->SendDebug($this->Translate('Rain Amount'),'No rain in past hour',0);
				}
	
			$SoilCurrentStatus = $this->GetBuffer("SoilHumidity");
			$EstimateDryoutDryingOutThreshold = $this->ReadPropertyInteger("RainInXDaysMinimumDryingOutThreshold");
			$EstimateDryoutDryingThreshold = $this->ReadPropertyInteger("RainInXDaysMinimumDryThreshold");
			
		
			switch ($SoilCurrentStatus) {
				case 0: //boden nass
					$this->SendDebug($this->Translate('Fallen Rain'),$this->Translate('Soil wet - rain will be ignored'),0);
					$this->SetBuffer("CurrentRainBlocksIrrigation", 1);
				break;
					
				case 1: //boden trocknet aus
					if ($RainAmount > $EstimateDryoutDryingOutThreshold ){
						//$this->SendDebug($this->Translate('Fallen Rain'),$this->Translate('Amount: ').$RainAmount.$this->Translate(' mm - enough to water the soil which is currently drying out'),0);
						$this->SetBuffer("CurrentRainBlocksIrrigation", 1);
					}
					else {
						//$this->SendDebug($this->Translate('Fallen Rain'),$this->Translate('Amount: ').$RainAmount.$this->Translate(' mm - no or not enough rain in the coming days - IRRIGATION NEEDED'),0);
						$this->SetBuffer("CurrentRainBlocksIrrigation", 0);
					}
				break;
	
				case 2: //boden trocken
					if ($RainAmount > $EstimateDryoutDryingThreshold ){
						//$this->SendDebug($this->Translate('Fallen Rain'),$this->Translate('Amount: ').$RainAmount.$this->Translate(' mm - enough to water the soil which is currently dry'),0);
						$this->SetBuffer("CurrentRainBlocksIrrigation", 1);
					}
					else {
						//$this->SendDebug($this->Translate('Fallen Rain'),$this->Translate('Amount: ').$RainAmount.$this->Translate(' mm - no or not enough rain in the coming days - IRRIGATION NEEDED'),0);
						$this->SetBuffer("CurrentRainBlocksIrrigation", 0);
					}
				break;
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

	}