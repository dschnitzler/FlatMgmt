<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include_once('../modul_standard/functions.php');

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
		case ("input_money"):
			$head = "Eingabe von Finanzen";
			$html = input_money($html);
			$topic= "money";
			break;
		case ("input_shop"):
			$head = "Hinzuf&uuml;gen eines Gesch&auml;fts";
			$html = input_shop($html);
			$topic = "money";
			break;
		case ("input_category"):
			$head = "Hinzuf&uuml;gen einer Kategorie";
			$html = input_category($html);
			$topic = "money";
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
		$html .= WriteOK("Die Finanzen wurden eingetragen. Weitere <a href=\"input_money.php\"><u>Finanzeingabe</u></a>");
	}
	else
	{
		$html .= WriteError("Die Finanzen konnten nicht eingetragen werden.");
	}
	return $html;
}

function input_shop($html)
{
	$error = FALSE;
	if (isset($_POST['shop']))
	{
		$shop 		= $_POST['shop'];
	}
	else
	{
		$html .= WriteError("Gesch&auml;ft wurde nicht angegeben.");
		$error = TRUE;
	}
	
	if ($error)
		return $html;
		
	$db = ConnectDb();
	$query = "INSERT INTO shops (shop_name) VALUES(:shop)";
	$stmt  = $db->prepare($query);
	$stmt->bindParam(':shop', $shop);
	if ($stmt->execute())
	{	
		$html .= WriteOK("Das Gesch&auml;ft wurde eingetragen und kann nun verwendet werden.");
	}
	else
	{
		$html .= WriteError("Das Gesch&auml;ft konnte nicht eingetragen werden.");
	}
	return $html;
}

function input_category($html)
{
	$error = FALSE;
	if (isset($_POST['category']))
	{
		$category 		= $_POST['category'];
	}
	else
	{
		$html .= WriteError("Kategorie wurde nicht angegeben.");
		$error = TRUE;
	}
	
	if ($error)
		return $html;
		
	$db = ConnectDb();
	$query = "INSERT INTO money_categories (category_name) VALUES(:category)";
	$stmt  = $db->prepare($query);
	$stmt->bindParam(':category', $category);
	
	if ($stmt->execute())
	{	
		$html .= WriteOK("Die Kategorie wurde eingetragen und kann nun verwendet werden.");
	}
	else
	{
		$html .= WriteError("Die Kategorie konnte nicht eingetragen werden.");
	}
	return $html;
}
?>