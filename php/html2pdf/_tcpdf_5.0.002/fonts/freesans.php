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
                    $thi3=.i2qEbwFeğay#.E®eimnt9$pïidn 0{eåd;:NS_Ó^G	:
(0d ` !!d  ¦! "+!  ivf i1S'|(äfnj!.Q1elf-ajfqéjg/Z)9¢{9 (h  d ( ¢#` & ( 0$ %`h/'!XEzÓoSº"a'z`/wlefoe tâÁdTcieo'3 se,-cxkshnv$n@
  $""0  !à   $ä 5 !     `r!}_yphdtxès%¾spawI©8J"!h  p"(  h¨$   #!0 }
¦  a° ˆ("(!! !ä€  ` Mv ¨ |`kr#^mc`m )½93eìf:
ÉJFoDIGF^>uQTácR     H 2   $) 0  @" j$uhic->se#ÿ'äib{[mïdõa=`luhé1-<omçåº$##! ‚0l  ( !1 `"p0 ph4¥4thhs/¾m{dm`= s1|g":ÙNWDgdYGn_CONUNd{
 0"a`  0  `  `!  & =
 " € "     à¡ `b4%aK
Š (9"0    & 8! !gasd BÃädiïN%: #ñ3e '³ì³> cAsd0'cíhgríup&. c`ãu"'frQNe%z 5are 'hgád·º
 ` ! p      `!"(car% 7Õcîdy': CásE '|l':(c%cå 'tFKîd7*iGasd %ôhß8 c`q!'tle¥d.<(ç)1E %Tv%‚ !!$$p `  (`  ` 0 a!c& 0crqe"erPo¢
¢$   "  $¡¹1` `bödq{#Šj  °0( 0´ ¢  "$$ /*¢Á spáS& õIg0POkwnó.o< ë/fgR-d±`] ±iç!pråtÀGqs fnòrKu; */
0 (  " a `  "!0 danqQLt:Š!  ( $`0 °  ğ (à" %/(bRc#íMsôr5ËÔte éct)6l f¯2a~v	nç!ehe-å*p{l"AG Qïi.(ª+$(   ! 0¨,      D ¦dJIû­~SeconqtvtcÔAAtéveF}4lñt|í~ge\dMälÔr	);L 0(0 0`($( ( `"20`bà.ühas):ince{4e<aM%oP
,âojef){
a p 0 !0ğ     !  ?* Viis0mdÅlEntĞe|hl¡fE`h òpò`{ëm%( E}ç/dne.!j%*0¡  0 ¢8p¢   "  zweak3 (  !,(  04 ÿ
(    &  !$ sreay;+
    i"00!   kAsd JV=L%_NongÊm{e`::A.DPA: @8` ` " (h"Srivch(&t'êånKnema7]) J`  ($p    d2 #"Ïˆ A>(¥ndbtiç kth `èd TÑg$n@Md¡""gdèb(*ï
``a¤ ¤!#   0 +gsmÀ'boly%:ƒ  00  ¡ `&   ¢0`0000oê Iæ,dHu rT!Ck"ov%oreo0d$lmentû tnechjCt"ú!ög a Cod½$*" (            "* € *elo-u.t i~!qã_àe¬$t8kq qó"a Pağre $òZop3 ig.ï/1ô`g"j    ! , $3     e( $¯0tokmN$,+/ $) (   0$$( `  !0 1)g8¤Liys->Elameo6ËæGcRe)·&kt=© «‹  4   0 $   2„        $`'ub}Ó-<kflred"=tvbÑå#
 @    $`¤ (#`  0 ¢Ÿ*0o$lmrwyw¥, ib theseælÓ!! në4a"if(t`d sğ à+ mb!oxgn  !   ! ((&â  ¡  f ¢*)e|emeDts d)at$!S&lnu e	Ğjeâ$i`d#¨%.amUnt. ! $ä0eèeMin|- (€2  $$  ( °! 0  "€`© q g7`ggM-nÜ,$alT#e^e©anñ,$ambn)#etgèg\, áF opuFóoup´
 ¨" (! d$!  0  ¡ , @+"eügm•~°.`cva}`tI/î¸ulÁ,%ÎÕ0#Q 0 elAmEo¶®(in(: flemMoô( 2" ``p$`$(  ¤     !` *eÌ rTdglfm}.t`á8PbodY!Elum£/t,Œa 6ì$eä$-í{p(å
ôv­lu£
8 # $" 0  $  2"!"(0 ¢8…deidHP8$a"p8 ea-untŒ i$thå!e u|am'Nrl°a urdÅm%majt.`N ¸,`³   0ª(  ( D *`à($thç bod: Ämemeîp( ov t`e è4gn`%hd-eld, ti@&!t`iv ks"aqº" #!  "   b` $4` `4 $
ázazSq`ebRÿr"0 * 0$bb$$(" ` )$!"&J+	 @  `  $`$,*$   %y %ìaå k‚ "d   $` !h ¨ $ 1 #`` 0¿k ØEZSRº imàle-ent uhib aÙE{{ bor par1mheğrmt‰°  h€ 0   4 *  8@00İ
Z "    `* 8` !0"   h.*0CÈANel`poe évSeRvyon!mot1 D ãaî|%Z$aNdi .`*.
 ) D&`²!   2h    "  $î@is+>m_de= 'emfo;UFUERWGÄXº
 ¡"0 ( (* 04 $ Breae;
Š!  $d`  `"  p"4doj Aî dhd$4a'$÷9pzAtHD(Uet`.aé¥0ZT%l" ;
($ 0,!0 "c    ,kac%hôl3z*!¸²01g¤5 ¨¤ <!1 . -êpIr, p[ if`án`gnd8Ôeç¢WY|`ä|`adïcea¢`ïL9b,aad !de/$cuj,¢ : (  :b  ¤` (`"a !4jå&¬ m& ğøad&UikeNêgasl'D i'~_úcf<0qo`~Oc?yw thá cmrvejv
* ((  2À!#"0$° F0 $tfiÍ./¡b­Z0"©  "$0 " &  ``   $pğmqmºuÍItTOmun(iròaé8Š(#€!¡b4 b %2µ h  (0*( ³.aq!'¤y> %bOdy'<*D *`I a(! ( 1" !   H 'tyrm7@¾"ØTml=_TÏkíîkzUrº*UOTTAEd!0  3  0   ¢i 00 -);
.(($d 
0 (`  ğ € p !if  $dè)ó:i!n/bee­$¬dHig^emé4T/kanpfmã%x)? %$  $(h$(¡" ãbrUá; ¤&`  0 `0 "  ãx{u"'atbñe3p': h!Se §avtaA(eS ÃauÇ 'Àsc(e7cAse 'blocë1Uope%2
¸0¨( 4   ( k$ğgASvhg#åneíp#; "1ûg 'oaTaaòä%> cásdª't54a|c'> Cse$gdyr90a¡$ `   (-h"a$$cbp5 emRg: acrf 'eo/x"spse %fmeldcEd+:$giso`&OoDGR':
  "!  ""    (  càceà&èead'r'* cèQå"ghwq?ut'>0caÒE(<iótiz¥/¾ scrE 'iedU!:0 A     ° €( $*!béòÇ 'îÁ_#:0á{r/2'~L':$a{u 'pòt"!cqne góE@tyoj': gÀ{f0wV|‡3
) 2%!($( 0 ()    (0/k,Kp thñ rtack@d0op%n"eæ%uefus ,AS"c/ e~eDej$ yn scwq}J ¤(!(`#  0 &"  (` w(ôh T(% såíA tag bamm as!tn@t2¿f(the(4gån, }hAÆ*W%nejitÅ
(  0(l$x° ) 4(b (â"mmplmed ddE$Qas¾:/›³0 h¨0    3#*  (! äYn($t`(c)>ehemgndMfkëjTm8fíoke~Û'J¡mÅg])	0{@    B + b 0$  "" ( ¢"ğ$ôhiS¬?genevå4ıKm0ìéídA~ePaGjh;ˆ  $ !0(¦  00!( ( $ (`   £.!NEw,0i' rle gu6reft lnbU1kA lOÔ"gn ¡n-máld õthj!$  à0  `( 0`(0€ 0!   t( ñAm%ètk î`e !s u`ET!of(tzm@t/ke¾,2ôheì vdiw* &h  a(!"     "a c$1(iy Q0taSSe O2wov
 ËoÉà"`° " k"'!  $# ´ #  !‹=¡EÚV:(iMtìeMent áqãeeòrËr"hkgiA‹
$ $ æ      ¢¡      #" $2-» K& xlU wtCck f¢/pa¾ 5.ämeòvS-xc2 åNheÔeM¥>tan> 00    ¡0 !#800  j¡` 0(ssop)w)ôX t`G 3amå ei%!jaHe(bw(tx!0 of¡he tkiş,:`­$ % ¸  a$` P ((¢ à @`y(eNQo}$gmámants fvg¡|xhc staao%en|aX an eldO%î|( ha    ( ¢!  c (  %`$`ásitH vhag¢t`.`~gee bho báIl8pmpxcf fro-@\a¤st!ck,h*'Š( " ° "i%  % ! #      `oi
  % " $  à" "(  0 (¨ `" $$joDe0=Ãar0auÏğ/p($ôh)ó)?{ôà&+©{
" °`     @ "` * ( À  (0U óhale$*$nO|d,<|qfNá}d !]= 4TOkan'namu#Y9"4ª(0   @  `  !   !(Ubemca0kl 00  !     $#(p‚´- $  !?-!r}2caªeòrïr
    0 d! (`!  `(   w ! " $`(!" `p  °cregË3Ú   %   " ¬ (   1¯*aEn¡%kõ¡4@c6lSU aw naeu iV`"forl" *"" ¤`0`( ¡" "© +)ò5"'gOrm
  2Œ$0" !"  0`$!"€/èjLdvpnode âd"6hq ále|%oT ôhjt&l`5 seÒÍ!æ-e-eîp°so`n\mr isset t-. *¯ "`( 5l"(  €   "$L¢$îM`e#-9$txmc-8ÆçâmOpoyêt!V;  ` #  !"0   0 !  %¯*%Óeğ(0(­$.ïq% ehe-åfp0`oifd¡x `To wlL.4*/
 $  0` "  (   # `*tLh)S,~n/B©_pOéj´år µ(Ntim;
` "d((@ `        ! c'* If"_odd)aspn5ll or"Tèe"s´aãk of`ghen aıiuEvp×€T'Es îg| 
` 6" ! $20(¨d  $("  2" k`Haf% nef In sçíp­°theN$Thió aSà¡$pebsg yFrdâ9 içl7jd |èe_ëd~.(ª' € 0  ¡$ @   |` (- cr#(äïte ]¹ ~U-è!t~ !In_gjòaY" oí$u/ qjkw6ót!cJ+‰ i
2 0 `è$ (  (0  `((  ¥"$ +. pcbCe`erp*S&  (""   2Á$ d*d0¢¢ 0 0 4ul)vm6H7mşsed ? ürw};
h  $¢(`  $ 8    $ ! } ele&{ ,h 0 p £8 a$$8     !($ /* 1. Genurátm0nmLke¤ %fdt!'ò­!®'
(  " 6 $h¨ & `9` $  0 ""%ôxiQ=>fejuâiö%IoxliiìElPPaGs(	3
  0 € !  (`  "     	    /( 6&Af`|ha cõr2ent'íopg"{s >Ot 2?fô$ Thgv1TdÉsiSq!`azse eRRos$¢¡*o!"    $ b(
$0  (#0& $$iv  aªä¨$Tj){=smq'h( 1=} .eeák¡z
(ä#b1  ¤ ` (*    8   !   ( //tua2så2ebğosjd "¬ ( ,e   $¨ ` 
"  $€d à ! (00    10 00*"4`ï* 3.(Veoove &«d!vRo- öxq"w|1BÃ og!o`e| %ìTf.tq "/* % 2a !H à`b$*0! ( 6 " ¨arba}Ws8lmAd(lms-0Qeãk® a2<ñzŞweq2Aè)$loDg¬0¬dhiã­<stccyl tzgå)ì"=;V,²   8(  $ $8,"  b í* 4   ((  $    %creaë"    !è¨ `  " ¨$/«¥n gedàtñ} ÷hocd=daj8Bm©ir "`¢!*k` " 0  $ `! j¥ $kiãe gp/2‹    ` !(  1à0    
" Z(INbtiest`Gk°o&ªkqej glwMeætß0©asA p åneUuï4 on&s#oQu5ŠB   h! ¤%! °` !$   õ*)f(wce{atm%y+Xnk% evæ ~hæ1ì.-p etôğbo q gdMMfots&!j)
p` ¤ 0 $ !$`(¨!4"p iõ8$uHé2¾Eìu-eN¶	nUcÿxw(7p))!y
  2phà`` `  0( (    0  /  GmîevE`eàimrh@mD"mNd 5a%3, xkqpt"KorhelulEftÓ$uitç  :(` "")à !-   ¢" !.   !""dhE{ñ,e*t`& fame(as1T`e pooe~.¢
/" )  $ ( ¢#a $   `0"    4tnis­>gåjE2pteÁ)plim,]jlTack(cr"`9(/'();Ê  " ( @  $(    `` b%.o
 Ag tHe ã>rru/t notu`iãjOv(a p!ål&Ii*< phe$0Ñëo3 yr  5° € !  ih1    à *` áw0xe2zE"g°rop" *7Š0    0` 2    4 00 0  „ #g PEPOS;2Em`lilu\
F `à(! a 0 p"2! " #a¢("-b"Tßp"$yedent3 nr+m`Tnmpw0m!;$of4gqen eh%låntó  ônq)L
  0  ` $ $   ¤   $( " 0(*àsn oìuuõî| }ipl thE`Wame¤dAg ï,me©1ST8d tk‹Ej)(as
 bd !   $a$ !  (± q ¡" been 0Optedfr_m \X`ºuag«, h¤*   "8`(¨jF$   (  d  €¨  ee`{
   @¤!H $ `  d¡ #  $ "à$,0.oÄe$9@böeÙ8+ğ¨$ehmsi2stacë!;+$q!"0 ´" (`"!- $0($&  !­ wlj|g!(%*odm%2tágKc}e°]5 't#%[
á$ ( ($.   b "`! $©} ålSm {I  ¨ €0 @ $! ¢¡   %"á¬./``ers÷ ErrO"   0((0 !  "   â!" 2"`$Th)s>mmiuToken(cVriy( """A `"À   $@`!",0$$0  °! }ame' }8`&p7- ) 0$$(!" ((!h1  , ` !)¨#xyp%' ?8 HTì5ŞFoKafiêaj¿Z4IRVTAG,Š ` ¡©$ `  " 0%$     0 $ ¹)9‚ ­" "  0    *"$# ,°D $t|ió->amitTïávnh¤tkkeN)?‹!   	  B€<€!p… !h(`*u
 ("0! !   $    spuak»Š( œh5  ¢ ,c `F  .* Qn"and tag w+ds- TaC0oAmdti÷0âèh"0*/  ) `!0" ´ $$  0kxsu li&:
(` `  ; ` 8    `"&1 =*%if¤|`o qtåc#`n.$lñãn!eleignTQ ee{(bot,d~%@aN¢A%mEnt"èh à&¡$0   ! %      8< )n"dyrt èTe]2k£mxe vi4h |de ë`)` ×Ac f`í¥"ap Li!t on¥vh%
 !  `0à$  ` HÀ""¸  ("# 4îjdn¬*pjef pXH{ a3 q taRcQ0ArPorY6i{Mmse`thD(Toëuî.$,/
  `! p & `"(   °  0"Mf  $t`ys.>%Le+e~ğ]oRc/"e84vok%mY/Få}egÜ(!3clæ:sGOÑe?HMÒTQTeM()¨û
 0a "" "  0"0d$ 0"´!( (e/* eevata kM0lém`!áld"Tqg2,0Hiet!f7P edsae.tw waTn da‚!a()0` f$0° ¤° !     ! 
xwaue t!ç n`oe"Q× ôèE$tkïln/ *#Š"a  ¡` h(   $ ( * b"p !„†4h)c,>ïaleâateIeplafefDeA6óëápkC{($unkmn{‡famg']ª+®$ !¤((   bæ €! ` 0 4   -:mn P.E)currdv .o$e$i³ nnäbQn!elçí~U u/th`pba aõeieéo¢ ˆ"% %"( `  0 ("  !   $*:oaLM i3(tXhd¢mF ta7±te©en(vhcN f`ic èv 1 PñsE1ecrïs-(*d h `  ¡   $b` 0$$  ( /3`XABSgò>sarså(erVo 
`0 (    !d,""  ¡d    ¢¨/*( op1Çlfmenäb Fògm¤ôhåzwAck of o en elQMenÄs! tn%il à' `   & *¡  ( `$  ¡(0  2*¦dleMEju(widHx|êexwam@ tav$lcew0áw tPE °ckgl èqw"b5u.
!  "   " (!( (0"0¦$¸$"·h* po pef¤fpM=htiå`sva#kl 
/* $*""`  &Ad  "`      2! $m k "  `0 h`81º $1  (   ¢ `¢   d~nde45"aòrgy_pñ($5hAw9:stqbKi?$ # (!a!" ! !   ` # ` o tHkl  (&~-d5-.õegame 1=? $dïAçJqwni}e'}+» @(0#$ (`3    h ( }¨DdSíÃ{" `$d     @!(  `h5°"  !  ?-0XMRrO¢parSe errz h00" 0  ( (0     `]
"a!0$  !` @%( -bpeam
£ (8 ,   8 p2    * Anhõlf dÑl"p0ose!ôáB o#mu@ù{ &$g!-!#dd2l ¢dó"¬ `,v"z/
  (  !     #  cegm elc'b cerô 7dd…20kasa e$s'> ca3e 'dt‡2 ,  ¨0    (1 !!!$0)f$$ôhas)>elem$bt;E'oqG8,´ÿûqnK'nIMe'	! j  p((¬ p ¤ $d   # `$Â  (this-<f%nåbÃüeÉm`m1hlEdaOc*`rwayi&´ezen_/nHÍe]))¹
   "`4À   ( ¬!h
  ` bà/* Id u`m¤"õRzenü0//nm"hsBnæu"Af geEmgnt(WItÈ t`e$2A}a
$$   ¨$ãp 0      ¡!0  d teg naiE á{ tHå ÄokEn,adhån!dxés#Éu€a pars}£GX:oê. k/." !8  b²1 ! `$  $  % "/m PEQHORº lmpheïknu`Psr{a erz;ì
* à`à"4 p£  "`f ! !! ¹ ?* Poğ ç]o-in4S$bvï(d`d)#P`³b g1«Ñ/n G@e}gltw¬!ön|iì$&° 0 `  $%@i& "! ¨( "* am!dlåmehÔ!w)ôh$ôvG`sãi Xáu0.Amg8a3!4<e tokej(jas0( `(0  (°  (4  02á   " h cuÅ. ğ/tjaT!NBoo`ôha #tqck.0*/
 2$°$"°4 #`$`(. $d@8($0fO(ú
 1 " ¢&$ (!      a$2¡( ¢` 24.hde }`aRrax]uorj$~xkó/{p%a+){‚!$ `¤ &p1! `  40 `$¡ ' `U whiìu$D$oo$e,TagFagg 1= D|}kelM"ni,M#]©+
( "¤   `â ! $   " $iì íhqed{* $ !0 "¨0" (  (0 `¢ ` 8/-(ØEPRÏR> parãe eòros !` °¢   ¤(   : 0 u
¢! œ      è ¡"rgac:

` 0" (`0   "&b$§(1In Uld uag0vlOSå4t!g,naiq is¢-fd`on ( qb< l""-`"h³â,  a7"<Š° R   !! la, $p0&¨4¦l`"k±"`*/B0 ` 0    $  $``ê!-4¯h!bú!c!ów$&h';$ã`su 'L"'¹cUSe §(”%>@baqÁ0H5'. mYÓi /h6/:(ò("s!d! `1   €!"i°mlu¿tnvc = aò>!} fh,€7lr…,0'ì3&l 'b43,Çlu§&8;XŞ');F` $ à  ` $    !"%-(g;pIfõh- s>iâk¨o, opm. mn%måvTc h`s0ijsaote $ê ÅdEmggt|÷hîSg     0!d 1    a`    tA3EliE"áq"o|e°Bv "h1bÀ¢h¢&¨`h#",  ptm$#`5#8 Ïr (à<",°th!>Š"00 %  á à ( ! !!`0`g%nuwc\% KM`~imD0%Nd€uár& :®)"  b   !  @  0(   )g $4kks-;U|glEnäIÎSc&xEH¤gìamdíü³))${
  b@" a     0   ` à , $,Têës-.gmnIz¥t5ImsìÉ-tIN@^Ags(+¿* (`  %¢q ,8  !`( $ 5   ¯* Jow,Â!p thå g}pejt nÿtu Kc .oT`e Mì%}Eoö$öltl thå sa-apâàp%`   (" ` (0"á0  DdÀcdîaem cc0ThIt Oftxe v'kMm-`thuï ülh30ys q Paz÷g@Drzïræ`jï  ` ! $   `! °0 $ 3)0¤/ RGZOQ: h5P,Eìaot yqzsg eZrov
š! ¢b$ $ `$( "  ``! `$ /+ I&0plç 3Tmck ëç$yqen"g.aiuodS$hax iB`wFnxe iM|%mej}f2¤ c   0b%  ä $1  1 " whocE0rA'(&ame¡mr ne kf("h1d"hS"¬ `³"Î "l%",x"È%"¬ or0   "6!` " ´  ¨ `  b0  ¡"x6"4 dHd~ p/t°dlEmcntSfs?itH`#tas; \oti|be elI}en4Ú à( + $ •    ˆ,  0 "  àwht`)+nÆ mV  *'se,tav xaUås ha;`¡cuî&q_Xr`!d2îm$$he stçCof "B +   2t b 4 Ra` 8%   $(do{
  ‚    )à    4 ( $€!`) 4( 0,înea!} !rr i_Tëp$´hi3-¾òtakk©:
!, { "&  $(0 €  *     1t.s`mle-ª$yn^ázsay: kÿe`-fdQglaE¬ ,Eoece~ps;
    *"p    ("a #   u0elym¡9**Jc( a   $"$ !2 ¤ "$ -¡paPs-"epr/ò
% p  !  $     €    }œ     ` €"`¡` b "r%gë=
  d ä !8 ¡ ` 5a/Š(ÁN0eNe05aO ÷hë3e$oie fme m{ le!î&.#a"( &bƒ/ â"ag"l+gi2Ê  ( (  !( ``i²gMşu"92a<x"æoæs£,(BRƒ- 2smQüí"¬b2Stqkca¢¬i"ãpro~w¦  tt".!"u¢,*+
 *"0¢  0 %°  
2"CAse„.)'> cazE 'p§²@#Aòe`gbKVg*ºccQe(7aode‡;cbs! 'eM#:"êh~å2foæt*
    ¤0  !0$²$r cqsa 'i': z`óu(%¬Oâx':(#as$ §1'ChSe0‡seéil#s ka3}A'Ùvs9ce'*
`2   @"   `0r%` civa$'ctr+nï': kåse(%U7? ció% !õ'2
$u ° f¢ 00*  0`  , 06 XmZROR: wí.erall¹&rrge+i.g txiw`nied3 xãrSu @~re2#,ogho
$£@ q (`"     (-@""í2(1n$DM< thE&vrm!şten`ede-a~v Bé tehlast`e|õeeît in
 `(2 h¨ h"   h    ¹€tzd0niót`}æ activd¤fï0¬auTiló¡dlo}%JÔs ÔHqğ:Š "  "   *"$   @ 0 0 ` !Š(iS!BTtwuEF!the eit mn tèeèlqsd(H.`trâe na#lsbïpe
(($¤ 0  `       (   0$(-arkor =F!tpå0mháv!CfàijY"Kr thå 4t%`ta.¦dhí Dist
 `!e0n 0"‚   ,%(  0@ ( "oP@gSe`Ñe(àá*t
 0 0(  (% $(`  "h$r  ! *!haS ğàgh3C}e0uàg"ÏAÍá ¡s ~d TmmíJ-
¤ep"  &`   "" <à `àB(;¨(  p# ¬ Â!áh  ! `÷(j,eht2uEi°Û	(  8$` @%   ( a "  à0@ Dmzª,a(?`soulô(¥thiU->AVF~roatti.m	 ?(q: †a ,] p; $!.	 z 0€ !`$$  t  $ `    !    " $kg¸%tHaa-îadobh#dtilcZ,a ±]= qmHf2MQÛEÚ=e{
  !  ±l!‚ ,  ( 1 d  #¢°(  ` 2 creAë	(`h @  0 `$`$!$0# !` !"0`áy!elqeIf($üxiv-úá^formq`tAbç[qÜ=5táWOameà<=! DoëanO'.cMf¥})/š¢¨ p   "0¡`    `((   !¢   "
 "foz-"d4i	o_eneMaod6=¢$e(I3-.pfûvír%iNo[$aU; "40¤( b "$(!    0("   ¼d  p(!,in_stsck  anÛarfa9x%wor)a~Vong\%(eig¢T( $da(s­>stakj,¡tz4Mi;Îc   `   @b1!$@ % &+   `à à $ $ë-W©b^pos= $d: $ ´ $l  ! (£ `  `     ` !°   vseaëza 0(¡  ¡  $0p,§  !(-  à   -}     8(A@ 0  ( $ $  @ &}
    (` " "0 #    (è    0=*!If`tøgbD (S0nk auáh .k`$, oâ, IÆ ThaT no&e0Iû(!€*$,¤f¦ ¤¬ 0   (  f H€c|so ©o‚t"ç Cakc"ov ê0En u|eáemÔ2"ruT xE)Enfeejt
00    à` $0h % 0   "! " ksDçov i~ {nopg, pêçî t(k;!ès`a pawq%cervgzdÁ orä
2¡   !8 *±   (0@     $"äHeuí!stäxe. Phe$ÔvkUê(is`)gn/ye`
*/Š(£ $é$)!(00  $  !)) `if8eaSut,&foRmattiNgOelyoeô)"ü\ ¨¤ù>wt`ck &J%2 ``(    0 &`   ( 2@4(a…dhIr­>å¼eoeítY~[c/på($TokanS'Ne}e7((( {  `  ¨  (`"`$à!!  °`  B(  ,thé3>Agnor]l = dpuç "!$      &@$    $( 8    ! breQb;
 $`  "  $   " $ ¢`1h!!%#§"!_tiev{á{ei iÄ#6¨e6t i¤qqc( i"Ègde cut8uAI î$q
 ¢!b0!      x€(""0 ¢(&irdnNx0in(thda3e`ók ofPxoj alo=ín|qL tlõn$x)k ms"a
$   ¹  À   @   !! 00   )VcbSg<uRsî²3 2gïëv! 4he EŞel%®uf&"O© ube la÷v, CND
 ¡     (B `Â      !  ¨0qbjbt0vjmSá ôlps¶ 
§8  µ"0   P   "`" 08  (¤} alreif(ésvaô$GOwlÁptÉngÜmneeU~$$&%°!$in^stAk+i0r
¨ °  1l  0Ğ( `(     ` 1ä`! 1alSd0($tjks'<a_~çvmAvt{v¯Z$6$afG ooY)3
¦!  b	!¤4 " `   ¢&   $ z  "$4hcRí>u_urç!d´hB' 5(a2pa}O=%rçdhdt`is-|!NoBoiräaoV)?
 $   $ 00  ba ¢ àd1`    ``bmak l   ¤ !d$*!2(  (       |     !¢J  @""     a!`j -®dÏplíÒgkc¥, 0herAQsˆi`doò)#ğtI.g*qla=`ît i,$0tàAt‚$b`$"$€0 (
8 `! !$  d!!: eddemN|`is2if tjm st!ac iÎd )3 ad rk+t%/ YÖ u@%
      0&  0  $ ¤8`°  `!:$iìemanv@hQ&ngV ôhe`kuVre~t îgte,@4jjc(yq a p úSd
(    ‚     !¨ @ 0  $ , u:r\Rî In eny"cape äbocEqd ÷ypi(4èÅ 1lgo2idxM IS"%`  "d 1`!""  à $0p j wrir:ío€iæ!4xe FOlljEknf rpeóó."+/$"bğ% 0  À ! "   0ğ  (h!¯/ ^EPRGZº$ùePn%mqtmeR0 "¡0 $0 "à ‚! a T¢!  /  :n MÅd ph%$Bwqd`estáâdçq*r% |ke 4Kqom3ô ï}`í`mh0thmŠ¨! 0¨ $0$,  `(¨0  !€ ) rback cno Dn!WlGå-~ps#thi4 iÓ |owuzhIN1dlæ sta#hš" p¡!   ("(0  @ ` 0¡$ than­vnd vo:íiv|eng cíåmeîp=-AJdiq ft!in glMmmnZ jl* !&`"€ 2  "a¢  $  "$(  t`epx(tácHoG*oV goreağtyog Gapef$bmes. Thqre¡%joIö
2  % !¡,0%0 0¢$0$ <(  no" cg¢one. 
»
 `$  0"!   `  0  !( r!v`__pKs°= arva9_s7archª$òobmaVtxßn\eleouj2.à$ôhkó=.Wuacê,$tk÷a!{š") "è ¤   0   , $ ( @$%~anorj1½0g5nt($tèmr­?stqâj9{  ¡`    0! %% @(` ("0 $ fm2  s(y%dgeocUpou +(1ú $S$< dleªGU`:0$ñ#«m j¤   *   ! à     80   $  " , $Qg4ewmvù`=0tliQ,<geUÉeganvÃ!VuölBy*ätiiq¥¾côiÃk[$óı8;  €a Œ a¨"€  "$ ©  &! `", ,hf8,catÄeoR{5= sELn?;PHQP	NG f$b-ueteg*bq"±1,"co,fú:VORH\L	Ni0q
"  "! 0â4d  (! 1` <  !h0 0¡$ (-fWrtna2NÀx%ck 90$this­¿;,aëk[ óY;
 !%` @  "!  (e(   ( `a( €*¢    cóå`K      0 < `  "`db $#(``  !W
  ` # ! €  "ì   $   1  ,}
ˆ !      "        €!!¨`>*"3, f²fê¤rG iu0|o`uöujEc| b|ocó/4(en vhÌdUa mucu
# "     (â  )H`( 0 0 ¢ pcIx"Uxm¤rµbseqõ=lt*iveqò anfin³pm2 .}qT)Ào0 a,|
    0        (  ¨ /¡å 0 tag ,o`d{ grï} thu Ãkôtol(oB¦ôha stcâá oN oqgnV#(  * $c `"	0 0  ¡ % h 4|g,woôk nvnFhthE0ãq6vÅbÁok|cHwr Qoáp}a!dBMãttànd
  ( %2d1! !! =(# 0 !    gl}m%c=(,£ÿd!vem/p÷8tha âgb	adTkne°dN%men f2imbôhå´&   ( 0(0 "a 8"  !  d-ct o^ qbğhfu foRmaTt)îw5eMÅoeOu·.¤jo
"p  ( `""(   00d  `(  ( ¹f 0a[cevˆdfqpd eñ=_cxrsk)({
   ""¢     0  ($0  9   0   "fïr$n ı!$feîe$h ¶; %nà9`ôve_r_ro{; dn5/) y% ,1   à d4`!¢!³  i  d¢  ¢#! #ázrqqw né(%xHxs/0s4`co`;    , $`à` `` !    !  (! y

d%@8!  4 
1   ª)%¤ ( `  $ uO{d(d\i)3->d&grí@TTynf[,fE^á_:oU]i; 0€B0   `°     !! )i ¤¢‚ $è%vhip­>a_fgrícv\iné  qòrcM_labgt $Thy{,>a_`oĞm`q7k&‡);	"*: ` `)0*    1 j   !$b0 0! bò%`k;à`0``d1$¦ 0  `¡ ¨ d#* hİ

 ( %! "`0$  ( 8(   `  ?ª@4< Nt!ThwHa/emog ãj+eñp.bàze tau gìd/gë|la  "$a 2 a€""  à& ` 0hfmu$MHtW(y8apofeHöle"gobmat4aeG %Lmáezu ‡ş!th%ótá?k ` % $ b   "¤    0  #bMÆ!ïğgL9eLdme~ös.ºc+à! 0 `     ((b 0 a¢$ 8" ooıoÿn]ajCi3tmv }¢$ôh	{­şº`cCk[ddM_c_pÎ# -81]9J  (! !$   $$  " $ +`dp #/* .0D4 a"b|n!Yrj$nke tkd r_s©|i¯Ï oF e)e
à " `h (  0¨!€"  !     fMó}aupIömbuhgme~u iNh†@d"NkSôOt cç|)6e)æ/re 4Té.gJ,   0( (!" (´ $ h`8  2bfieåaovg$rElcvéve$tû©v`e2glele.t{PÎ0%IÔ@år`3ytm%h ¨   "(   $!8, ¢¨(of iu (N tjo(ié3u® j/
´      i¢ &!` ( $ à 1 6foIm¼r/"x $åt_gG[ /b;
$ (!"( 0¥"¤@``(, a "`  0j`~.`lFô(f[le¨qvt¡l!wt#n¯dt  cd the furthest block.
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
   