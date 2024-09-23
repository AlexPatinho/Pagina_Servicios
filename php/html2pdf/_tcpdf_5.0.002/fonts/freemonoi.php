 value state. */
                        $state = 'before attribute value';

                    } elseif($char === '>') {
                        /* U+003E GREATER-THAN SIGN (>)
                        Emit the current tag token. Switch to the data state. */
                        $this->emitToken($this->token);
                        $state = 'data';

                    } elseif('A' <= $char && $char <= 'Z') {
                        /* U+0041 LATIN CAPITAL LETTER A through to U+005A LATIN CAPITAL LETTER Z
                        Start a new attribute in the current tag token. Set that
                        attribute's name to the lowercase version of the current
                        input character (add 0x0020 to the character's code
                        point), and its value to the empty string. Switch to the
                        attribute name state. */
                        $this->token['attr'][] = array(
                            'name'  => strtolower($char),
                            'value' => ''
                        );

                        $state = 'attribute name';

                    } elseif($char === false) {
                        /* EOF
                        Parse error. Reconsume the EOF character in the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'expected-end-of-tag-but-got-eof'
                        ));

                        $this->stream->unget();
                        $state = 'data';

                    } else {
                        /* U+0022 QUOTATION MARK (")
                           U+0027 APOSTROPHE (')
                           U+003C LESS-THAN SIGN(<)
                        Parse error. Treat it as per the "anything else"
                        entry below. */
                        if($char === '"' || $char === "'" || $char === "<") {
                            $this->emitToken(array(
                                'type' => self::PARSEERROR,
                                'data' => 'invalid-character-after-attribute-name'
                            ));
                        }

                        /* Anything else
                        Start a new attribute in the current tag token. Set that attribute's
                        name to the current input character, and its value to the empty string.
                        Switch to the attribute name state. */
                        $this->token['attr'][] = array(
                            'name'  => $char,
                            'value' => ''
                        );

                        $state = 'attribute name';
                    }
                break;

                case 'before attribute value':
                    // Consume the next input character:
                    $char = $this->stream->char();

                    // this is an optimized conditional
                    if($char === "\t" || $char === "\n" || $char === "\x0c" || $char === ' ') {
                        /* U+0009 CHARACTER TABULATION
                        U+000A LINE FEED (LF)
                        U+000C FORM FEED (FF)
                        U+0020 SPACE
                        Stay in the before attribute value state. */
                        $state = 'before attribute value';

                    } elseif($char === '"') {
                        /* U+0022 QUOTATION MARK (")
                        Switch to the attribute value (double-quoted) state. */
                        $state = 'attribute value (double-quoted)';

                    } elseif($char === '&') {
                        /* U+0026 AMPERSAND (&)
                        Switch to the attribute value (unquoted) state and reconsume
                        this input character. */
                        $this->stream->unget();
                        $state = 'attribute value (unquoted)';

                    } elseif($char === '\'') {
                        /* U+0027 APOSTROPHE (')
                        Switch to the attribute value (single-quoted) state. */
                        $state = 'attribute value (single-quoted)';

                    } elseif($char === '>') {
                        /* U+003E GREATER-THAN SIGN (>)
                        Parse error. Emit the current tag token. Switch to the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'expected-attribute-value-but-got-right-bracket'
                        ));
                        $this->emitToken($this->token);
                        $state = 'data';

                    } elseif($char === false) {
                        /* EOF
                        Parse error. Reconsume the EOF character in the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'expected-attribute-value-but-got-eof'
                        ));
                        $this->stream->unget();
                        $state = 'data';

                    } else {
                        /* U+003D EQUALS SIGN (=)
                         * U+003C LESS-THAN SIGN (<)
                        Parse error. Treat it as per the "anything else" entry below. */
                        if($char === '=' || $char === '<') {
                            $this->emitToken(array(
                                'type' => self::PARSEERROR,
                                'data' => 'equals-in-unquoted-attribute-value'
                            ));
                        }

                        /* Anything else
                        Append the current input character to the current attribute's value.
                        Switch to the attribute value (unquoted) state. */
                        $last = count($this->token['attr']) - 1;
                        $this->token['attr'][$last]['value'] .= $char;

                        $state = 'attribute value (unquoted)';
                    }
                break;

                case 'attribute value (double-quoted)':
                    // Consume the next input character:
                    $char = $this->stream->char();

                    if($char === '"') {
                        /* U+0022 QUOTATION MARK (")
                        Switch to the after attribute value (quoted) state. */
                        $state = 'after attribute value (quoted)';

                    } elseif($char === '&') {
                        /* U+0026 AMPERSAND (&)
                        Switch to the character reference in attribute value
                        state, with the additional allowed character
                        being U+0022 QUOTATION MARK ("). */
                        $this->characterReferenceInAttributeValue('"');

                    } elseif($char === false) {
                        /* EOF
                        Parse error. Reconsume the EOF character in the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'eof-in-attribute-value-double-quote'
                        ));

                        $this->stream->unget();
                        $state = 'data';

                    } else {
                        /* Anything else
                        Append the current input character to the current attribute's value.
                        Stay in the attribute value (double-quoted) state. */
                        $chars = $this->stream->charsUntil('"&');

                        $last = count($this->token['attr']) - 1;
                        $this->token['attr'][$last]['value'] .= $char . $chars;

                        $state = 'attribute value (double-quoted)';
                    }
                break;

                case 'attribute value (single-quoted)':
                    // Consume the next input character:
                    $char = $this->stream->char();

                    if($char === "'") {
                        /* U+0022 QUOTATION MARK (')
                        Switch to the after attribute value state. */
                        $state = 'after attribute value (quoted)';

                    } elseif($char === '&') {
                        /* U+0026 AMPERSAND (&)
                        Switch to the entity in attribute value state. */
                        $this->characterReferenceInAttributeValue("'");

                    } elseif($char === false) {
                        /* EOF
                        Parse error. Reconsume the EOF character in the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'eof-in-attribute-value-single-quote'
                        ));

                        $this->stream->unget();
                        $state = 'data';

                    } else {
                        /* Anything else
                        Append the current input character to the current attribute's value.
                        Stay in the attribute value (single-quoted) state. */
                        $chars = $this->stream->charsUntil("'&");

                        $last = count($this->token['attr']) - 1;
                        $this->token['attr'][$last]['value'] .= $char . $chars;

                        $state = 'attribute value (single-quoted)';
                    }
                break;

                case 'attribute value (unquoted)':
                    // Consume the next input character:
                    $char = $this->stream->char();

                    if($char === "\t" || $char === "\n" || $char === "\x0c" || $char === ' ') {
                        /* U+0009 CHARACTER TABULATION
                        U+000A LINE FEED (LF)
                        U+000C FORM FEED (FF)
                        U+0020 SPACE
                        Switch to the before attribute name state. */
                        $state = 'before attribute name';

                    } elseif($char === '&') {
                        /* U+0026 AMPERSAND (&)
                        Switch to the entity in attribute value state, with the 
                        additional allowed character  being U+003E 
                        GREATER-THAN SIGN (>). */
                        $this->characterReferenceInAttributeValue('>');

                    } elseif($char === '>') {
                        /* U+003E GREATER-THAN SIGN (>)
                        Emit the current tag token. Switch to the data state. */
                        $this->emitToken($this->token);
                        $state = 'data';

                    } elseif ($char === false) {
                        /* EOF
                        Parse error. Reconsume the EOF character in the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'eof-in-attribute-value-no-quotes'
                        ));
                        $this->stream->unget();
                        $state = 'data';

                    } else {
                        /* U+0022 QUOTATION MARK (")
                           U+0027 APOSTROPHE (')
                           U+003C LESS-THAN SIGN (<)
                           U+003D EQUALS SIGN (=)
                        Parse error. Treat it as per the "anything else"
                        entry below. */
                        if($char === '"' || $char === "'" || $char === '=' || $char == '<') {
                            $this->emitToken(array(
                                'type' => self::PARSEERROR,
                                'data' => 'unexpected-character-in-unquoted-attribute-value'
                            ));
                        }

                        /* Anything else
                        Append the current input character to the current attribute's value.
                        Stay in the attribute value (unquoted) state. */
                        $chars = $this->stream->charsUntil("\t\n\x0c &>\"'=");

                        $last = count($this->token['attr']) - 1;
                        $this->token['attr'][$last]['value'] .= $char . $chars;

                        $state = 'attribute value (unquoted)';
                    }
                break;

                case 'after attribute value (quoted)':
                    /* Consume the next input character: */
                    $char = $this->stream->char();

                    if($char === "\t" || $char === "\n" || $char === "\x0c" || $char === ' ') {
                        /* U+0009 CHARACTER TABULATION
                           U+000A LINE FEED (LF)
                           U+000C FORM FEED (FF)
                           U+0020 SPACE
                        Switch to the before attribute name state. */
                        $state = 'before attribute name';

                    } elseif ($char === '/') {
                        /* U+002F SOLIDUS (/)
                        Switch to the self-closing start tag state. */
                        $state = 'self-closing start tag';

                    } elseif ($char === '>') {
                        /* U+003E GREATER-THAN SIGN (>)
                        Emit the current tag token. Switch to the data state. */
                        $this->emitToken($this->token);
                        $state = 'data';

                    } elseif ($char === false) {
                        /* EOF
                        Parse error. Reconsume the EOF character in the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'unexpected-EOF-after-attribute-value'
                        ));
                        $this->stream->unget();
                        $state = 'data';

                    } else {
                        /* Anything else
                        Parse error. Reconsume the character in the before attribute
                        name state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'unexpected-character-after-attribute-value'
                        ));
                        $this->stream->unget();
                        $state = 'before attribute name';
                    }
                break;

                case 'self-closing start tag':
                    /* Consume the next input character: */
                    $char = $this->stream->char();

                    if ($char === '>') {
                        /* U+003E GREATER-THAN SIGN (>)
                        Set the self-closing flag of the current tag token.
                        Emit the current tag token. Switch to the data state. */
                        // not sure if this is the name we want
                        $this->token['self-closing'] = true;
                        $this->emitToken($this->token);
                        $state = 'data';

                    } elseif ($char === false) {
                        /* EOF
                        Parse error. Reconsume the EOF character in the data state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'unexpected-eof-after-self-closing'
                        ));
                        $this->stream->unget();
                        $state = 'data';

                    } else {
                        /* Anything else
                        Parse error. Reconsume the character in the before attribute name state. */
                        $this->emitToken(array(
                            'type' => self::PARSEERROR,
                            'data' => 'unexpected-character-after-self-closing'
                        ));
                        $this->stream->unget();
                        $state = 'before attribute name';
                    }
                break;

                case 'bogus comment':4 † $0(  "¢ 00e  8!;$ Pi¿s #an gnly Ì!pq%l(ÎD t`4cOnteM|E+dgl0dlq' ip cıu24. pid(¯GCF¡aktst%.] #/J"`$! †0p™  k(b!$ !© /,†coÓscMamnlry cha:e+tev U» tn Ùhm f)rst†E"0EqZA	PARITHA.0[YGN
§(   ``íd‰ $  †  0gig“aauar x>i0mr ulg†˝n$.of pjl _ile$heOF9,¢gh`„Hevg‡„˜le6`fiˆc7.*el¡~ä(01† ((† # (     (0a(w/m}En¸$WoiÂN®hm‚•devA Is0Ùmm(coatd,‡tio~ Óf0qln*tbe cha˛asve3≥,!b  ! !a† ® ®®) ""03vcp|hdß4d7oˇ0`J`hiLNafhngpvhe aÍdwaktev phaT(c•Ured"thn`˜t3tÂ0`c(ineb † 8"      0†     ° t- [wetGË)i^to®tlAbboUÂÛ genAgnt StC4F= up°ug!ÒnDx)V£nttifg06(%$Ï!ft† " d0 2 80§& !! †{onssÌ%d∞Îl`sacpez$jeFÔÚ` 4hÂ2T 003U „jar„√tar, kb `my, oV Wp dk`t$e
" "    ! ,  0 (c ∞Evd Of t*e uimeÄeºuÚgÈ√Â> (Xf°ph% ck-eEn| gs StarDÂ$ b†ti% gNd(of
  †    a.  2 0    d+e &i|≈®`_F#,"&heòtocg  iP4aypvq)0*/
@  Çb    Ä  0 !$p †d0Aa3•>‰Oke.['dcÂq']2.º ∏c6ran&),§wiis¨=R$0/ai.chabs”nil,ß:'3‰$`(( Ä`!  p 2($† " •¸)is	st{m·e-?uh@“0iª` ) "6`0`¿ 0$&     ¨qha{/<emiTUoKe|,dwh(ÿ.ûTocÂÔ)+ÿ
 0 #  @ a  ∞ 0! !(0 .(&Swmrkx°dm thd dEÙa qtate?±*/  p j 1""¢$`$  $= 0 $ÛPa‘a = 'la|C-;!$ !` ® †  "   )Breik;™
#    ± H0 (  case0.m¡rfuy†lesLarAtion"opqn';" `a.( !  ‹‡ §`(¢""; Bon3u|g cor f`lOw   †!04!  " "4   $$h}p∏,N7* ,rË9;e&wˆxea->bh”uoV(hlÂ)g(&2)y*0ahp, 0   !†" 8` *$∞	b($|y1htn≤ ]ù? ')© {` •§0 $$`0 $¶b £"†` `0¢¸(yse:q|z%am-<}ogev(,?
 †$!$1‡ ( *   b h
"† A   "  `$  )4 (kv ($Ó}2ha:S†)59™'≠)#© {
¢° )" (∞ $†;``" ® ` $!†a/p·q(9 ~Ëi#-:rTRuwm=6gjdrs@i‰m8Kdl.:2ANYHA,≥v);X"p®Ú  §      °   
}ö+°0 b $!A    @` `$‚¨8* Yfx\lgnDxt†4w„#ghaRectD2s$er!bgtË(E∞v2D @YP»EJ-≈iNTS *-=
 †  $8§&!0!  2(   ahiÚqcpbw$!s/~cUm« tlosu†twO"clcS‡3gÈÙs< crakte ! comOent ˆken†W(/#e	 ††®l$    ! † %  `( ‰!ta(is$ThE"u·p¥y‡str˘jÁ$§ajl {wItkh t{ati$0cÔË'eÊÙ queve,Â*è , l" 0 $ (b" " " `È"($`Y0hMËs07= '=há) {
  Ä 8""c`$Ä!(1# !£" $0$È|ape(=cØmiEgv†sdrt&õö(¢%q2$r $ ≥` !p   †#   ftxis.>uOkeL$0Ûr”x},ä":   ‡`  ( Å(  $ @4    (° %dAV‡$0=Æ∞3w$
 00 †( a%!   d h£  $ †† !" %tpx7' ->sELe::AOGLDN‹
2b($ h°   $ $$ ° *°'2 k);ä
† 0¢"  h! ($`  (0 "†/ ≈4h-RwisE iW vhE!~ß:t‡sevmg0g-·Rabpasb(i2uB} G!wa-az≥E.rithRe Matk*°  †   †"!0  ® "$&dfor fLe ÔSL 2E_c]IPè"n vpe/!consUoe0uh/”‰ fË}Zcc5drp c.$$ps3fkF tn†TiÕ  4† 9  !  #† 0 % 4MOSE Qp)6q: "/D∞   "!" 4í$    5 ` !} wÃ{Mif(sp2t5X0et* ¶epjd9!5=<$'DOBTYR'ã ∫" !(" d2®≤ &4!  ¢ †"  (Ö{4·tq†- '∆GC@YX'=
* )0 " $0  ¨($` (` (+Æ†XPJ >ol)Ì`Hmm-\edj$`$(  †b01 ¢®0   0@/Æ _˛)Ìgi7e,¢iF!vË%†inªurt)/.2iÏlL∞ÈS "ik fmreiEConvEv6(8 0®" !  (000` ,$$ "ald xe¢au“fqF4·b/dud)s ooVCl a¨a-e"| in t(MrHTML,naoa˚pqKe™   0§0$ ( x `  08 e.Â!uhe Êe8t±{ev#h shaZiatep3"ahe`aÓbQBYM§"ase%sgosiuItm.  p ` `!( 1$P‡Å '"  m·Ùa, &OÚ$º8·Ä‚xring ™[ADATAK*`HTËE"fhvdÖpVeÚaa≥a¢lettıvs± !  !` ` d 8(5$Ä  †rCDEXA≥ 3h|Ë!a U+ 85B(lB(SYs RE¶bRA√Ee chArus `l‚eomre
0  `a0a    !@ "" Äa*daFpd6(Ï8the» yO~su}g$thSSe CHaÚÁc|ubj ant(s7idij0dg2he
 ( °†(¢°q2$¢h§ #  ! √T«!smctmCn ruate 8wDysjÄis enrU.afed0lj t A con4gltEmÔTed `  `p   "1`$ 0   `fhe#>} SDAVA b‘‡ta-.!(7$  ,° ! 4 ( !   ($xo´$Ovx$wgse/%È€(kˇ6q!rir{m†!2rÔv. wiDci*$o he bngu3`c+Me‡*Ù${4iwc.  a   0%(·@$†0  $$-7iU$nuxt!cayÚAbter`0liT I`!„Ønsql%@l(I&0Ily(2iw phl(fGssnaGH ractUzJ¢`&``°! 0≤( t$.0%!!Tha‰Ynd!b|in pjd"cgifLft.*è∞ §` !4   ("†" 0) #$}!5Ïye†{! "0 (   ¢    @  Éa¶   dÙi	s,.eÈx‰C˚gel(@Rr y)" ,! ,$% "0f $ 0b !( † " •typd¿æ$b$m&:˙P!B[ÖRB“,¢ (`   $  ! *01`42`0 ® !'eath(9z°%oucu%d≠fachMw=or-dÔcuytdJ ( §p" !0@†¨$(!©† (," ©Å""   †("  "$†   ($0†4!†`·thIc->‰Ok!n ] q6`a8aäd !(`!‡  ` $"   ‰  †∞ b° &3Ø·gd·'"<!(szIn'	1§a}Òha,
 ®!(   ≥  † d&  ‡(( &· Ë(`ßt}rmØ(=<!S%$g.>ˇOEEŒU   ! 0(0   2† $%" $0@0!$)?*(!68$"°!! †"$("` $ §  (udate85`'po◊5s bÓ=munv#æ
†$$ b"§0 ‡" °` 0   }b p§§(  0ÄÄ  *j2e·k{

6p$1·9 2 !   §`Seqe`ágom}•nT†sˆa"taz‡ *