<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

$list = $this->model->decrypt($list);
?>
<div id="mpci-product-title" class="mpci-margin mpci-content mpci-background mpci-float-left mpci-width">
	<div class="message_wrapper featured_products remove_content">
		<article>
		<?php
			echo "<p id=\"diretory_list_title\">THE CATEGORY CONTAINED OF THE FOLLOWING.</p>";
			# displaying the file names with checkbox and form
			echo "
			<form method=\"post\" name=\"dir_content\"' action=\"\">
			<input type=\"hidden\" name=\"remove_path\" value='$path'>
			<input type=\"hidden\" name=\"product_category\" value='$remove_category'>
			<table>";
				while (list ($key, $img) = each ($list)) {
					echo "<tr><td>";
					# determine the length of string present $img
					if(strlen($img)>3){
						echo "<input type=\"checkbox\" name=\"box[]\" value='$img'><a href=\"".$this->model->decrypt($path)."/$img\">$img</a>";
					}
					echo "</td></tr>";
				}
				echo "
					<tr><td><input id=\"submit\" type=\"submit\" name=\"confirm_delete_box\" value=\"Delete\"></td></tr>
			</table>
			</form>";
		?>
		</article>
	</div>
</div>