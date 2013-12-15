<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');

$html = "";
$head = "";
	
if (!isset($_GET['action']))
{
	$head = "Fehler";
	$html = WriteError("Es wurde keine Aktion angegeben.");
}
else
{
	$action = $_GET['action'];
	switch ($action)
	{
		case ("input_gas"):
			$head = "Eingabe eines Gasz&auml;hlerstandes";
			$html = input_gas($html);
			$topic= "energy";
			break;
		case ("input_strom"):
			$head = "Eingabe eines Stromz&auml;hlerstandes";
			$html = input_strom($html);
			$topic= "energy";
			break;
		case ("input_money"):
			$head = "Eingabe von Finanzen";
			$html = input_money($html);
			$topic= "money";
			break;
		default:
			$head = "Fehler";
			$html = WriteError("Angegebene Aktion nicht bekannt.");
			$topic = "general";
			break;
	}
}

echo WriteHeader($head, $topic);
echo $html;
echo WriteFooter();

function input_gas($html)
{
	$error = FALSE;
	if (isset($_POST['day']))
	{
		$day 		= $_POST['day'];
	}
	else
	{
		$html .= WriteError("Tag wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['month']))
	{
		$month 		= $_POST['month'];
	}
	else
	{
		$html .= WriteError("Monat wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['year']))
	{
		$year 		= $_POST['year'];
	}
	else
	{
		$html .= WriteError("Jahr wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['meter']))
		$meter 		= $_POST['meter'];
	else
	{
		$html .= WriteError("Z&auml;hlerstand wurde nicht angegeben.");
		$error = TRUE;
	}

	if (!checkdate($month, $day, $year))	
	{
		$html .= WriteError("Ung&uuml;ltiges Datum.");
		$error = TRUE;
	}

	$db = ConnectDb();
	$result = $db->query("SELECT MAX(value) as max FROM gas");
	$result1 = $result->fetchAll();
	$max = $result1[0]['max'];
	
	if(!is_numeric($meter))
	{
		$html .= WriteError("Ung&uuml;ltiger Z&auml;hlerstand. Bitte den Punkt (.) als Trennzeichen verwenden.");
		$error = TRUE;
	}
	else if($meter < $max)
	{
		$html .= WriteError("Der Z&auml;hlerstand ist geringer als bereits eingetragene Werte.");
		$error = TRUE;
	}
	
	if ($error)
		return $html;
	
	$date = date("Y-m-d", strtotime($year."-".$month."-".$day));
	$query = "INSERT INTO gas (date, value) VALUES(:date, :value)";
	$stmt  = $db->prepare($query);
	$stmt->bindParam(':date', $date);
	$stmt->bindParam(':value', $meter);
	if ($stmt->execute())
	{	
		$html .= WriteOK("Der Z&auml;hlerstand wurde eingetragen");
	}
	else
		$html .= WriteError("Der Z&auml;hlerstand konnte nicht eingetragen werden.");
		
	return $html;
}

function input_strom($html)
{
	$error = FALSE;
	if (isset($_POST['day']))
	{
		$day 		= $_POST['day'];
	}
	else
	{
		$html .= WriteError("Tag wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['month']))
	{
		$month 		= $_POST['month'];
	}
	else
	{
		$html .= WriteError("Monat wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['year']))
	{
		$year 		= $_POST['year'];
	}
	else
	{
		$html .= WriteError("Jahr wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['meter']))
		$meter 		= $_POST['meter'];
	else
	{
		$html .= WriteError("Z&auml;hlerstand wurde nicht angegeben.");
		$error = TRUE;
	}
	
	if (!checkdate($month, $day, $year))	
	{
		$html .= WriteError("Ung&uuml;ltiges Datum.");
		$error = TRUE;
	}

	$db = ConnectDb();
	$result = $db->query("SELECT MAX(value) as max FROM gas");
	$result1 = $result->fetchAll();
	$max = $result1[0]['max'];

	if(!is_numeric($meter))
	{
		$html .= WriteError("Ung&uuml;ltiger Z&auml;hlerstand. Bitte den Punkt (.) als Trennzeichen verwenden.");
		$error = TRUE;
	}
	else if($meter < $max)
	{
		$html .= WriteError("Der Z&auml;hlerstand ist geringer als bereits eingetragene Werte.");
		$error = TRUE;
	}

	if ($error)
		return $html;
	
	$date = date("Y-m-d", strtotime($year."-".$month."-".$day));
	$query = "INSERT INTO electricity (date, value) VALUES(:date, :value)";
	$stmt  = $db->prepare($query);
	$stmt->bindParam(':date', $date);
	$stmt->bindParam(':value', $meter);
	if ($stmt->execute())
	{	
		$html .= WriteOK("Der Z&auml;hlerstand wurde eingetragen");
	}
	else
		$html .= WriteError("Der Z&auml;hlerstand konnte nicht eingetragen werden.");
		
	return $html;
}

function input_money($html)
{
	$error = FALSE;
	if (isset($_POST['day']))
	{
		$day 		= $_POST['day'];
	}
	else
	{
		$html .= WriteError("Tag wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['month']))
	{
		$month 		= $_POST['month'];
	}
	else
	{
		$html .= WriteError("Monat wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['year']))
	{
		$year 		= $_POST['year'];
	}
	else
	{
		$html .= WriteError("Jahr wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['shop']))
		$shop	= $_POST['shop'];
	else
	{
		$html .= WriteError("Gesch&auml;ft wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['category']))
		$category	= $_POST['category'];
	else
	{
		$html .= WriteError("Kategorie wurde nicht angegeben.");
		$error = TRUE;
	}
	if (isset($_POST['value']))
	{
		$value	= $_POST['value'];
		if (!is_numeric($value) || $value <= 0)
		{
			$html .= WriteError("Ung&uuml;ltiger Betrag. Bitte den Punkt (.) als Trennzeichen verwenden.");
			$error = TRUE;
		}
	}
	else
	{
		$html .= WriteError("Betrag wurde nicht angegeben.");
		$error = TRUE;
	}
	
	if (!checkdate($month, $day, $year))	
	{
		$html .= WriteError("Ung&uuml;ltiges Datum.");
		$error = TRUE;
	}

	if ($error)
		return $html;
	
	$date = date("Y-m-d", strtotime($year."-".$month."-".$day));
	$db = ConnectDb();
	$query = "INSERT INTO money_entries (entry_category, entry_shop, entry_date, entry_value) VALUES(:category, :shop, :date, :value)";
	$stmt  = $db->prepare($query);
	$stmt->bindParam(':category', $category);
	$stmt->bindParam(':shop', $shop);
	$stmt->bindParam(':date', $date);
	$stmt->bindParam(':value', $value);
	if ($stmt->execute())
	{	
		$html .= WriteOK("Die Finanzen wurden eingetragen");
	}
	else
	{
		$html .= WriteError("Die Finanzen konnten nicht eingetragen werden.");
	}

	return $html;
}

?>
