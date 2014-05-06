<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include_once('../modul_standard/functions.php');

$error = FALSE;
$html = "";

if (!isset($_GET['item']))
{
	$head = "Fehler";
	$error = TRUE;
	$html = WriteError("Es wurde keine Z&auml;hlerauswahl angegeben.");
}
else if ($_GET['item'] == "gas")
{
	$item = "gas";
	$head = "Eingabe des Gasz&auml;hlers";
	$unit = "m³";
}
else if ($_GET['item'] == "strom")
{
	$item = "strom";
	$head = "Eingabe des Stromz&auml;hlers";
	$unit = "kWh";
}
else
{
	$head = "Fehler";
	$error = TRUE;
	$html = WriteError("Z&auml;hlerauswahl kann nicht interpretiert werden.");
}

echo WriteHeader($head, "energy");
if ($error == TRUE)
{
	echo $html;
}
else
{
	$html = "<form item=\"id\" action=\"action.php?action=input_".$item."\" method=\"post\">
			<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
			  <tbody>
				<tr>
					<td>Tag:</td>
					<td>
						<input name=\"day\" type=\"number\" size=\"4\" min=\"01\" max=\"31\" required>
					</td>
				</tr>
				<tr>
					<td>Monat:</td>
					<td>
						<input name =\"month\" type=\"number\" size=\"4\" min=\"01\" max=\"12\" value=\"".date("m")."\" required>
					</td>
				</tr>
				<tr>
					<td>Jahr:</td>
					<td>
						<input name=\"year\" type=\"number\" size=\"4\" maxlength=\"4\" min=\"2013\" value=\"".date("Y")."\" required>
					</td>
				</tr>
				<tr>
					<td>Z&auml;hlerstand:</td>
					<td>
						<input name=\"meter\" type=\"number\" size=\"10\" min=\"0.1\" step=\"any\" required> ".$unit."
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<br><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Hinzuf&uuml;gen\" />
					</td>
				</tr>
				</tbody>
				</table>
			</form>";
	echo $html;
}
echo WriteFooter();

?>
