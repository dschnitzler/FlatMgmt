<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include_once('../modul_standard/functions.php');

$error = FALSE;
$html = "";

if (isset($_POST['start_month']))
{	$start_month = $_POST['start_month'];}
else
{	$start_month = "01";}

if (isset($_POST['start_year']))
{	$start_year = $_POST['start_year'];}
else
{	$start_year = "2013";}

if (isset($_POST['end_month']))
{	$end_month = $_POST['end_month'];}
else
{	$end_month = date('m',mktime(0,0,0,date("m")+1,date("d"),date("Y")));}

if (isset($_POST['end_year']))
{	$end_year = $_POST['end_year'];}
else
{	$end_year = date('Y',mktime(0,0,0,date("m")+1,date("d"),date("Y")));}

$start_date = $start_year."-".$start_month."-01";
$end_date 	= $end_year.  "-".$end_month.  "-01";

$datetime_start = new DateTime($start_date);
$datetime_end 	= new DateTime($end_date);

$formular = "<form item=\"id\" action=\"index.php\" method=\"post\">
			<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
			  <tbody>
				<tr>
					<td>Analyse von</td>
					<td>
						<select name=\"start_month\">\n";
						for ($i = 1; $i <= 12; $i++)
						{
							$i_string = str_pad($i, 2, "0", STR_PAD_LEFT);
							if ($i_string == $start_month)
								{ $selected = "selected"; }
							else
								{ $selected = ""; }
							$html .= "<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
						}
	$html .=  "				</select>
					</td>
					<td>
						<select name=\"start_year\">\n";
						for ($i = 2013; $i <= 2015; $i++)
						{
							$i_string = str_pad($i, 4, "0", STR_PAD_LEFT);
							if ($i_string == $start_year)
								{ $selected = "selected"; }
							else
								{ $selected = ""; }
							$html .="<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
						}
	$html .= "			</select>
					</td>
					<td>bis</td>
					<td>
						<select name=\"end_month\">\n";
						for ($i = 1; $i <= 12; $i++)
						{
							$i_string = str_pad($i, 2, "0", STR_PAD_LEFT);
							if ($i_string == $end_month)
								{ $selected = "selected"; }
							else
								{ $selected = ""; }
							$html .="<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
						}
	$html .= "			</select>
					</td>
					<td>
						<select name=\"end_year\">\n";
						for ($i = 2013; $i <= 2015; $i++)
						{
							$i_string = str_pad($i, 4, "0", STR_PAD_LEFT);
							if ($i_string == $end_year)
								{ $selected = "selected"; }
							else
								{ $selected = ""; }
							$html .= "<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
						}
	$html .= "				</select>
					</td>
				</tr>
				<tr>
					<td>
						<br><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Aktualisieren\" />
					</td>
				</tr>
				</tbody>
				</table>
			</form>";

if ($datetime_start >= $datetime_end)
{
	$html .= WriteError("Das Enddatum ist kleiner als das Startdatum.");
	$error = TRUE;
}

if (!$error)
{
	list($avg_strom, $std_strom)= GetAverageStrom($start_date, $end_date);
	list($avg_gas, $std_gas)	= GetAverageGas($start_date, $end_date);
	$avg_strom_stawag 			= GetCostStromStawag($avg_strom);
	$avg_gas_stawag 			= GetCostGasStawag(ConvertGasFromM3ToKwh($avg_gas));
	$html .= "	<h2>Strom</h2>
		<img src=\"Diagramm_energy.php?item=strom&amp;start_date=".$start_date."&amp;end_date=".$end_date."\" width=\"770\" height=\"300\">
		Durchschnittliche Stromkosten pro Monat: ".round($avg_strom_stawag, 2)."&euro;<br>
		Aktueller Abschlag 34.00&euro;<br>
		<h2>Gas</h2>
		<img src=\"Diagramm_energy.php?item=gas&amp;start_date=".$start_date."&amp;end_date=".$end_date."\"   width=\"770\" height=\"300\">
		Durchschnittliche Gaskosten pro Monat: ".round($avg_gas_stawag, 2)."&euro;<br>
		Aktueller Abschlag 16.00&euro;<br>";
}

echo WriteHeader("Energie", "energy");
echo $formular;
echo $html;
echo WriteFooter();
?>
