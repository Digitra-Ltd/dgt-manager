<?php
	require("../scripts/incfiles/cdm_cls.inc.php");
?>
<?php
//KTML include files
require_once('../ktmllite/includes/ktedit/activex.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editeur de pages</title>
</head>

<body>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#0c4f70">
  <tr>
    <td bordercolor="#234E6D"><form action="<?php echo $PHP_SELF; ?>" method="post" name="frmPageUpd" id="frmPageUpd">
      <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <tr>
          <td align="center" class="displayError"><?php print $err_msg; ?></td>
        </tr>
        <tr>
          <td align="center"><strong>Modifications sur la page : <?php print $pageToModify; ?></strong></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Texte &agrave; la barre des titres en fran&ccedil;ais </td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Texte &agrave; la barre des titres en anglais </td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Titre en Fran&ccedil;ais:</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Titre en Anglais </td>
        </tr>
        <tr>
          <td align="center"><!-- <input type="text" name="txtAuthor" id="txtAuthor" value="<?php //echo show_content($err_msg, $txtAuthor); ?>" size="32" /> --></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Contenu de la page en Fran&ccedil;ais </td>
        </tr>
        <tr>
          <td><input name="txtContentFr" type="hidden" id="txtContentFr" value="<?php echo stripslashes(htmlspecialchars($pageTab["CONTENT_FR"])); ?>" />
              <?php 
   $KT_display = "Insert Image,Insert Table,Toggle Vis/Invis,Toggle WYSIWYG,Bold,Italic,Underline,Align Left,Align Center,Align Right,Align Justify,Background Color,Foreground Color,Bullet List,Numbered List,Indent,Outdent,Font Size,Insert Link,Heading List";
   showActivex('txtContentFr', 700, 300, false,$KT_display, "../ktmllite/", "", "../../../img/img_articles/", "../../../img/img_articles/",1, "", 480, "english", "yes", "no");
?></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Contenu de la page en Anglais </td>
        </tr>
        <tr>
          <td align="center"><input name="txtContentEn" type="hidden" id="txtContentEn" value="<?php echo stripslashes(htmlspecialchars($pageTab["CONTENT_EN"])); ?>" />
              <?php 
   $KT_display = "Insert Image,Insert Table,Toggle Vis/Invis,Toggle WYSIWYG,Bold,Italic,Underline,Align Left,Align Center,Align Right,Align Justify,Background Color,Foreground Color,Bullet List,Numbered List,Indent,Outdent,Font Size,Insert Link,Heading List";
   showActivex('txtContentEn', 700, 300, false,$KT_display, "../ktmllite/", "", "../../../img/img_articles/", "../../../img/img_articles/",1, "", 480, "english", "yes", "no");
?>
              <input type="hidden" name="hdDate" value="<?php print date("Y-m-d"); ?>"/>
              <input type="hidden" name="hdDate2" value="<?php print $pageTab["MAJDATE"] ?>" />
              <input type="hidden" name="hdPUpd" value="<?php print $_REQUEST[pgUpd]; ?>" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><!-- <input type="file" name="userfile2" />--></td>
        </tr>
        <tr>
          <td align="center"><label>
            <input name="btnSubmit" type="submit" id="btnSubmit" value="Ins&eacute;rer les donn&eacute;es" />
          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<p></p>
</body>
</html>
