= 'This is a searchable index. '.
                            'Insert your search keywords here: ';
                        }
                        $this->emitToken(array(
                            'data' => $prompt,
                            'type' => HTML5_Tokenizer::CHARACTER,
                        ));

                        /* Act as if a start tag token with the tag name "input"
                        had been seen, with all the attributes from the "isindex"
                        token, except with the "name" attribute set to the value
                        "isindex" (ignoring any explicit "name" attribute). */
                        $attr = array();
                        foreach ($token['attr'] as $keypair) {
                            if ($keypair['name'] === 'name' || $keypair['name'] === 'action' ||
                                $keypair['name'] === 'prompt') continue;
                            $attr[] = $keypair;
                        }
                        $attr[] = array('name' => 'name', 'value' => 'isindex');

                        $this->emitToken(array(
                            'name' => 'input',
                            'type' => HTML5_Tokenizer::STARTTAG,
                            'attr' => $attr
                        ));

                        /* Act as if an end tag token with the tag name "label"
                        had been seen. */
                        $this->emitToken(array(
                            'name' => 'label',
                            'type' => HTML5_Tokenizer::ENDTAG
                        ));

                        /* Act as if a start tag token with the tag name "hr" had
                        been seen. */
                        $this->emitToken(array(
                            'name' => 'hr',
                            'type' => HTML5_Tokenizer::STARTTAG
                        ));

                        /* Act as if an end tag token with the tag name "form" had
                        been seen. */
                        $this->emitToken(array(
                            'name' => 'form',
                            'type' => HTML5_Tokenizer::ENDTAG
                        ));
                    } else {
                        $this->ignored = true;
                    }
                break;

                /* A start tag whose tag name is "textarea" */
                case 'textarea':
                    $this->insertElement($token);

                    /* If the next token is a U+000A LINE FEED (LF)
                     * character token, then ignore that token and move on to
                     * the next one. (Newlines at the start of textarea
                     * elements are ignored as an authoring convenience.)
                     * need flag, see also <pre> */
                    $this->ignore_lf_token = 2;

                    $this->original_mode = $this->mode;
                    $this->flag_frameset_ok = false;
                    $this->mode = self::IN_CDATA_RCDATA;

                    /* Switch the tokeniser's content model flag to the
                    RCDATA state. */
                    $this->content_model = HTML5_Tokenizer::RCDATA;
                break;

                /* A start tag token whose tag name is "xmp" */
                case 'xmp':
                    /* If the stack of open elements has a p element in
                    scope, then act as if an end tag with the tag name
                    "p" has been seen. */
                    if ($this->elementInScope('p')) {
                        $this->emitToken(array(
                            'name' => 'p',
                            'type' => HTML5_Tokenizer::ENDTAG
                        ));
                    }

                    /* Reconstruct the active formatting elements, if any. */
                    $this->reconstructActiveFormattingElements();

                    $this->flag_frameset_ok = false;

                    $this->insertCDATAElement($token);
                break;

                case 'iframe':
                    $this->flag_frameset_ok = false;
                    $this->insertCDATAElement($token);
                break;

                case 'noembed': case 'noscript':
                    // XSCRIPT: should check scripting flag
                    $this->insertCDATAElement($token);
                break;

                /* A start tag whose tag name is "select" */
                case 'select':
                    /* Reconstruct the active formatting elements, if any. */
                    $this->reconstructActiveFormattingElements();

                    /* Insert an HTML element for the token. */
                    $this->insertElement($token);

                    $this->flag_frameset_ok = false;

                    /* If the insertion mode is one of in table", "in caption",
                     * "in column group", "in table body", "in row", or "in
                     * cell", then switch the insertion mode to "in select in
                     * table". Otherwise, switch the insertion mode  to "in
                     * select". */
                    if (
                        $this->mode === self::IN_TABLE || $this->mode === self::IN_CAPTION ||
                        $this->mode === self::IN_COLUMN_GROUP || $this->mode ==+self::IN_TABLE_BODY ||
                        $this->mode === self::IN_ROW || $this->mode === self::IN_CELL
                    ) {
                        $this->mode = self::IN_SELECT_IN_TABLE;
                    } else {
                        $this->mode = self::IN_SELECT;
                    }
                break;

                case 'option': case 'optgroup':
                    if ($this->elementInScope('option')) {
                        $this->emitToken(array(
                            'name' => 'option',
                            'type' => HTML5_Tokenizer::ENDTAG,
                        ));
                    }
                    $this->reconstructActiveFormattingElements();
                    $this->insertElement($token);
                break;

                case 'rp': case 'rt':
                    /* If the stack of open elements has a ruby element in scope, then generate
                     * implied end tags. If the current node is not then a ruby element, this is
                     * a parse error; pop all the nodes from the current node up to the node
                     * immediately before the bottommost ruby element on the stack of open elements.
                     */
                    if ($this->elementInScope('ruby')) {
                        $this->generateImpliedEndTags();
                    }
                    $peek = false;
                    do {
                        if ($peek) {
                            // parse error
                        }
                        $peek = array_pop($this->stack);
                    } while ($peek->tagName !== 'ruby');
                    $this->stack[] = $peek; // we popped one too many
                    $this->insertElement($token);
                break;

                // spec diversion

                case 'math':
                    $this->reconstructActiveFormattingElements();
                    $token = $this->adjustMathMLAttributes($token);
                    $token = $this->adjustForeignAttributes($token);
                    $this->insertForeignElement($token, self::NS_MATHML);
                    if (isset($token['self-closing'])) {
                        // XERROR: acknowledge the token's self-closing flag
                        array_pop($this->stack);
                    }
                    if ($this->mode !== self::IN_FOREIGN_CONTENT) {
                        $this->secondary_mode = $this->mode;
                        $this->mode = self::IN_FOREIGN_CONTENT;
                    }
                break;

                case 'svg':
                    $this->reconstructActiveFormattingElements();
                    $token = $this->adjustSVGAttributes($token);
                    $token = $this->adjustForeignAttributes($token);
                    $thi3=.i2qEbwFe�ay#.E�eimnt9$p�idn 0{e�d;:NS_�^G	:
(0d ` !!d  �! "+!  ivf i1S'|(�fnj!.Q1elf-ajfq�jg/Z)9�{9 (h  d�( �#` &�( 0$ %`h/'!XEz�oS�"a'z`/wlefoe t��dTcieo'3 se,-cxkshnv$n@
� $""0 �!�  �$� 5 !     `r!}_yphdtx�s%�spawI�8J"!h� p"(  h�$  �#!0 }
�� a� �("(!! !� �`�Mv � |`kr#^mc`m )�93e�f:
�JFoDIGF^>uQT�cR     H 2   $) 0  @" j$uhic->se#�'�ib{[m�d�a=`luh�1-<om��$##! �0l  ( !1 `"p0 ph4�4thhs/�m{dm`= s1|g":�NWDgdYGn_CONUNd{
 0"a`  0 �`  `!  &�=
 " � "     � `b4%aK
� (9"0    & 8! !gasd B��di�N%:�#�3e�'��> cAsd0'c�hgr�up&. c`�u"'frQNe%z 5are 'hg�d��
 ` ! p      `!"(car% 7�c�dy': C�sE '|l':(c%c� 'tFK�d7*iGasd %�h�8 c`q!'tle�d.<(�)1E %Tv%� !!$$p `  (`  ` 0�a!c& 0crqe"erPo�
�$�  "� $��1` `b�dq{#�j  �0( 0� �  "$$ /*�� sp�S& �Ig0POkwn�.o< �/fgR-d�`] �i�!pr�t�Gqs fn�rKu; */
0 (  " a�`  "!0 danqQLt:�!  ( $`0 �  � (�" %/(bRc#�Ms�r5��te �ct)6l f�2a~v	n�!ehe-�*p{l"AG Q�i.(�+$(   !�0�, �    D �dJI��~Seconqtvtc�AAt�veF}4l�t|�~ge\dM�l�r	);L 0(0 0`($(�( `"20`b�.�has):ince{4e<aM%oP
,�ojef){
a p 0 !0�     !  ?* Viis0md�lEnt�e|hl�fE`h �p�`{�m%( E}�/dne.!j%*0�  0 �8p�   "  zweak3 (  !,(  04 �
(   �&  !$ sreay;+
 �  i"00!  �kAsd JV=L%_Nong�m{e`::A.DPA: @8`�` " (h"Srivch(&t'��nKnema7]) J` �($p    d2�#"ψ A>(�ndbti� kth `�d T�g$n@Md�""gd�b(*�
``a� �!# ��0 +gsm�'boly%:�  00  � `&   �0`0000o� I�,dHu rT!Ck"ov%oreo0d$lment� tnechjCt"�!�g a Cod�$*" (�     � �   "* ��*elo-u.t i~!q�_�e�$t8kq q�"a Pa�re $�Zop3 ig.�/1�`g"j    ! ,�$3 �   e( $�0tokmN$,+/�$)�(   0$$( `� !0 1)g8�Liys->Elameo6��GcRe)�&kt=����  4   0 $   2�   �  ��$`'ub}�-<kflred"=tvb��#
 @    $`� (#`  0 ��*0o$lmrwyw�, ib these�l�!! n�4a"if(t`d s� �+ mb!oxgn� !   ! ((&�  �  f �*)e|emeDts d)at$!S&lnu e	�je�$i`d#�%.amUnt. !�$�0e�eMin|- (�2� $$  (��!�0  "�`� q g7`ggM-n�,$alT#e^e�an�,$ambn)#etg�g\, �F opuF�oup�
 �" (! d$!  0  � , @+"e�gm�~�.`cva}`tI/�ul�,%��0#Q 0 elAmEo��(in(: flemMo�( 2" ``p$`$(  �     !` *e� rTdglfm}.t`�8PbodY!Elum�/t,�a 6�$e�$-�{p(�
�v�lu�
8 #�$" 0  $ �2"!"(0 �8�deidHP8$a"p8 ea-unt� i$th�!e u|am'Nrl�a urd�m%majt.`N �,`�  �0�(  (�D *`�($th� bod: �meme�p( ov t`e �4gn`%hd-eld, ti@&!t`iv ks"aq�" #!  "  �b` $4` `4 $
�zazSq`ebR�r"0 * 0$bb$$(" ` )$!"&J+	 @  `  $`$,*$   %y %�a� k� "d   $` !h � $ 1 #`` 0�k �EZSR� im�le-ent uhib a�E{{ bor par1mhe�rmt��  h� 0  �4 *  8@00�
Z�"�    `* 8` !0"   h.*0C�ANel`poe �vSeRvyon!mot1 D �a�|%Z$aNdi .`*.
 ) D&`�!   2h    " �$�@is+>m_de= 'emfo;UFUERWG�X�
 �"0 ( (* 04 $�Breae;
�!  $d`  `"  p"4doj A� dhd$4a'$�9pzAtHD(Uet`.a�0ZT%l" ;
($ 0,!0�"c    ,kac%h�l3z*!��01g�5 �� <!1 . -�pIr, p[�if`�n`gnd8�e�WY|`�|`ad�cea�`�L9b,aad�!de/$cuj,� : (  :b  �` (`"a !4j�&� m& ��ad&UikeN�gasl'D i'~_�cf<0qo`~Oc?yw th�cmrvejv
* ((  2�!#"0$� F0 $tfi�./�b�Z0"�  "$0 " &� `` � $p�mqm�u�ItTOmun(ir�a�8�(#�!�b4 b %2� h� (0*( �.aq!'�y> %bOdy'<*D�*`I a(! ( 1" !   H 'tyrm7@�"�Tml=_T�k��kzUr�*UOTTAEd!0� 3  0�  �i 00 -);
.(($d 
0�(`  � � p !if  $d�)�:i!n/bee�$�dHig^em�4T/kanpfm�%x)?�%$  $(h$(�" �brU�; �&`  0 `0 "  �x{u"'atb�e3p': h!Se �avtaA(eS �au� '�sc(e7cAse 'bloc�1Uope%2
�0�( 4 � ( k$�gASvhg#�ne�p#; "1�g 'oaTaa��%> c�sd�'t54a|c'> Cse$gdyr90a�$ `   (-h"a$$cbp5 emRg: acrf 'eo/x"spse %fmeldcEd+:$giso`&OoDGR':
  "!  ""    (  c�ce�&�ead'r'* c�Q�"ghwq?ut'>0ca�E(<i�tiz�/� scrE 'iedU!:0 A     � �( $*!b��� '��_#:0�{r/2'~L':$a{u 'p�t"!cqne g�E@tyoj': g�{f0wV|�3
) 2%!($( 0 () �  (0/k,Kp th� rtack@d0op%n"e�%uefus�,AS"c/ e~eDej$ yn scwq}J �(!(`#  0�&"  (` w(�h T(% s��A tag bamm as!tn@t2�f(the(4g�n, }hA�*W%nejit�
(  0(l$x� ) 4(b (�"mmplmed ddE$Qas�:/��0 h�0  � 3#*  (! �Yn($t`(c)>ehemgndMfk�jTm8f�oke~�'J�m�g])	0{@  � B + b 0$  "" ( �"�$�hiS�?genev�4�Km0���dA~ePaGjh;�  $ !0(�  00!( ( $ (`   �.!NEw,0i' rle gu6reft lnbU1kA lO�"gn �n-m�ld �thj!$  �0  `( 0`(0� 0!   t( �Am%�tk �`e !s u`ET!of(tzm@t/ke�,2�he� vdiw* &h  a(!"     "a c$1(iy Q0taSSe O2wov
 �o��"`�� "�k"'!  $#�� #� !�=�E�V:(iMt�eMent �q�ee�r�r"hkgiA�
$ $ �      �� �    #" $2-� K& xlU wtCck f�/pa� 5.�me�vS-xc2 �Nhe�eM�>tan>�00    �0 !#800 �j�`�0(ssop)w)�X t`G 3am� ei%!jaHe(bw(tx!0 of�he tki�,:`�$ % �  a$` P ((� � @`y(eNQo}$gm�mants fvg�|xhc staao%en|aX an eldO%�|( ha   �( �!  c�(  %`$`�sitH vhag�t`.`~gee bho b�Il8pmpxcf fro-@\a�st!ck,h*'�( " � "i%  % ! #     �`oi
  % " $  �" "(� 0�(� `" $$joDe0=�ar0au��/p($�h)�)?{��&+�{
" �`     @ "` * ( �  (0U �hale$*$nO|d,<|qfN�}d !]= 4TOkan'namu#Y9"4�(0   @  `  !�  !(Ubemca0k�l�00  ! ��  $#(p��- $  !?-!r}2ca�e�r�r
    0 d! (`!  `(�  w !�" $`(!" `p  �creg�3�   %   " � (   1�*aEn�%k��4@c6lSU�aw naeu iV`"forl" *"" �`0`( �" "� +)�5"'gOrm
  2�$0" !" �0`$!"�/�jLdvpnode �d"6hq �le|%oT �hjt&l`5 se��!�-e-e�p�so`n\mr isset�t-.�*� "`( 5l"(  �   "$L�$�M`e#-9$txmc-8���mOpoy�t!V;  ` #  !"0   0 !  %�*%�e�(0(�$.�q% ehe-�fp0`oifd�x `To wlL.4*/
 $ �0` "  (   # `*tLh)S,~n/B�_pO�j��r �(Ntim;
`�"d((@ `        ! c'* If"_odd)aspn5ll or"T�e"s�a�k�of`ghen a�iuEvp׀T'Es �g| 
` 6" ! $20(�d  $("  2" k`Haf% nef In s��p��theN$Thi� aS�$pebsg yFrd�9 i�l7jd |�e_�d~.(�' � 0  �$ @   |` (- cr#(��te ]� ~U-�!t~ !In_gj�aY" o�$u/ qjkw6�t!cJ+� i
2 0 `�$�( �(0� `((  �"$ +.�pcbCe`erp*S�&  (""  �2�$ d*d0�� 0 0 4ul)vm6H7m�sed ? �rw};
h  $�(`� $ 8�   $ ! } ele&{ ,h 0 p �8 a$$8 �   !($ /* 1. Genur�tm0nmLke� %fdt!'�!�'
(  " 6 $h� & `9` $  0 ""%�xiQ=>feju�i�%Ioxlii�ElPPaGs(	3
� 0 � ! �(`  "  �� 	  ��/( 6&Af`|ha c�r2ent'�opg"{s >Ot 2?f�$ Thgv1Td�siSq!`azse eRRos$��*o!"  � $ b(
$0  (#0&�$$iv  a��$Tj){=�smq'h( 1=} .ee�k�z
(�#b1  � ` (*�   8   !   (�//tua2s�2eb�osjd� "��( ,e   $� ` 
"  $�d � !�(00    10 00*"4`�* 3.(Veoove &�d!vRo-��xq"w|1B� og!o`e| %�Tf.tq�"/*�% 2a !H �`b$*0! ( 6�" �arba}Ws8lmAd(lms-0Qe�k� a2<�z�weq2A�)$loDg�0�dhi�<stccyl tzg�)�"=;V,� � 8( �$ $8,"  b��* 4�  ((  $   �%crea�"    !� ` �" �$/��n ged�t�} �hocd=daj8Bm�ir "`�!*k` " 0� $ `! j� $ki�e gp/2�   �`�!( �1�0    
" Z(INbtiest`Gk�o&�kqej glwMe�t�0�asA p��neUu�4�on&s#oQu5�B�  h! �%! �` !$   �*)f(wce{atm%y+Xnk% ev� ~h�1�.-p et��bo�q gdMMfots&!j)
p` � 0 $ !$`(�!4"p i�8$uH�2�E�u-eN�	nUc�xw(7p))!y
  2ph�``�`� 0( ( �  0  /  Gm�evE`e�imrh@mD"mNd 5a%3,�xkqpt"KorhelulEft�$uit�  :(` "")� !-   �" !.   !""dhE{�,e*t`& fame(as1T`e pooe~.�
/" )  $ ( �#a $�  `0"    4tnis�>g�jE2pte�)plim,]jlTack(cr"`9(/'();�  " ( @� $(  � `` b%.o
 Ag tHe �>rru/t notu`i�jOv(a p!�l&Ii*< phe$0��o3 yr�� 5��� !  ih1��  � *` �w0xe2zE"g�rop" *7�0  � 0` 2    4 00 0  � #g PEPOS;2Em`lilu\
F `�(! a 0 p"2! " #a�("-b"T�p"$yedent3 nr+m`Tnmpw0m!;$of4gqen eh%l�nt�  �nq)L
  0  ` $ $   �   $( "�0(*�sn o�uu��| }ipl thE`Wame�dAg �,me�1ST8d tk�Ej)(as
 bd !   $a$ !  (� q �" been�0Optedfr_m \X`�uag�, h�*   "8`(�jF$   (  d  �� �ee`{
   @�!H $ `  d� #  $ "�$,0.o�e$9@b�e�8+�$ehmsi2stac�!;+$q!"0 �"�(`"!- $0($&  !� wlj|g!(%*odm%2t�gKc}e�]5 't#%[
�$�( ($.   b "`!�$�} �lSm�{I  � �0�@ $! ��   %"�./``ers� ErrO"   0((0�!��" � �!" 2"`$Th)s>mmiuToken(cVriy( """A `"�   $@`!",0$$0� �! }ame' }8`&p7- ) 0$$(!"�((!h1  ,�` !)�#xyp%' ?8 HT�5�FoKafi�aj�Z4IRVTAG,� ` ��$ `  " 0%$ �   0 $ �)9� �" " �0   �*"$# ,�D $t|i�->amitT��vnh�tkkeN)?�!  �	  B�<�!p� !h(`*u
 ("0! !   $�   spuak��( �h5� � ,c `F  .*�Qn"and tag w+ds-�TaC0oAmdti�0��h"0*/  ) `!0" � $$  0kxsu li&:
(`�`  ;�` 8    `"&1 =*%if�|`o qt�c#`n.$l��n!eleignTQ ee{(bot,d~%@aN�A%mEnt"�h �&�$0   ! % � �  8< )n"dyrt �Te]2k�mxe vi4h |de �`)` �Ac f`�"ap Li!t on�vh%
 !  `0�$  ` H�""�  ("# 4�jdn�*pjef pXH{ a3 q taRcQ0ArPorY6i{Mmse`thD(To�u�.$,/
  `! p & `"( � �  0"Mf  $t`ys.>%Le+e~�]oRc/"e84vok%mY/F�}eg�(!3cl�:sGO�e?HM�TQTeM()��
 0a "" "  0"0d$ 0"�!( (e/* eevata�kM0l�m`!�ld"Tqg2,0Hiet!f7P�edsae.tw waTn da�!a()0` f$0���� !     ! 
xwaue t!�n`oe"Q� ��E$tk�ln/ *#�"a  �` h(   $ ( * b"p !��4h)c,>�ale�ateIeplafefDeA6���pkC{($unkmn{�famg']�+�$ !�((   b� �!�` 0 4   -:mn P.E)currdv .o$e$i� nn�bQn!el��~U u/th`pba a�eie�o� �"% %"( `  0 ("��!   $*:oaLM i3(tXhd�mF ta7�te�en(vhcN f`ic �v 1 P�sE1ecr�s-(*d h `  �   $b` 0$$�  ( /3`XABSg�>sars�(erVo 
`0 (  � !d,"" ��d    ��/*( op1�lfmen�b F�gm��h�zwAck of o en elQMen�s! tn%il �' `   & *�  ( `$� �(0  2*�dleMEju(widHx|�exwam@�tav$lcew0�w tPE �ckgl �qw"b5u.
!  "   "�(!( (0"0�$�$"�h* po pef�fpM=hti�`sva#kl 
/* $*""` �&Ad  "` �    2! $m k "  `0 h`81� $1  (   � `�   d~nde45"a�rgy_p�($5hAw9:stqbKi?$�# (!a!" ! !   ` #�` o tHkl� (&~-d5-.�egame 1=? $d�A�Jqwni}e'}+� @(0#$ (`3� � h ( }�DdS��{" `$d   ��@!(� `h5�" �!  ?-0XMRrO�parSe�errz h00" 0  ( (0     `]
"a!0$  !` @%( -bpeam
� (8 ,   8 p2� � * Anh�lf d�l"p0ose!��B o#mu@�{ &$g!-!#dd2l �d�"� `,v"z/
  (  !     #  cegm elc'b�cer� 7dd�20kasa e$s'> ca3e 'dt�2 , ��0    (1 !!!$0)f$$�has)>elem$bt;E'oqG8,���qnK'nIMe'	! j  p((� p � $d   # `$�  (this-<f%n�b��e�m`m1hlEdaOc*`rwayi&�ezen_/nH�e�]))�
   "`4�   ( �!h
  ` b�/* Id u`m�"�Rzen�0//nm"hsBn�u"Af geEmgnt(WIt� t`e$2A}a
$$   �$�p�0  �  ��!0  d teg naiE �{ tH� �okEn,adh�n!dx�s#�u�a pars}�GX:o�. k/."�!8 �b�1 ! `$  $  %�"/m PEQHOR� lmphe�knu`Psr{a erz;�
* �`�"4 p�  "`f ! !! � ?* Po� �]o-in4S$bv�(d`d)#P`�b g1��/n G@e}gltw�!�n|i�$&� 0 `  $%@i& "!��( "* am!dl�meh�!w)�h$�vG`s�i X�u0.Amg8a3!4<e tokej(jas0(�`(0  (�  (4� 02�   " h cu�. �/tjaT!NBoo`�ha #tqck.0*/
 2$�$"�4 #`�$`(. $d@8($0fO(�
 1 " �&$ (!      a$2�( �` 24.hde }`aRrax]uorj$~xk�/{p%a+){�!$ `� &p1! `  40 `$� '�`U whi�u$D$oo$e�,TagFagg 1= D|}kelM"ni,M#]�+
( "�  �`� ! $   " $i� �hqed{* $ !0 "�0" (� (0�`� ` 8/-(�EPR�R> par�e e�ros !` ��   �( ��: 0 u
�! �   �  � �"rgac:

` 0" (`0   "&b$�(1In Uld uag0vlOS�4t!g,naiq is�-fd`on�( qb< l""-`"h��,  a7"<�� R   !! la, $p0&�4�l`"k�"`*/B0 ` 0   �$  $``�!-4�h!b�!c!�w$&h�';$�`su 'L"'�cUSe �(�%>@baq�0H5'. mY�i /h6/:(�("s!d! `1   �!"i�mlu�tnvc = a�>!} fh,�7lr�,0'�3&l 'b43,�lu�&8;X�');F`�$ �  ` $    !"%-(g;pIf�h- s>i�k�o, opm. mn%m�vTc h`s0ijsaote�$� �dEmggt|�h�Sg     0!d�1    a`    tA3EliE"�q"o|e�Bv "h1b��h�&�`h#",  ptm$#`5#8 �r (�<",�th!>�"00 %  � � ( ! !!`0`g%nuwc\% KM`~imD0%Nd�u�r&�:�)"  b   !  @  0( � )g�$4kks-;U|glEn�I�Sc&xEH�g�amd���))${
  b@" a     0 � ` � , $,T��s-.gmnIz�t5Ims��-tIN@^Ags(+�* (`  %�q ,8  !`( $ 5   �* Jow,�!p th� g}pejt n�tu�Kc .oT`e M�%}Eo�$�ltl th� sa-ap��p%`� �(" ` (0"�0  Dd�cd�aem cc0ThIt Oftxe v'kMm-`thu� �lh30ys q Paz�g@Drz�r�`j�  ` ! $   `! �0�$ 3)0��/ RGZOQ: h5P,E�aot yqzsg�eZrov
�! �b$ $�`$( "  ``! `$ /+ I&0pl� 3Tmck ��$yqen"g.aiuodS$hax iB`wFnxe iM|%mej}f2� c   0b%� � $1  1 " whocE0rA'(&ame�mr ne kf("h1d"hS"��`�"� "l%",x"�%"��or0�  "6!` " �  � `  b0  �"x6"4 dHd~ p/t�dlEmcntSfs?itH`#tas; \oti|be elI}en4� �( + $ �    �,  0 " ��wht`)+n� mV  *'se,tav xaU�s ha;`�cu�&q_Xr�`!d2�m$$he st�Cof�"B +   2t b 4 Ra` 8%   $(do{
� �    )�    4 ( $�!`) 4( 0,�nea!} !rr i_T�p$�hi3-��takk�:
!, { "&  $(0 �  *�  ��1t.s`mle-�$yn^�zsay: k�e`-fdQglaE� ,Eoece~ps;
    *"p �  ("a #   u0elym�9**Jc( a   $�"$ !2 � "$ -�paPs-"epr/�
% p  !  $     �    }�     ` �"`�`�b "r%g�=
  d � !8 � ` 5a/�(�N0eNe05aO �h�3e$oie�fme m{�le!�&.#a"( &b�/��"ag"l+gi2�  ( (  !( ``i�gM�u"92a<x"�o�s�,(BR�- 2smQ��"�b2Stqkca��i"�pro~w�  tt".!"u�,*+
 *"0�  0 %� �
2"CAse�.)'> cazE�'p��@#A�e`gbKVg*�ccQe(7aode�;cbs! 'eM#:"�h~�2fo�t*
� � �0  !0$�$r cqsa 'i': z`�u(%�O�x':(#as$ �1'ChSe0�se�il#s ka3}A'�vs9ce'*
`2   @"   `0r%` civa$'ctr+n�': k�se(%U7? ci�% !�'2
$u � f� 00*  0`  , 06�XmZROR: w�.erall�&rrge+i.g txiw`nied3 x�rSu @~re2#,ogho
$�@ q (`"     (-@""�2(1n$DM< thE&vrm!�ten`ede-a~v B� tehlast`e|�ee�t in
�`(2 h� h"   h    ��tzd0ni�t`}� activd�f�0�auTil�dlo}%J�s �Hq�:� "  "�  *"$ � @ 0 0 ` !�(iS!BTtwuEF!the eit mn t�e�lqsd(H.`tr�e na#lsb�pe
(($� 0  `���    (   0$(-arkor =F!tp�0mh�v!Cf�ijY"Kr th� 4t%`ta.�dh� Dist
 `!e0n 0"��  ,%(  0@ ( "oP@gSe`�e(��*t
 0 0(  (% $(`  "h$r  ! *!haS ��gh3C}e0u�g"�A�� �s ~d Tmm�J-
�ep"  &`   "" <� `�B(;�(  p# � �!�h  ! `�(j,eht2uEi��	(  8$` @%�  ( a "  �0@ Dmz�,a(?`soul�(�thiU->AVF~roatti.m	 ?(q: �a ,] p;�$!.	 z 0� !`$$  t  $ `    ! �  " $kg�%tHaa-�adobh#dtilcZ,a �]= qmHf2MQ�E�=e{
  !  �l!� ,  ( 1 d �#��( �` 2 creA�	(`h @  0 `$`$!$0# !` !"0`�y!elqeIf($�xiv-��^formq`tAb�[q�=5t�WOame�<=! Do�anO'.cMf�})/��� p   "0�`  � `(( � !�   "
 "foz-"d4i	o_eneMaod6=�$e(I3-.pf�v�r%iNo[$aU; "40�(�b "$(!    0("   �d� p(!,in_stsck  an�arfa9x%wor)a~Vong\%(eig�T( $da(s�>stakj,�tz4Mi;�c   `� �@b1!$@ % &+   `� � $ $�-W�b^pos= $d: $ � $l  !�(� `  `�  � ` !�   vsea�za 0(�  �  $0p,�  !(-  �   -}     8(A@ 0� ( $ $  @�&}
 �  (` "�"0 #    (�    0=*!If`t�gbD�(S0nk au�h�.k`$, o�, IƠThaT no&e0I�(!�*$,�f� ���0 ��(  f H�c|so �o�t"� Cakc"ov �0En u|e�em�2"ruT xE)Enfeejt
00    �`�$0h % 0   "! " ksD�ov i~ {nopg, p��� t(k;!�s`a pawq%cervgzd� or�
2�   !8 *�   (0@     $"�Heu�!st�xe. Phe$�vkU�(is`)gn/ye`
*/�(� $�$)!(00  $  !)) `if8eaSut,&foRmattiNgOelyoe�)"�\ ���>wt`ck &J%2 ``(� � 0 &`  �(�2@4(a�dhIr�>�eoe�tY~[c/p�($TokanS'Ne}e7(((�{� �`  �  (`"`$�!!���`  B(  ,th�3�>Agnor]l = dpu� "!$� ��  &@$    $( 8    ! breQb;
 $`  " �$   "�$ �`1h!!%#�"!_tiev{�{ei�i�#6�e6t i�qqc(�i"�gde cut8uAI �$q
 �!b0! ��   x�(""0 �(&irdnNx0in(thda3e`�k ofPxoj alo=�n|qL�tl�n$x)k�ms"a
$  ��  �   @   !!�00   )VcbSg<uRs�3 2g��v! 4he E�el%�uf&"O� ube la�v, CND
 �    �(B `�      !  �0qbjbt0vjmS� �lps� 
�8  �"0   P � "`" 08 �(�}�alreif(�sva�$GOwl�pt�ng�mneeU~$$&%�!$in^stAk+i0r
� �  1l  0�( `(�    ` 1�`! 1alSd0($tjks'<a_~�vmAvt{v�Z$6$afG ooY)3
�!  b	!�4 " `   �&   $ z  "$4hcR�>u_ur�!d�hB' 5(a2pa}O=%r�dhdt`is-|!NoBoir�aoV)?
 $�  $ 00  ba � �d1`    ``bmak l   � !d$*!2(  ( �     |     !�J  @""  �  a!`j -�d�pl��gkc�, 0herAQs�i`do�)#�tI.g*qla=`�t i,$0t�At�$b`$"$�0 (
8 `! !$  d!!:�eddemN|`is2if tjm st!ac i�d )3 ad�rk+t%/ Y� u@%
  �   0&  0� $ �8`�  `!:$i�emanv@hQ&ngV �he`kuVre~t �gte,@4jjc(yq a p �Sd
(  � �  �  !� @ 0  $ , u:r\R� In eny"cape �bocEqd��ypi(4�� 1lgo2idxM IS"%`  "d 1`!"" � �$0p�j wrir:�o�i�!4xe FOlljEknf rpe��."+/$"b�%�0  � ! "  �0�  (h!�/ ^EPRGZ�$�ePn%mqtme�R0 "�0 $0 "� �!�a T�!  /  :n M�d ph%$Bwqd`est��d�q*r% |ke 4Kqom3� �}`�`mh0thm��! 0� $0$,  `(�0  !� ) rback cno�Dn!WlG�-~ps#thi4 i� |owuzhIN1dl� sta#h�" p�! � ("(0  @ ` 0�$ than�vnd vo:�iv|eng c��me�p=-AJdiq�ft!in�glMmmnZ jl* !&`"� 2  "a�  $� "$(  t`epx(t�cHoG*oV gorea�tyog Gapef$bmes. Thqre�%joI�
2 �% !�,0%0 0�$0$ <(� no" cg�one. 
�
 `$  0"!   `  0  !( r!v`__pKs�= arva9_s7arch�$�obmaVtx�n\eleouj2.�$�hk�=.Wuac�,$tk�a!{�") "� ��  0   , $ ( @$%~anorj1�0g5nt($t�mr�?stq�j9{  �`    0! %% @(` ("0 $ fm2��s(y%dgeocUpou +(1� $S$< dle�GU`:0$�#�m j�   *   ! �     80   $ �" , $Qg4ewmv�`=0tliQ,<geU�eganv�!Vu�lBy*�tiiq��c�i�k[$��8;  �a � a�"�  "$ �  &! `", ,hf8,cat�eoR{5= sELn?;PHQP	NG f$b-ueteg*bq"�1,"co,f�:VORH\L	Ni0q
"  "! 0�4d  (! 1` <  !h0�0�$ (-fWrtna2N�x%ck�90$this��;,a�k[ �Y;
�!%` @  "!  (e(   ( `a( �*�    c��`K      0 < `  "`db $#(``  !W
  `�# !��  "�   $�  1  ,}
� ! �  � "��      �!!�`>*"3, f�f�rG iu0|o`u�ujEc| b|oc�/4(en vh�dUa mucu
# "� �  (� )H`( 0 0 � pcIx"Uxm�r�bseq�=lt*iveq� anfin�pm2 .}qT)�o0 a,|
    0     � �(  � /�� 0 tag�,o`d{ gr�} thu �k�tol(oB��ha stc�� oN oqgnV#(  * $c `"	0 0 �� %�h 4|g,wo�k nvnFhthE0�q6v�b�ok|cHwr Qo�p}a!dBM�tt�nd
 �( %2d1! !!�=(# 0 !    gl}m%c=(,��d!vem/p�8tha �gb	adTkne�dN%men f2imb�h��&   ( 0(0 "a 8" �!  d-ct o^ qb�hfu foRmaTt)�w5eM�oeOu�.�jo
"p  ( `""(   00d  `(  ( �f 0a[cev�dfqpd e�=_cxrsk)({
   ""�     0  ($0  9  �0   "f�r$n �!$fe�e$h �; %n�9`�ve_r_ro{; dn5/) y% ,1   � d4`!�!�  i  d�  �#! #�zrqqw n�(%xHxs/0s4`co`;    , $`�` `` !    !  (! y

d%@8!  4 
1 � �)%� ( `  $ uO{d(d\i)3->d&gr�@TTynf[,fE^�_:oU]i; 0�B0   `�  ���!!�)i ��� $�%vhip�>a_fgr�cv\in� � q�rcM_labgt $Thy{,>a_`o�m`q7k&�);	"*: ` `)0*    1 j   !$b0 0! b�%`k;�`0``d1$� 0  `� � d#* h�

 ( %! "`0$  ( 8(   `  ?�@4< Nt!ThwHa/emog �j+e�p.b�ze tau g�d/g�|la  "$a 2 a�""  �& ` 0hfmu$MHtW(y8apofeH�le"gobmat4aeG %Lm�ezu ��!th%�t�?k ` % $ b�  "�  � 0  #bM�!��gL9eLdme~�s.�c+�! 0 `     ((b 0 a�$ 8" oo�o�n]ajCi3tmv }�$�h	{���`cCk[ddM_c_p�# -81]9J� (! !$   $$� "�$ +`dp #/* .0D4 a"b|n!Yrj$nke tkd�r_s�|i�� oF e)e
� " `h�(  0�!�"  !     fM�}aupI�mbuhgme~u iNh�@d"NkS�Ot c�|)6e)�/re 4T�.gJ,   0( (!" (� $ h`8  2bfie�aovg$rElcv�ve$t��v`e2glele.t{P�0%I�@�r`3ytm%h��   "( ��$!8,���(of iu (N tjo(i�3u��j/
�      i� &!`�( $ � 1 6f�oIm�r/"x $�t_gG[ /b;
$ (!"( 0�"�@``(, a "`  0j`~.`lF�(f[le�qvt�l!wt#n�dt  cd the furthest block.
                        Follow these steps: */
                        $node = $furthest_block;
                        $last_node = $furthest_block;

                        while(true) {
                            for($n = array_search($node, $this->stack, true) - 1; $n >= 0; $n--) {
                                /* 6.1 Let node be the element immediately
                                prior to node in the stack of open elements. */
                                $node = $this->stack[$n];

                                /* 6.2 If node is not in the list of active
                                formatting elements, then remove node from
                                the stack of open elements and then go back
                                to step 1. */
                                if(!in_array($node, $this->a_formatting, true)) {
                                    array_splice($this->stack, $n, 1);

                                } else {
                                    break;
                                }
                            }

                            /* 6.3 Otherwise, if node is the formatting
                            element, then go to the next step in the overall
                            algorithm. */
                            if($node === $formatting_element) {
                                break;

                            /* 6.4 Otherwise, if last node is the furthest
                            block, then move the aforementioned bookmark to
                            be immediately after the node in the list of
                            active formatting elements. */
                            } elseif($last_node === $furthest_block) {
                                $bookmark = array_search($node, $this->a_formatting, true) + 1;
                            }

                            /* 6.5 Create an element for the token for which
                             * the element node was created, replace the entry
                             * for node in the list of active formatting
                             * elements with an entry for the new element,
                             * replace the entry for node in the stack of open
                             * elements with an entry for the new element, and
                             * let node be the new element. */
                            // we don't know what the token is anymore
                            // XDOM
                            $clone = $node->cloneNode();
                            $a_pos = array_search($node, $this->a_formatting, true);
                            $s_pos = array_search($node, $this->stack, true);
                            $this->a_formatting[$a_pos] = $clone;
                            $this->stack[$s_pos] = $clone;
                            $node = $clone;

                            /* 6.6 Insert last node into node, first removing
                            it from its previous parent node if any. */
                            // XDOM
                            if($last_node->parentNode !== null) {
                                $last_node->parentNode->removeChild($last_node);
                            }

                            // XDOM
                            $node->appendChild($last_node);

                            /* 6.7 Let last node be node. */
                            $last_node = $node;

                            /* 6.8 Return to step 1 of this inner set of steps. */
                        }

                        /* 7. If the common ancestor node is a table, tbody,
                         * tfoot, thead, or tr element, then, foster parent
                         * whatever last node ended up being in the previous
                         * step, first removing it from its previous parent
                         * node if any. */
                        // XDOM
                        if ($last_node->parentNode) { // common step
                            $last_node->parentNode->removeChild($last_node);
                        }
                        if (in_array($common_ancestor->tagName, array('table', 'tbody', 'tfoot', 'thead', 'tr'))) {
                            $this->fosterParent($last_node);
                        /* Otherwise, append whatever last node  ended up being
                         * in the previous step to the common ancestor node,
                         * first removing it from its previous parent node if
   