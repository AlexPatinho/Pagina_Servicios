<?
function LoginPass($TitPag,$Int,$Tit){    //funcion para intentar ingresar mas de una vez si se equivoco el login
echo "<TABLE WIDTH=783 BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
echo "  <TR><TD>\n";
Lfla();
echo "  </TD></TR>\n";
echo "  <TR><TD height=12 bgcolor=navy></TD></TR>\n";
echo "  <TR><TD height=380 bgcolor=#FFFBF0 ALIGN=CENTER>";
echo"  <TABLE BORDER=0><tr HEIGHT=10><TD></TD></tr></TABLE>\n";
echo"  <P CLASS=tit>$Tit</P>\n";
echo"  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=1  WIDTH=730 HEIGHT=30><TR><TD><P CLASS=tam10 ID=centro>Proporcione nombre de usuario y contraseña. Recuerde que las minusculas son diferentes a las MAYUSCULAS.</P></TD></TR></TABLE>\n";
echo"  <TABLE BORDER=0><tr HEIGHT=20><TD>";
echo"  </TD></tr></TABLE>\n";
echo"  <TABLE WIDTH=760 BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
echo"  <TR>\n";
echo"   <TD align=center rowspan=2 CELLSPACING=0 CELLPADDING=0 BORDER=0>\n";
echo"   <FORM NAME=\"Formulario0\"  ACTION=$TitPag METHOD=POST target=_top>\n";
echo"   <table WIDTH=370 height=180 BORDER=1 CELLSPACING=0 CELLPADDING=0>\n";
echo"   <tr><td VALIGN=MIDDLE ALIGN=CENTER bgcolor=#FFFFFA>\n";
echo"    <table WIDTH=330 BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
if($Int==1)
echo"     <tr><td COLSPAN=2 height=10><P style=\"text-align:center;font-size:8pt;font-family:Arial,Helvatica,sans-serif;color:red;\">El usuario no existe o la contraseña es erronea. Intente nuevamente</P></td></tr>";
echo"     <tr><td bgcolor=#ECC013 COLSPAN=2 height=5></td></tr>\n";
echo"     <tr><td bgcolor=navy COLSPAN=2 height=20></td></tr>\n";
echo"     <tr><td VALIGN=BOTTOM bgcolor=navy><P CLASS=BLANCO>Nombre:</P></td><td VALIGN=BOTTOM bgcolor=navy><INPUT TYPE=text NAME=Usuario SIZE=20></td></tr>\n";
echo"     <tr><td VALIGN=TOP bgcolor=navy><P CLASS=BLANCO>Password:</P></td><td VALIGN=TOP bgcolor=navy><INPUT TYPE=password NAME=Clave SIZE=20></td></tr>\n";
echo"     <tr><td bgcolor=navy COLSPAN=2 height=25></td></tr>\n";
echo"     <tr><td COLSPAN=2 height=10></td></tr>\n";
echo"     <tr><td COLSPAN=2 VALIGN=MIDDLE ALIGN=CENTER><INPUT NAME=Int type=hidden value=1><INPUT type=image value=submit name=Aceptar src=/ima/aceptar.gif></td></tr>\n";
echo"    </table>\n";
echo"   </td></tr>\n";
echo"   </table>\n";
echo"   </form>\n";
echo"   </TD>\n";
echo"  </TR>\n";
echo"  </TABLE>\n";
echo"  <table width=760 HEIGHT=20 border=0 cellspacing=0 cellpadding=0>\n";
echo"   <tr><td>\n";
echo"    <A HREF=/ onMouseOut=\"document.atr.src='/ima/home1.gif'\"; onMouseOver=\"document.atr.src='/ima/home2.gif'\";><img BORDER=0 name=atr src=\"/ima/home1.gif\"><BR></A>\n";
echo"   </td></tr>\n";
echo"  </table>\n";
echo"  </TD></TR>\n";
echo"  </TABLE>\n";
}

function Letrero(){
echo"<SCRIPT>\n";
echo"<!--\n";
echo"   var ShowString = \"                                                \"\n"; //La primera linea tiene que estar en blanco
echo"               + \"Universidad Nacional Autónoma de México         \"\n"; //Puedes añadir mas frases, aparte de estas 3
echo"               + \"Facultad de Estudios Superiores   A R A G Ó N             \"\n";
echo"               + \"Secretaría Academica                Departamento de Servicios Escolares          \"\n";
echo"               + \"Área de Cómputo              Diseño y realización: Ing. José Alberto Trejo Campos                       \"\n";
echo"   var ShowWidth  = 100\n";
echo"   var ShowHead   = 0\n";
echo"   var ShowTail   = ShowWidth\n";
echo"   var ShowLength = ShowString.length\n";
echo"   function Marquee ()\n";
echo"   {\n";
echo"     var DisplayString\n";
echo"     if (ShowHead < ShowTail)\n";
echo"       DisplayString = ShowString.substring(ShowHead, ShowTail)\n";
echo"     else\n";
echo"       DisplayString = ShowString.substring(ShowHead, ShowLength)\n";
echo"                  + ShowString.substring(       0, ShowTail)\n";
echo"       ShowHead = (ShowHead + 1 ) % ShowLength\n";
echo"       ShowTail = (ShowTail + 1 ) % ShowLength\n";
echo"       window.status = DisplayString\n";
echo"       TimerID = setTimeout(\"Marquee()\", 200) //Cambia el numero para cambiar la velocidad\n";
echo"   }\n";
echo"//-->\n";
echo"</SCRIPT>\n";
}

function Maxi(){
echo"   <script language=\"JavaScript1.2\">\n";
echo"  <!--\n";
echo"  top.window.moveTo(0,0);\n";
echo"  if (document.all) {\n";
echo"    top.window.resizeTo(screen.availWidth,screen.availHeight);\n";
echo"  }\n";
echo"  else if (document.layers||document.getElementById) {\n";
echo"    if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){\n";
echo"      top.window.outerHeight = screen.availHeight;\n";
echo"      top.window.outerWidth = screen.availWidth;\n";
echo"    }\n";
echo"  }\n";
echo"  <!-- frame buster - code by Gordon McComb -->\n";
echo"  setTimeout (\"changePage()\", 0);\n";
echo"  function changePage() {\n";
echo"    //if (self.parent.frames.length != 1)\n";
echo"    if (self != top) \n";
echo"      self.parent.location=document.location;\n";
echo"  }\n";
echo"  //-->\n";
echo"</script>\n";
}

function Lfla(){
echo"  <OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0\" ID=Logo width=100% height=82>\n";
echo"   <PARAM NAME=movie VALUE=\"/CABEZA.swf\" >\n";
echo"   <PARAM NAME=quality VALUE=high >\n";
echo"   <PARAM NAME=bgcolor VALUE=navy >\n";
echo"   <EMBED src=\"/CABEZA.swf\" quality=high bgcolor=navy WIDTH=100% HEIGHT=82 TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\"></EMBED>\n";
echo"  </OBJECT>\n";
}

function NoAuto(){
echo"<TABLE WIDTH=783 BORDER=0 CELLSPACING=0 CELLPADDING=0><TR><TD>";
Lfla();
echo"</TD></TR><TR><TD height=12 bgcolor=navy></TD></TR><TR><TD height=380 bgcolor=#FFFBF0 ALIGN=CENTER>";
echo" <P CLASS=tit ID=Azul>SIN AUTORIZACIÓN</P>\n";
echo" <TABLE WIDTH=760 BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
echo"  <TR><TD>\n";
echo"   <HR>\n";
echo"    <CENTER><img border=0 src=\"/ima/nomaq.gif\" width=100 height=100></CENTER>\n";
echo"    <P CLASS=tit style=\"color:red;\">USTED NO ESTA AUTORIZADO<br>PARA VER ESTA PÁGINA</P>\n";
echo"   <HR>\n";
echo"  </TD></TR>\n";
echo" </TABLE>\n";
echo" <TABLE WIDTH=760 BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
echo" <TR>\n";
echo"  <TD WIDTH=80></TD>\n";
echo"  <TD WIDTH=600>\n";
echo"  <CENTER>\n";
echo"  <A href=mailto:webmaster@aragon.dgae.unam.mx><IMG border=0 SRC=\"/IMA/Email.gif\"></A>\n";
echo"  <P CLASS=mini><IMG border=0 SRC=\"/IMA/TURHOME.GIF\"> Cualquier duda o comentario, favor de enviar un E-mail a <A href=mailto:webmaster@aragon.dgae.unam.mx>webmaster@aragon.dgae.unam.mx</A></P>\n";
echo"  </CENTER>\n";
echo"  </TD>\n";
echo"  <TD WIDTH=80></TD>\n";
echo" </TR>\n";
echo" </TABLE>\n";
echo"  </TD></TR>";
echo"  </TABLE>"; 
}


function Seccion($strIP,$Secc,$Usuario,$Clave,$strPerCarr,$CODIF,$strDGAE){
$strPermiso="X";
$con = odbc_connect("USUARIOS","","" );
if ($con!=0){
 $sql="SELECT IP,PERMISO,ACTIVO FROM PCS WHERE IP='".$strIP."'";
 $rscon=odbc_do($con,$sql);
 if(odbc_result($rscon,3)=='1') //si esta activo
  if(substr(odbc_result($rscon,2),0,1)=='1' or substr(odbc_result($rscon,2),$Secc,1)=='1')  //es admin o tiene permiso de ventanillas
   $strPermiso='1'.$strPermiso;
 if(substr($strPermiso,0,1)=='1'){
  if($Usuario!=NULL){
   if ($CODIF==NULL){
    include("../admin/util.inc");
    $Clave=cifrado($Clave);
   }
   $sql="SELECT LOGIN,PASS,PERMISO,CARRERA,UDGAE FROM USUARIOS WHERE LOGIN='".$Usuario."' AND PASS='".$Clave."' AND ACTIVO='1'";
   $rscon=odbc_do($con,$sql);
   $strPermiso=substr($strPermiso,0,1).odbc_result($rscon,3);
   $strPermiso=$strPermiso."X";
   $strPerCarr=odbc_result($rscon,4);
   $strDGAE=odbc_result($rscon,5);
  }
 }
 odbc_free_result($rscon);
 odbc_close($con);
}
return($strPermiso);
}

function MES(){
$MES[1]="Enero";
$MES[2]="Febrero";
$MES[3]="Marzo";
$MES[4]="Abril";
$MES[5]="Mayo";
$MES[6]="Junio";
$MES[7]="Julio";
$MES[8]="Agosto";
$MES[9]="Septiembre";
$MES[10]="Octubre";
$MES[11]="Noviembre";
$MES[12]="Diciembre";
print($MES[date("n")]);
}


function ColOrdBus($Usuario,$Clave,$strPag){
echo"  <table WIDTH=420 height=195 BORDER=1 CELLSPACING=0 CELLPADDING=0>\n";
echo"   <tr><td VALIGN=MIDDLE ALIGN=CENTER bgcolor=#FFFFFA>\n";
echo"   <TABLE cellpading=4 cellspacing=0 border=0>\n";
echo"    <FORM NAME=Formulario1  ACTION=".$strPag." METHOD=POST>\n";
echo"    <tr><td height=5 COLSPAN=2 bgcolor=#FFFFFA></td></TR>\n";
echo"    <tr><td height=20 WIDTH=148 background=/ima/boton.jpg><P class=mini ID=despe style=\"color:white;\">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspBusqueda</P></td><td WIDTH=220></td></TR>\n";
echo"    <tr><td height=5 COLSPAN=2 bgcolor=navy></td></TR>\n";
echo"    <tr><td VALIGN=BOTTOM bgcolor=navy><P class=mini ID=despe style=\"color:white;\">Numero de Cuenta:</P></td><td bgcolor=navy><INPUT TYPE=TEXT NAME=strCuenta SIZE=10 MAXLENGTH=9 ></td></TR>\n";
echo"    <tr><td height=10 COLSPAN=2 bgcolor=navy></td></TR>\n";
echo"    <tr><td height=3 COLSPAN=2 bgcolor=#FFFFFA></td></TR>\n";
echo"    <tr><td><P class=mini style=\"color:white;\">".$Usuario."</p><INPUT TYPE=hidden NAME=CODIF VALUE=1><INPUT NAME=Usuario type=hidden value=".$Usuario."><INPUT NAME=Clave type=hidden value=".$Clave."></td><td><INPUT type=image value=submit name=but src=/ima/accesar.gif></td></tr>\n";
echo"    </form>\n";
echo"    <FORM NAME=Formulario2 ACTION=bus_nom.php METHOD=POST>\n";
echo"    <tr><td height=10 COLSPAN=2 bgcolor=#FFFFFA></td></TR>\n";
echo"    <tr><td height=5 COLSPAN=2 bgcolor=#ECC013></td></TR>\n";
echo"    <tr><td height=5 COLSPAN=2 bgcolor=navy></td></TR>\n";
echo"    <tr><td VALIGN=BOTTOM bgcolor=navy><P class=mini ID=despe style=\"color:white;\">N o m b r e :</P></td><td bgcolor=navy><INPUT TYPE=TEXT NAME=Nom SIZE=25 MAXLENGTH=25></td></TR>\n";
echo"    <tr><td VALIGN=BOTTOM bgcolor=navy><P class=mini ID=despe style=\"color:white;\">P a t e r n o :</P></td><td bgcolor=navy><INPUT TYPE=TEXT NAME=aPa SIZE=25 MAXLENGTH=25></td></TR>\n";
echo"    <tr><td VALIGN=BOTTOM bgcolor=navy><P class=mini ID=despe style=\"color:white;\">M a t e r n o :</P></td><td bgcolor=navy><INPUT TYPE=TEXT NAME=aMa SIZE=25 MAXLENGTH=25></td></TR>\n";
echo"    <tr><td height=10 COLSPAN=2 bgcolor=navy></td></TR>\n";
echo"    <tr><td height=3 COLSPAN=2 bgcolor=#FFFFFA></td></TR>\n";
echo"    <tr><td><P class=mini style=\"color:white;\">".$Usuario."</p><INPUT TYPE=hidden NAME=CODIF VALUE=1><INPUT NAME=strPag type=hidden value=".$strPag."><INPUT NAME=Usuario type=hidden value=".$Usuario."><INPUT NAME=Clave type=hidden value=".$Clave."></td><td><INPUT type=image value=submit name=but src=/ima/buscar.gif></td></tr>\n";
echo"    <tr><td height=5 COLSPAN=2 bgcolor=#FFFFFA></td></TR>\n";
echo"    </form>\n";
echo"    </table>\n";
echo"   </td></tr>\n";
echo"  </table>\n";
}

function FormaSQL($strPermiso,$strPerCarr,&$sql){
  $ICar[1]="102";
  $ICar[2]="105";
  $ICar[3]="306";
  $ICar[4]="421";
  $ICar[5]="309";
  $ICar[6]="310";
  $ICar[7]="311";
  $ICar[8]="302";
  $ICar[9]="116";
  $ICar[10]="107";
  $ICar[11]="110";
  $ICar[12]="305";
  $ICar[13]="109";
  $ICar[14]="114";
  $ICar[15]="115";
  if(substr($strPermiso,1,1)!='1'){
   for($conta=0; $conta<15;$conta++)
    if(substr($strPerCarr,$conta,1)=='1')
     $NoC=$NoC+1;
   $NoAdT=0;
   if($NoC==15)
    $NoAdT=1;
   if($NoAdT==0){
    if($NoC==1){
     $sql.=" AND ";
     for($conta=0; $conta<15;$conta++)
      if(substr($strPerCarr,$conta,1)=='1'){
       $sql.="D.CARR='".$ICar[$conta+1]."'";
       $conta=13;
      } 
    }  //si es solo una carrera
    else{
     $sql.=" AND (";
     $uno=0;
     for($conta=0; $conta<15;$conta++)
      if(substr($strPerCarr,$conta,1)=='1'){
       if($uno==0){
        $sql.="D.CARR='".$ICar[$conta+1]."'";
        $uno=1;
       }
       else
        $sql.=" OR D.CARR='".$ICar[$conta+1]."'";
      }
      $sql.=")";
    }
   } 
  } 
}

function Opciones($strPermiso,$Usuario,$Clave,$SemAct,$opc){
echo "  <TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0>\n";
echo "   <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center bgcolor=#A9C0EB><P style=\"COLOR:navy; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Servicios ".$opc."</P></TD></TR>\n";
$valFechT=date("md");
if($opc!=0){
echo "   <form spacing=0 action='/egr/' method=post>\n";
echo "   <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "   <input type=image src=\"../ima/prin1.gif\" onmouseover=\"this.src='../ima/prin2.gif'\" onmouseout=\"this.src='../ima/prin1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}

if($opc!=1)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,3,1)==1){
echo "   <form spacing=0 action='ConDom.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/condom1.gif\" onmouseover=\"this.src='../ima/condom2.gif'\" onmouseout=\"this.src='../ima/condom1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=2)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,4,1)==1){
echo "   <form spacing=0 action='CCreditos.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/CC1.gif\" onmouseover=\"this.src='../ima/CC2.gif'\" onmouseout=\"this.src='../ima/CC1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=3)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,5,1)==1){
echo "   <form spacing=0 action='CEstudios.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/CE1.gif\" onmouseover=\"this.src='../ima/CE2.gif'\" onmouseout=\"this.src='../ima/CE1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=4)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,6,1)==1){
echo "   <form spacing=0 action='Credencial.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/Cre1.gif\" onmouseover=\"this.src='../ima/Cre2.gif'\" onmouseout=\"this.src='../ima/Cre1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=5)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,7,1)==1){
echo "   <form spacing=0 action='Pasante.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/CarPa1.gif\" onmouseover=\"this.src='../ima/CarPa2.gif'\" onmouseout=\"this.src='../ima/CarPa1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=6)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,8,1)==1){
echo "   <form spacing=0 action='Certificados.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/Certi1.gif\" onmouseover=\"this.src='../ima/Certi2.gif'\" onmouseout=\"this.src='../ima/Certi1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=7)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,9,1)==1){
echo "   <form spacing=0 action='RCR.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/RCR1.gif\" onmouseover=\"this.src='../ima/RCR2.gif'\" onmouseout=\"this.src='../ima/RCR1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=8)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,10,1)==1){
echo "   <form spacing=0 action='ExaPro1.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/EP1.gif\" onmouseover=\"this.src='../ima/EP2.gif'\" onmouseout=\"this.src='../ima/EP1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}

if($opc!=11)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,11,1)==1){
echo "   <form spacing=0 action='RevEst.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/tre1.gif\" onmouseover=\"this.src='../ima/tre2.gif'\" onmouseout=\"this.src='../ima/tre1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=12)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,12,1)==1){
echo "   <form spacing=0 action='art22.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/part1.gif\" onmouseover=\"this.src='../ima/part2.gif'\" onmouseout=\"this.src='../ima/part1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=14)
if(substr($strPermiso,1,1)==1 OR substr($strPermiso,12,1)==1){
echo "   <form spacing=0 action='SelA.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/SelA1.gif\" onmouseover=\"this.src='../ima/SelA2.gif'\" onmouseout=\"this.src='../ima/SelA1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}


if(substr($strPermiso,1,1)==1 OR substr($strPermiso,6,1)==1 OR substr($strPermiso,8,1)==1){
 echo "   <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center bgcolor=#A9C0EB><P style=\"COLOR:navy; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Reportes</P></TD></TR>\n";
 if($opc!=9)
 if(substr($strPermiso,1,1)==1  or substr($strPermiso,6,1)==1){
  echo "   <form spacing=0 action='RepCre.php' method=post>\n";
  echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
  echo "    <input type=image src=\"../ima/rcre1.gif\" onmouseover=\"this.src='../ima/rcre2.gif'\" onmouseout=\"this.src='../ima/rcre1.gif'\">\n";
  echo "   </TD></TR>\n";
  echo "   </form>\n";
 }
 if($opc!=10)
 if(substr($strPermiso,1,1)==1  or substr($strPermiso,8,1)==1){
  echo "   <form spacing=0 action='RepCer.php' method=post>\n";
  echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
  echo "    <input type=image src=\"../ima/rcer1.gif\" onmouseover=\"this.src='../ima/rcer2.gif'\" onmouseout=\"this.src='../ima/rcer1.gif'\">\n";
  echo "   </TD></TR>\n";
  echo "   </form>\n";
 }
 if($opc!=14)
 if(substr($strPermiso,1,1)==1 OR substr($strPermiso,3,1)==1){
 echo "   <form spacing=0 action='RepInv.php' method=post>\n";
 echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
 echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
 echo "    <input type=image src=\"../ima/Rinv1.gif\" onmouseover=\"this.src='../ima/Rinv2.gif'\" onmouseout=\"this.src='../ima/Rinv1.gif'\">\n";
 echo "   </TD></TR>\n";
 echo "   </form>\n";
 }
}

if($opc!=25)
echo "   <form spacing=0 action='ADEUDO.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/fun1.gif\" onmouseover=\"this.src='../ima/fun2.gif'\" onmouseout=\"this.src='../ima/fun1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";

echo "   <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center bgcolor=#A9C0EB><P style=\"COLOR:navy; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Opciones</P></TD></TR>\n";
echo "   <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "   <A HREF='/cal/ACT".$SemAct.".php' target=_blank onMouseOut=\"document.aces.src='../ima/ActEsc1.gif'\" onMouseOver=\"document.aces.src='../ima/ActEsc2.gif'\"><img BORDER=0 name=aces src=\"../ima/ActEsc1.gif\"></A>\n";
echo "   </TD></TR>\n";
echo "   <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "   <A HREF='/cal/CALEN".$SemAct.".htm' target=_blank onMouseOut=\"document.atr1.src='../ima/calen1.gif'\" onMouseOver=\"document.atr1.src='../ima/calen2.gif'\"><img BORDER=0 name=atr1 src=\"../ima/calen1.gif\"></A>\n";
echo "   </TD></TR>\n";
echo "   <form spacing=0 action=\"CamNip.php\" method=post>\n";
echo "    <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image src=\"../ima/Nip1.gif\" onmouseover=\"this.src='../ima/Nip2.gif'\" onmouseout=\"this.src='../ima/Nip1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
echo "   <form spacing=0 action=\"javascript:window.close();\" method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <input type=image src=\"../ima/cierra1.gif\" onmouseover=\"this.src='../ima/cierra2.gif'\" onmouseout=\"this.src='../ima/cierra1.gif'\">\n";
echo "    </TD></TR>\n";
echo "   </form>\n";

if(substr($strPermiso,1,1)==1){
 echo "   <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center bgcolor=#A9C0EB><P style=\"COLOR:navy; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Administración</P></TD></TR>\n";
 echo "   <form spacing=0 action='/rev/' method=post>\n";
 echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
 echo "    <INPUT NAME=Usuario type=hidden value='".$Usuario."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
 echo "    <input type=image src=\"../ima/-tr1.gif\" onmouseover=\"this.src='../ima/-tr2.gif'\" onmouseout=\"this.src='../ima/-tr1.gif'\">\n";
 echo "   </TD></TR>\n";
 echo "   </form>\n";
}

echo "  </TABLE>\n";
}



function Menu($Opc,$Per){
$SemAct="-";
Semestre(&$SemAct);
echo" <table BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
echo"  <tr><td height=5 valign=top><P style=\"COLOR:white; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Secciones</P></td></tr>\n";
echo"  <tr><td height=2 valign=top bgcolor=#ECC013></td></tr>\n";
if($Opc=='1')
 echo"  <tr><td height=5 valign=top><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bva.gif\" BORDER=0 ALT=\"Tramites que se realizan en Ventanillas\"></div></td></tr>\n";
else
 echo"  <tr><td height=5 valign=top><A HREF=\"/ven/\" onMouseOut=\"display(1)\";  onMouseOver=\"display(2)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot11.gif\" BORDER=0 ALT=\"Tramites que se realizan en Ventanillas\"></div></A></td></tr>\n";

if($Opc=='2')
 echo"  <tr><td height=5 valign=top><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bea.gif\" BORDER=0 ALT=\"Seccion de Egresados\"></div></td></tr>\n";
else
 echo"  <tr><td height=5 valign=top><A HREF=\"/egr/\" onMouseOut=\"display(3)\";  onMouseOver=\"display(4)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot21.gif\" BORDER=0 ALT=\"Sección de Egresados\"></div></A></td></tr>\n";

if($Opc=='3')
 echo"  <tr><td height=5 valign=top><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/baa.gif\" BORDER=0 ALT=\"Seccion de Actas\"></div></td></tr>\n";
else
 echo"  <tr><td height=5 valign=top><A HREF=\"/des/\" onMouseOut=\"display(5)\"; onMouseOver=\"display(6)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot31.gif\" BORDER=0 ALT=\"Seccion de Actas\"></div></A></td></tr>\n";

if($Opc=='4')
 echo"  <tr><td height=5 valign=top><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bra.gif\" BORDER=0 ALT=\"Revision de Estudios\"></div></td></tr>\n";
else
 echo"  <tr><td height=5 valign=top><A HREF=\"/rev/\" onMouseOut=\"display(7)\"; onMouseOver=\"display(8)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot41.gif\" BORDER=0 ALT=\"Revision de Estudios\"></div></A></td></tr>\n";

if($Opc=='5')
 echo"  <tr><td height=5 valign=top><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bca.gif\" BORDER=0 ALT=\"Area de Computo\"></div></td></tr>\n";
else
 echo"  <tr><td height=5 valign=top><A HREF=\"/des/\" onMouseOut=\"display(9)\"; onMouseOver=\"display(10)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot51.gif\" BORDER=0 ALT=\"Area de Computo\"></div></A></td></tr>\n";

echo"  <tr><td height=5 valign=top><P style=\"COLOR:white; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Servicios</P></td></tr>\n";
echo"  <tr><td height=2 valign=top bgcolor=#ECC013></td></tr>\n";
if($Per=='1')
 echo"  <tr><td height=5 valign=top><A HREF=\"www_gate.php\" onMouseOut=\"display(11)\";  onMouseOver=\"display(12)\" target=_blank><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot61.gif\" BORDER=0 ALT=\"Historiales Academicos\"></div></A></td></tr>\n";
else
 echo"  <tr><td height=5 valign=top><A HREF=\"https://www.dgae-siae.unam.mx/www_gate.php\" onMouseOut=\"display(11)\";  onMouseOver=\"display(12)\" target=_blank><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot61.gif\" BORDER=0 ALT=\"Historiales Academicos\"></div></A></td></tr>\n";
echo"  <tr><td height=5 valign=top><A HREF=\"http://www.aragon.unam.mx/horarios2/index.html\" onMouseOut=\"display(13)\";  onMouseOver=\"display(14)\" target=_blank><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot71.gif\" BORDER=0 ALT=\"Horarios Escolares\"></div></A></td></tr>\n";
if($Opc=='t')
 echo"  <tr><td height=5 valign=top><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bta.gif\" BORDER=0 ALT=\"Tramites Escolares\"></div></td></tr>\n";
else
 echo"  <tr><td height=5 valign=top><A HREF=\"/tra/\" onMouseOut=\"display(15)\"; onMouseOver=\"display(16)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot81.gif\" BORDER=0 ALT=\"Tramites Escolares\"></div></A></td></tr>\n";
echo"  <tr><td height=5 valign=top><A target=_blank HREF=\"/cal/CALEN".$SemAct.".htm\" onMouseOut=\"display(17)\"; onMouseOver=\"display(18)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot91.gif\" BORDER=0 ALT=\"Calendario Escolar $SemAct\"></div></A></td></tr>\n";
echo"  <tr><td height=5 valign=top><A HREF=\"http://www.aragon.unam.mx/ensenanza/licenciaturas/\" onMouseOut=\"display(19)\"; onMouseOver=\"display(20)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot101.gif\" BORDER=0 ALT=\"Carreras en la FES Aragon\"></div></A></td></tr>\n";
echo"  <tr><td height=5 valign=top><A HREF=\"/construye.php\" onMouseOut=\"display(21)\"; onMouseOver=\"display(22)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot111.gif\" BORDER=0 ALT=\"Sistema de Universidad Abierta\"></div></A></td></tr>\n";
echo"  <tr><td height=5 valign=top><P style=\"COLOR:white; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Opciones</P></td></tr>\n";
echo"  <tr><td height=2 valign=top bgcolor=#ECC013></td></tr>\n";
echo"  <tr><td height=5 valign=top><A HREF=\"/construye.php\" onMouseOut=\"display(23)\"; onMouseOver=\"display(24)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot121.gif\" BORDER=0 ALT=\"Novedades\"></div></A></td></tr>\n";
echo"  <tr><td height=5 valign=top><A HREF=\"/construye.php\" onMouseOut=\"display(25)\"; onMouseOver=\"display(26)\"><div style=\"margin-top:-1px; margin-bottom:-5px; margin-right:-5;\"><IMG SRC=\"/ima/bot131.gif\" BORDER=0 ALT=\"Entretenimiento\"></div></A></td></tr>\n";
echo" </table>\n";
}


function OpcAlu($opc,$strCuenta,$Clave,$Carr,$Plan,$Esta,$Ter,$valGen,$valMaxExt,$Art22,$valFoto){
$SemAct="-";
Semestre(&$SemAct);
$valFechT=date("md");
$ART=substr($Art22,0,5);

//echo $valGen;
echo "  <TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0>\n";
echo "   <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center bgcolor=#A9C0EB><P style=\"COLOR:navy; FONT-FAMILY:Arial,Verdana; text-align:center; font-size:8pt; font-weight:700;\">Servicios</P></TD></TR>\n";
if($opc!=0){
echo "   <form spacing=0 action='con_tra.php' method=post>\n";
echo "   <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "  <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'><INPUT NAME=Carr type=hidden value='".$Carr."'><INPUT NAME=Plan type=hidden value='".$Plan."'>\n";
echo "   <input type=image src=\"../ima/prin1.gif\" onmouseover=\"this.src='../ima/prin2.gif'\" onmouseout=\"this.src='../ima/prin1.gif'\">\n";
echo "   </TD></TR>\n";
echo "   </form>\n";
}
if($opc!=1)
 if($valFechT<=825 and $valFechT>=617 and $Ter=='0' and $valGen!='2016' and $ART>$SemAct){
  echo "  <form spacing=0 action='diahora.php' method=post>\n";
  echo "  <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "  <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'><INPUT NAME=Carr type=hidden value='".$Carr."'><INPUT NAME=Plan type=hidden value='".$Plan."'><INPUT NAME=Esta type=hidden value='".$Esta."'><INPUT NAME=Ter type=hidden value='".$Ter."'><INPUT NAME=Art22 type=hidden value='".$Art22."'><INPUT NAME=valMaxExt type=hidden value='".$valMaxExt."'><INPUT NAME=valFoto type=hidden value='".$valFoto."'><INPUT NAME=fCue type=hidden value='".$fCue."'><INPUT NAME=vTur type=hidden value='".$vTur."'><INPUT NAME=valGen type=hidden value='".$valGen."'>\n";
  echo "  <input type=image name=dia src=\"../ima/menua1.gif\"  onmouseover=\"this.src='../ima/menua2.gif'\" onmouseout=\"this.src='../ima/menua1.gif'\">\n";
  echo "  </TD></TR>\n";
  echo "  </form>\n";
 }
if($opc!=6)
 if($valFechT<=208 and $valFechT>=128 and $Ter=='0' and $valGen!='2014'){
  echo "  <form spacing=0 action='abc.php' method=post>\n";
  echo "  <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "  <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'><INPUT NAME=Carr type=hidden value='".$Carr."'><INPUT NAME=Plan type=hidden value='".$Plan."'><INPUT NAME=Esta type=hidden value='".$Esta."'><INPUT NAME=Ter type=hidden value='".$Ter."'><INPUT NAME=Art22 type=hidden value='".$Art22."'><INPUT NAME=valMaxExt type=hidden value='".$valMaxExt."'><INPUT NAME=valFoto type=hidden value='".$valFoto."'><INPUT NAME=fCue type=hidden value='".$fCue."'><INPUT NAME=vTur type=hidden value='".$vTur."'><INPUT NAME=valGen type=hidden value='".$valGen."'>\n";
  echo "  <input type=image name=dia src=\"../ima/abc1.gif\"  onmouseover=\"this.src='../ima/abc2.gif'\" onmouseout=\"this.src='../ima/abc1.gif'\">\n";
  echo "  </TD></TR>\n";
  echo "  </form>\n";
 }
if($opc!=2)
 if((($valFechT<=930 and $valFechT>=923) or ($valFechT<=622 and $valFechT>=619)) and $Ter=='0' and $valGen!='2014'){
  echo "  <form spacing=0 action='papext.php' method=post>\n";
  echo "  <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "  <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'><INPUT NAME=Carr type=hidden value='".$Carr."'><INPUT NAME=Plan type=hidden value='".$Plan."'><INPUT NAME=Esta type=hidden value='".$Esta."'><INPUT NAME=Ter type=hidden value='".$Ter."'><INPUT NAME=Art22 type=hidden value='".$Art22."'><INPUT NAME=valMaxExt type=hidden value='".$valMaxExt."'><INPUT NAME=valFoto type=hidden value='".$valFoto."'><INPUT NAME=fCue type=hidden value='".$fCue."'><INPUT NAME=vTur type=hidden value='".$vTur."'><INPUT NAME=valGen type=hidden value='".$valGen."'>\n";
  echo "  <input type=image name=dia src=\"../ima/pext1.gif\"  onmouseover=\"this.src='../ima/pext2.gif'\" onmouseout=\"this.src='../ima/pext1.gif'\">\n";
  echo "  </TD></TR>\n";
  echo "  </form>\n";
 }
if($opc!=3)
 if($valFechT<=524 and $ART>$SemAct and $valFechT>=211 and $Ter=='0' and $valGen!='2014'){
  echo "  <form spacing=0 action='TramCred.php' method=post>\n";
  echo "  <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "  <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'><INPUT NAME=Carr type=hidden value='".$Carr."'><INPUT NAME=Plan type=hidden value='".$Plan."'><INPUT NAME=Esta type=hidden value='".$Esta."'><INPUT NAME=Ter type=hidden value='".$Ter."'><INPUT NAME=Art22 type=hidden value='".$Art22."'><INPUT NAME=valMaxExt type=hidden value='".$valMaxExt."'>\n";
  echo "  <input type=image name=dia src=\"../ima/cre1.gif\"  onmouseover=\"this.src='../ima/cre2.gif'\" onmouseout=\"this.src='../ima/cre1.gif'\">\n";
  echo " </TD></TR>\n";
  echo " </form>\n";
 }
if($opc!=4)
 if($valFechT<=1231 and $valFechT>=101 and $ART<=$SemAct and $Ter=='0'){
  echo "  <form spacing=0 action='Art22.php' method=post>\n";
  echo "  <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "  <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'><INPUT NAME=Carr type=hidden value='".$Carr."'><INPUT NAME=Plan type=hidden value='".$Plan."'><INPUT NAME=Esta type=hidden value='".$Esta."'><INPUT NAME=Ter type=hidden value='".$Ter."'><INPUT NAME=Art22 type=hidden value='".$Art22."'><INPUT NAME=valMaxExt type=hidden value='".$valMaxExt."'>\n";
  echo "  <input type=image src=\"../ima/part1.gif\" onmouseover=\"this.src='../ima/part2.gif'\" onmouseout=\"this.src='../ima/part1.gif'\">\n";
  echo " </TD></TR>\n";
  echo " </form>\n";
 }
if($opc!=5)
 if($valFechT<=509 and $valFechT>=506 and (($Carr=='302' and $Plan=='1274' and  $valGen<='2011') or ($Carr=='306' and $Plan=='0076' and $valGen<='2010') or ($Carr=='306' and $Plan=='1382' and $valGen<='2010') or ($Carr=='306' and $Plan=='1291' and $valGen<='2011') or ($Carr=='109' and $Plan=='1312' and  $valGen<='2011') or ($Carr=='114' and $Plan=='1313' and  $valGen<='2011') or ($Carr=='115' and $Plan=='1314' and  $valGen<='2011')) and $Ter=='0'){
  echo "  <form spacing=0 action='SelA.php' method=post>\n";
  echo "  <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
  echo "  <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'><INPUT NAME=Carr type=hidden value='".$Carr."'><INPUT NAME=Plan type=hidden value='".$Plan."'><INPUT NAME=Esta type=hidden value='".$Esta."'><INPUT NAME=Ter type=hidden value='".$Ter."'><INPUT NAME=Art22 type=hidden value='".$Art22."'><INPUT NAME=valMaxExt type=hidden value='".$valMaxExt."'>\n";
  echo "  <input type=image src=\"../ima/SelA1.gif\" onmouseover=\"this.src='../ima/SelA2.gif'\" onmouseout=\"this.src='../ima/SelA1.gif'\">\n";
  echo " </TD></TR>\n";
  echo " </form>\n";
 }

echo "   <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center>\n";
echo "   <A HREF=\"http://www.aragon.unam.mx/horarios2/index.html\" target=_blank onMouseOut=\"document.atr.src='../ima/hora1.gif'\"; onMouseOver=\"document.atr.src='/ima/hora2.gif'\";><img BORDER=0 name=atr src=\"../ima/hora1.gif\"></A>\n";
echo "   </TD></TR>\n";
echo "   <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "   <A HREF='/cal/CALEN".$SemAct.".htm' target=_blank onMouseOut=\"document.atr1.src='../ima/calen1.gif'\" onMouseOver=\"document.atr1.src='../ima/calen2.gif'\"><img BORDER=0 name=atr1 src=\"../ima/calen1.gif\"></A>\n";
echo "   </TD></TR>\n";
echo "   <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "   <A HREF='/cal/ACT".$SemAct.".php' target=_blank onMouseOut=\"document.aces.src='../ima/ActEsc1.gif'\" onMouseOver=\"document.aces.src='../ima/ActEsc2.gif'\"><img BORDER=0 name=aces src=\"../ima/ActEsc1.gif\"></A>\n";
echo "   </TD></TR>\n";
echo "   <form spacing=0 action='CamNip.php' method=post>\n";
echo "    <TR><TD WIDTH=70  HEIGHT=10 align=center valing=center>\n";
echo "    <INPUT NAME=strCuenta type=hidden value='".$strCuenta."'><INPUT NAME=Clave type=hidden value='".$Clave."'><INPUT TYPE=hidden NAME=CODIF VALUE='5'>\n";
echo "    <input type=image name=dia src=\"../ima/Nip1.gif\" onmouseover=\"this.src='../ima/Nip2.gif'\" onmouseout=\"this.src='../ima/Nip1.gif'\">\n";
echo "    </TD></TR>\n";
echo "   </form>\n";
echo "   <form spacing=0 action='cierra.php' method=post>\n";
echo "    <TR><TD WIDTH=70 HEIGHT=10 align=center valing=center>\n";
echo "    <input type=image name=dia src=\"../ima/cierra1.gif\" onmouseover=\"this.src='../ima/cierra2.gif'\" onmouseout=\"this.src='../ima/cierra1.gif'\">\n";
echo "    </TD></TR>\n";
echo "   </form>\n";
echo "  </TABLE>\n";
}



function Semestre($SemAct){
$SemAct="20141";
}

function Ventanillas($Usuario,$Clave,$strPerCarr,$CODIF,$strDGAE){
$strPermiso="X";
$con = odbc_connect("USUARIOS","","" );
if ($con!=0){
 $strIP=gethostbyname($REMOTE_ADDR);
 $sql="SELECT IP,PERMISO,ACTIVO FROM PCS WHERE IP='".$strIP."'";
 $rscon=odbc_do($con,$sql);
 if(odbc_result($rscon,3)=='1') //si esta activo
  if(substr(odbc_result($rscon,2),0,1)=='1' or substr(odbc_result($rscon,2),1,1)=='1')  //es admin o tiene permiso de ventanillas
   $strPermiso='1'.$strPermiso;
 if(substr($strPermiso,0,1)=='1'){
  if($Usuario!=NULL){
   if ($CODIF==NULL){
    include("../admin/util.inc");
    $Clave=cifrado($Clave);
   }
   $sql="SELECT LOGIN,PASS,PERMISO,CARRERA,UDGAE FROM USUARIOS WHERE LOGIN='".$Usuario."' AND PASS='".$Clave."' AND ACTIVO='1'";
   $rscon=odbc_do($con,$sql);
   $strPermiso=substr($strPermiso,0,1).odbc_result($rscon,3);
   $strPermiso=$strPermiso."X";
   $strPerCarr=odbc_result($rscon,4);
   $strDGAE=odbc_result($rscon,5);
  }
 }
 odbc_free_result($rscon);
 odbc_close($con);
}
return($strPermiso);
}
?>
