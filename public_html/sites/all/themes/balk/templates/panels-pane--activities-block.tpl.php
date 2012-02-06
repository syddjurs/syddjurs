<div class="<?php print $classes; ?>" <?php print $id; ?>>
  <?php if ($admin_links): ?>
    <?php print $admin_links; ?>
  <?php endif; ?>

  <?php if ($title): ?>
    <div class="pane-title" style="position: relative;" onmouseout="document.getElementById('kalenderpopup').style.display='none'" onmouseover="document.getElementById('kalenderpopup').style.display='block'">
      <?php print $title; ?>

      <div id="kalenderpopup" style="background-color:#ffffff;top:20px;left:-60px;display:none;position:absolute;overflow:hidden;border:1px solid #D9D9D9;width:398px;height:209px; text-transform: none;">
        <div style="margin:8px"><form target=_top name="mdrkalform" action="http://www.kultunaut.dk/perl/arrlist/type-ballerup2" method="get" onsubmit="if (this.ArrKunstner.value == ' Søg fritekst') this.ArrKunstner.value='';">
            <link rel="stylesheet" href="http://www.kultunaut.dk/perl/viewplain/type-ballerup2/mdrkal2.css" type="text/css">
            <div id=nautmdr>
              <table cellpadding="0" width="100%" cellspacing="0" border="0"><tr><td valign="top">
                    <div id="mdrkal" style="width:180px;margin-right:8px;"></div>
                    <div style="margin-top:10px">
                      <a target="_top" href="http://www.kultunaut.dk/perl/arrlist/type-ballerup2?periode=&Area=Ballerup-storkommune&Genre=Musik|Teater|Udstilling|Natur|Foredrag|Sport|Motion|Børn|Diverse">Se hele kalenderen</a>
                      <br>
                      <a target="_top" href="http://www.kultunaut.dk/perl/huskeliste/type-ballerup2">Din huskeliste</a>

                      <br>
                      <a target="_top" href="http://www.kultunaut.dk/perl/arradd/type-ballerup2">Tilføj arrangement</a>
                    </div>

                  </td><td valign="top" align="center">
                    <div style="width:200px; text-align:left">
                      <div style="margin-bottom:5px;"><b>Søg i kalenderen</b></div>
                      <div style="margin-bottom:10px;">Vælg arrangementstype og<br>søg derefter ved at klikke på en dato eller måned:</div>
                      <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <input type="hidden" name="Area" value="Ballerup-storkommune">
                        <tr>

                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Musik"></td>
                          <td align="left" class="kategori_text" valign="middle">Musik</td>
                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Teater"></td>
                          <td align="left" class="kategori_text" valign="middle">Teater</td>
                        </tr>
                        <tr>
                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Udstilling"></td>
                          <td align="left" class="kategori_text" valign="middle">Udstilling&nbsp;</td>

                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Film"></td>
                          <td align="left" class="kategori_text" valign="middle">Film</td>
                        </tr>
                        <tr>
                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Natur"></td>
                          <td align="left" class="kategori_text" valign="middle">Natur</td>
                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Foredrag"></td>
                          <td align="left" class="kategori_text" valign="middle">Foredrag</td>

                        </tr>
                        <tr>
                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Sportsturnering"></td>
                          <td align="left" class="kategori_text" valign="middle">Sport</td>
                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Motion"></td>
                          <td align="left" class="kategori_text" valign="middle">Motion</td>
                        </tr>
                        <tr>

                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Børn"></td>
                          <td align="left" class="kategori_text" valign="middle">Børn</td>
                          <td align="left" class="kategori_text"><input Name=Genre class=nautcheckbox type="checkbox"  value="Andet|Ekskursion|Lyrik/oplæsning|Møder|Undervisning|Konference/seminar|Banko|Marked/byfest|Gudstjeneste"></td>
                          <td align="left" class="kategori_text" valign="middle">Andet</td>
                        </tr>
                        <input type="hidden" name="periode" value="">
                        <input type="hidden" name="ArrStartyear" value="">
                        <input type="hidden" name="ArrStartmonth" value="">
                        <input type="hidden" name="ArrStartday" value="">
                      </table>

                      <div style="text-align:right;margin-top:5px;"><input type="submit" value="Søg"></div>

                    </div>
                  </td></tr></table>

            </div>
          </form>

          <script type="text/javascript" src="http://www.kultunaut.dk/perl/viewplain/type-ballerup2/mdrkal2.js"></script>
          <script type="text/javascript">printmdrkal('mdrkal',0,'','','','');</script>
        </div>
      </div>

    </div>
  <?php endif; ?>

  <?php if ($feeds): ?>
    <div class="feed">
      <?php print $feeds; ?>
    </div>
  <?php endif; ?>

  <div class="pane-content">
    <?php print render($content); ?>
  </div>

  <?php if ($links): ?>
    <div class="links">
      <?php print $links; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <div class="more-link">
      <?php print $more; ?>
    </div>
  <?php endif; ?>
</div>
