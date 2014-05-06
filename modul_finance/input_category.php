<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include_once('../modul_standard/functions.php');

$html = "";
$head = "Hinzuf&uuml;gen einer Kategorie";

echo WriteHeader($head, "money");
$html = "<form item=\"id\" action=\"action.php?action=input_category\" method=\"post\">
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
		  <tbody>
			<tr>
				<td>Kategorie: &nbsp;</td>
				<td>
					<input name=\"category\" type=\"text\" size=\"20\" maxlength=\"30\" required>
				</td>
			</tr>
			<tr>
				<td>
					<br><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Hinzuf&uuml;gen\" />
				</td>
				<td></td>
			</tr>
			</tbody>
			</table>
		</form>";
echo $html;
echo WriteFooter();

?>