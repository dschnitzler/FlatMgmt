<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');

$html = "";
$head = "Eingabe von Finanzen";

$db = ConnectDB();
$shops1 = $db->query("SELECT * FROM shops order by shop_name asc");
$shops = $shops1->fetchAll();

$categories1 = $db->query("SELECT * FROM money_categories order by category_name asc");
$categories = $categories1->fetchAll();

echo WriteHeader($head, "money");
$html = "<form item=\"id\" action=\"action.php?action=input_money\" method=\"post\">
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
		  <tbody>
			<tr>
				<td>Tag:</td>
				<td>
					<input name=\"day\" type=\"number\" size=\"4\" maxlength=\"2\" required>
				</td>
			</tr>
			<tr>
				<td>Monat:</td>
				<td>
					<input name =\"month\" type=\"number\" size=\"4\" maxlength=\"2\" value=\"".date("m")."\" required>
				</td>
			</tr>
			<tr>
				<td>Jahr:</td>
				<td>
					<input name=\"year\" type=\"number\" size=\"4\" maxlength=\"4\" minlength=\"4\" value=\"".date("Y")."\" required>
				</td>
			</tr>
			<tr>
				<td>Betrag:</td>
				<td>
					<input name=\"value\" type=\"number\" size=\"4\" maxlength=\"10\" value=\"0.00\" required> &euro;
				</td>
			</tr>
			<tr>
				<td>Gesch&auml;ft:</td>
				<td>
					<select name=\"shop\">";
for ($i = 0; $i < sizeof($shops); $i++)
{
	$shop = $shops[$i];
	$html .= "<option value=\"".$shop['shop_id']."\">".$shop['shop_name']."<br/>\n";
}
$html .="		</select>
				</td>
				<td> 
					<a href=\"input_shop.php\"> <b> + </b> </a>
				</td>
			</tr>
			<tr>
				<td>Kategorie:</td>
				<td>
				<select name=\"category\">";
for ($i = 0; $i < sizeof($categories); $i++)
{
	$category = $categories[$i];
	$html .= "<option value=\"".$category['category_id']."\">".$category['category_name']."<br/>\n";
}
$html .="		</select>
			</td>
			<td>
				<a href=\"input_category.php\"> <b> + </b> </a>
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
echo WriteFooter();

?>
