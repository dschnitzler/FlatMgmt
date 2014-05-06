<?php

function ConnectDb()
{
return new PDO('sqlite:/var/databases/apartment_manager.sqlite');
}

function WriteHeader($title, $topic)
{
	$moduls = Moduls::createModuls();
	$html ="<!DOCTYPE html>
			<html>
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
			<title>".$title."</title>
			<link rel=\"stylesheet\" type=\"text/css\" href=\"../stylesheets/stylesheet_".$topic.".css\">
			</head>
			<body>
			<div id='container'>
			<div id='header'>
			<b>Wohnungs<br>Verwaltung</b>
			</div>
			<div id='trim'>
			&nbsp;
			<div id='menu'>";
	$html.= $moduls->getMenu();		
	$html.=	/*"	<ul>
					<li>
						<a href='index.php'>&Uuml;bersicht</a>
						<ul>
							<a href='index_energy.php'>Energie</a>
							<a href='index_money.php'>Finanzen</a>
						</ul>
					</li> | 
					<li> Eingabe
						<ul>
							<li><a href='input_energy.php?item=strom'>Strom</a></li>
							<li><a href='input_energy.php?item=gas'>Gas</a></li>
							<li><a href='input_money.php'>Finanzen</a></li>
						</ul>
					</li>
				</ul>*/
			"</div>
			<div id='login'>
			</div>
			</div>
			<div id=\"content\">
			<h1>".$title."</h1>";
	return $html;
}

function WriteFooter()
{
	$html = "</div>
			<div id=\"footer\">
			<a href=\"../modul_standard/release_notes.php\">Version 3.0.0</a> | 
			&copy; Daniel Schnitzler
			<br> Hosted on <a href=\"http://raspberrypi.org\">Raspberry Pi</a>
			</div>
			</div>
			</body>
			</html>
			";
	return $html;
}

function WriteError($message)
{
	$html="<div id='template_error'>
			<b>Es ist ein Fehler aufgetreten!</b><br>
		".$message
		."</div>";
	return $html;
}

function WriteOK($message)
{
	$html="<div id='template_ok'>
			<b> Vorgang erfolgreich ausgef&uuml;hrt! </b><br>
		".$message
		."</div>";
	return $html;
}

function FindIndex($array, $value)
{
	for($i = 0; $i < sizeof($array); $i++)
	{
		if ($value==$array[$i])
			return $i;
	}
	return -1;
}

function LookupTelephoneCost($date)
{
	$value = 0;
	
	$db = ConnectDB();
	$lookup_telephones1 = $db->query("SELECT telephone_startdate, telephone_cost FROM telephone");
	$lookup_telephone = $lookup_telephones1->fetchAll();
	
	for ($i = 0; $i < sizeof($lookup_telephone); $i++)
	{
		if ($date >= new DateTime($lookup_telephone[$i]['telephone_startdate']))
			$value = $lookup_telephone[$i]['telephone_cost'];
	}
	return $value;
}

function GetAverageStrom($start_date, $end_date)
{
	$db 		= ConnectDB();
	$result1 	= $db->query("SELECT * FROM electricity WHERE date >= '".$start_date."' AND date <'".$end_date."' ORDER BY date asc");
	$rows1 		= $result1->fetchAll();
	$date_min		= $rows1[0]['date'];
	$value_min		= $rows1[0]['value'];
	$datetime_min 	= new DateTime($date_min);

	$date_max		= $rows1[sizeof($rows1)-1]['date'];
	$value_max		= $rows1[sizeof($rows1)-1]['value'];
	$datetime_max 	= new DateTime($date_max);

	$interval  		= date_diff($datetime_min, $datetime_max);
	$average	= ($value_max - $value_min)/($interval->format('%a'));
	
	$sum = 0;
	for ($i = 1; $i < sizeof($rows1); $i += 1)
	{
		$cur_interval 	 = date_diff(new DateTime($rows1[$i]['date']),new DateTime($rows1[$i-1]['date']));
		$sum 			+= pow(($rows1[$i]['value']-$rows1[$i-1]['value'])/($cur_interval->format('%a'))-$average, 2)*$cur_interval->format('%a');
	}
	$std = sqrt(1/((sizeof($rows1)-1)-1) * $sum);
	
	return array($average, $std);
}

function GetAverageGas($start_date, $end_date)
{
	$db 			= ConnectDB();
	$result1 		= $db->query("SELECT * FROM gas WHERE date >= '".$start_date."' AND date <'".$end_date."' ORDER BY date asc");
	$rows1 			= $result1->fetchAll();

	$date_min		= $rows1[0]['date'];
	$value_min		= $rows1[0]['value'];
	$datetime_min 	= new DateTime($date_min);

	$date_max		= $rows1[sizeof($rows1)-1]['date'];
	$value_max		= $rows1[sizeof($rows1)-1]['value'];
	$datetime_max 	= new DateTime($date_max);

	$interval  		= date_diff($datetime_min, $datetime_max);
	$average	= ($value_max - $value_min)/($interval->format('%a'));
	
	$sum = 0;
	for ($i = 0; $i < sizeof($rows1); $i += 1)
	{
		$sum += pow(($rows1[$i]['value']-$average), 2);
	}
	$std = sqrt(1/(sizeof($rows1)-1) * $sum);
	
	return array($average, $std);
}

function ConvertGasFromM3ToKwh($value)
{
	$z_zahl  = 0.9524;
	$AB_wert = 11.160; 

	$average_kWh 	= $value * $z_zahl * $AB_wert;
	return $average_kWh;
}

function GetCostStromStawag($average_gen)
{
	
	//StromSta(R) OekoPlus
	if($average_gen * 365 <= 2800)
	{
		$arbeitspreis 	= 27.64;
		$grundpreis 	= 73.02;
	} 
	elseif($average_gen * 365 <= 6000)
	{
		$arbeitspreis 	= 26.97;
		$grundpreis 	= 92.02;
	}
	elseif($average_gen * 365 <= 9000)
	{
		$arbeitspreis 	= 26.85;
		$grundpreis 	= 99.16;
	}
	elseif($average_gen * 365 <= 12000)
	{
		$arbeitspreis 	= 26.75;
		$grundpreis 	= 107.73;
	}
	else
	{
		$arbeitspreis 	= 26.67;
		$grundpreis 	= 117.73;
	}
	
	$cost = $grundpreis/12 + $average_gen*30*$arbeitspreis/100;
	return(round($cost,2));
}

function GetCostGasStawag($average_kWh)
{	
	//GasSta(R) OekoPlus
	if($average_kWh * 365 <= 5384)
	{
		$arbeitspreis 	= 8.94;
		$grundpreis 	= 39.98;
	} 
	elseif($average_kWh * 365 <= 12280)
	{
		$arbeitspreis 	= 7.10;
		$grundpreis 	= 138.66;
	}
	else
	{
		$arbeitspreis 	= 6.75;
		$grundpreis 	= 182.50;
	}
	
	$cost = $grundpreis/12 + $average_kWh*30*$arbeitspreis/100; // Grundpreis/(12 Monate) + Tagesdurchschnitt*30Tage*Arbeitspreis in Cent
	return(round($cost, 2));
}
/*****************************************************************************************************************************************
*****************************************************************************************************************************************/
class Modul
{
	public $name;
	public $menu;
	private $folder_name;
	
	public function MenuToHTML()
	{
		return $this->menu;
	}
}

class Moduls
{
	private static $instance;
	private $moduls;

    	private function __construct()
    	{
		$modul_standard 		= new Modul;
		$modul_standard->name 	= "Standard";
		$modul_standard->menu	= "<li>
										<a href='../modul_standard/index.php'> Standard</a>
										<ul>
											<li><a href='../modul_standard/action.php?action=restart'>Neustart</a></li>
											<li><a href='../modul_standard/action.php?action=shutdown'>Herunterfahren</a></li>
										</ul>
									</li>";

		$modul_energy 			= new Modul;
		$modul_energy->name 	= "Energie";
		$modul_energy->menu		= "<li>
										<a href='../modul_energy/index.php'>Energie</a>
										<ul>
											<li><a href='../modul_energy/input_energy.php?item=strom'>Eingabe Strom</a></li>
											<li><a href='../modul_energy/input_energy.php?item=gas'>Eingabe Gas</a></li>	
										</ul>
									</li>";

		$modul_finance 			= new Modul;
		$modul_finance->name 	= "Finanzen";
		$modul_finance->menu	= "<li>
										<a href='../modul_finance/index.php'>Finanzen</a>
										<ul>
											<li><a href='../modul_finance/input_money.php'>Eingabe Finanzen</a></li>
										</ul>
									</li>";

		$modul_automation 			= new Modul;
		$modul_automation->name 	= "Automation";
		$modul_automation->menu		= "<li>
										<a href='../modul_automation/index.php'>Automation</a>
										<ul>
											<li><a href='../modul_automation/configuration.php'>Konfiguration</a></li>
										</ul>
									</li>";

		$this->moduls   = array();
		$this->moduls[] = $modul_standard;
		$this->moduls[] = $modul_energy;
		$this->moduls[] = $modul_finance;
		$this->moduls[] = $modul_automation;
		
    	}

    	public static function createModuls()
    	{
      		if (!isset(self::$instance)) 
		{
            		$className = __CLASS__;
            		self::$instance = new $className;
        	}
        	return self::$instance;
    	}

	public function getMenu()
	{
		$html = "<ul>";
		for ($i = 0; $i < count($this->moduls); $i++)
		{
			$html .= $this->moduls[$i]->MenuToHTML();
		}
		$html .="</ul>";
		return $html;
	}
}
?>
