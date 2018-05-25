import React from 'react'
import moment from 'moment'
import { compose } from 'recompose'
import { connect } from 'react-redux'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../../components'
import './HelpPage.css'

const HelpPage = () => (
  <div className="help-page">
    <Title title={'Nápověda | DKZP'} />
    <h1>Nápověda</h1>
    <p>Vítejte v Digitální Knihovně Zrakově Postižených. Účelem této stručné nápovědy je seznámit Vás s ovládáním a strukturou knihovny. Nenajdete-li zde odpověď na Vaši otázku, nebojte se nás kontaktovat v sekci Kontakty na správce – rádi Vám pomůžeme.</p>
    <h2>Struktura knihovny</h2>
    <p>Aplikace knihovna se skládá z menu a obsahové části. Po kliknutí na položku v menu se změní obsah v obsahové části, podle právě aktivované položky. Některé stránky mohou mít v obsahové části další položky, po jejichž aktivaci se obsah dále změní – v takovém případě najdete na konci obsahové části vždy odkaz pro návrat do předchozí nabídky.</p>
    <p>Před položkami menu je odkaz pro přeskočení položek, v případě, že využíváte virtuální kurzor. V případě, že Vám tato položka bude překážet, lze ji deaktivovat v nastavení uživatelského rozhraní v sekci uživatel.</p>
    <div className="help-pag__sections">
      <section>
        <h2>Přehled položek menu</h2>

        <h3>Úvod</h3>
        <p>Úvod je položka, na kterou se dostanete pro přihlášení do knihovny. Zároveň zde budou vypsány novinky týkající se systému knihovny.</p>

        <h3>Uživatel</h3>
        <p>Vaše první kroky by měly směřovat do této sekce. Zde máte možnost změnit si veškeré informace, týkající se Vašeho profilu. V příslušných sekcích máte možnost změnit si Váš email a heslo Při změně hesla platí stejná pravidla jako při registraci, tedy heslo musí být minimálně šest znaků dlouhé. Opět platí i to, že hesla se ukládají v šifrované podobě, tudíž je není možné zpětně zobrazit. Zadávejte proto své nové heslo s rozmyslem, zvláště pak dejte pozor na klávesy typu CapsLock. Z bezpečnostních důvodů je při změně hesla vyžadováno i heslo současné.</p>
        <p>Další položkou v sekci Uživatel je „nastavení uživatelského rozhraní“. Zde si můžete přispůsobit jak bude knihovna vypadat. Více informací naleznete v části nápovědy „Vizuální podoba knihovny“.</p>

        <h3>Seznam oblíbených knih</h3>
        <p>Zde naleznete výpis knih, které se nacházejí ve Vašem seznamu oblíbených položek.</p>

        <h3>Nové knihy</h3>
        <p>Zde naleznete výpis knih, které byly do systému vloženy během posledních 30 dnů. V této sekci jsou knihy vždy řazeny podle data přidání, od nejnovější po nejstarší, nezávisle na Vašem uživatelském nastavení.</p>

        <h3>Kategorie</h3>
        <p>Zde naleznete výpis kategorií. Po kliknutí na název kategorie budou vypsány knihy v dané kategorii zařazené.</p>

        <h3>Autoři</h3>
        <p>Zde naleznete výpis autorů knih. Nejprve musíte zvolit počáteční písmeno autora. Po tomto výběru budou vypsáni všichni autoři od daného jména. Po kliknutí na autora budou vypsány jeho knihy.</p>

        <h3>Vyhledávání</h3>
        <p>V této sekci je vyhledávač knih v databázi. Můžete zadat celý název nebo jen jeho část, ale hledaný řetězec musí být nejméně čtyři znaky dlouhý. Vyhledávač vyhledává v názvech nebo v anotacích. Pokud nenajdete očekávaný výsledek, zkuste zadat frázi v jiném tvaru.</p>

        <h3>Kontakty na správce</h3>
        <p>V této sekci je umístěn kontaktní formulář. Pokud něco postrádáte nebo pokud Vám naopak něco komplikuje práci, dejte nám o tom prosím vědět, ať můžeme tyto nedostatky odstranit.</p>

      </section>
      <section>
        <h2>Ovládání</h2>
        <p>Ovládání knihovny je velmi jednoduché. Následující instrukce pro stahování jsou pro všechny seznamy stejné.</p>
        <p>V žádném seznamu nedojde k vypsání všech knih najednou. Seznam je postupně rozstránkován po určitém počtu položek. Na další stránku seznamu se dostanete odkazem „Následující“, umístěným nad a pod seznamem. Na stránku předešlou naopak odkazem „Předchozí“. Zároveň je u těchto odkazů vypsáno, jakou část z celého seznamu aktuální stránka zobrazuje.</p>
        <p>Pokud chcete vidět detaily knihy (datum přidání, anotaci), použijte odkaz „anotace“, který je uveden u každé knihy. Tento odkaz zobrazí nové okno prohlížeče s detaily knihy, které zavřete odkazem na konci obsahu nebo kliknutím myši.</p>
        <p>Chcete-li stáhnout jen jednu knihu, doporučujeme použít odkaz „Stáhnout knihu“ v detailech knihy. Pokud chcete stáhnout více knih, je pohodlnější použít zaškrtávací políčka formuláře, která jsou vždy umístěna na konci řádku s knihou. Zakšrtněte (mezerníkem) políčka u knih, které chcete stáhnout. Po dokončení výběru potvďte stažení označených položek tlačítkem „Stáhnout označené“ na konci stránky. Váš prohlížeč stáhne ZIP archív, kde budou obsaženy všechny Vámi zaškrtnuté knihy. Poznámka: z technických důvodů jsou názvy knih v archivu zapsány bez diakritiky. Samotný text knih je ale již v pořádku.</p>
      </section>
      <section>
        <h2>Vizuální podoba knihovny</h2>
        <p>V sekci Uživatel v podsekci nastavení uživatelského rozhraní si můžete upravit podobu tabulek, ve kterých jsou knihy vypisovány i podobu samotného systému. Tato nastavení jsou Vaše osobní a budou automaticky aplikována při každém dalším přihlášení. Pro přehlednost je nastavení rozděleno do tří bloků.</p>

        <h3>Individuální nastavení rozhraní</h3>
        <p>Zde máte možnost nastavit si zobrazování podle svých potřeb. Máte možnost ovlivnit počet výpisů na stránce – vypisovat lze po 25,50,75 a 100 položkách. V případě většího množství položek se zobrazí na začátku a na konci tabulky s knihami textový posuvník pro procházení stránek.</p>
        <p>Další možností je nastavení řazení knih v seznamech. Standardně jsou řazeny abecedně, je možné přepnout na řazení podle data a podle počtu stažení (oblíbenosti).</p>
        <p>Další možností je umístění položky odhlásit se. Můžete jí zobrazit na začátku či na konci menu.</p>
        <p>Zde si můžete zvolit, jakou formou má systém informovat o provedených akcích (zákaz, neúspěch, úspěch provedené činnosti). Na výběr je zobrazování na začátku stránky, na začátku obsahové části a v javascriptovém vyskakovacím okénku. Volba tohoto oddílu je cílená na uživatele s částečnou zrakovou vadou, kteří si zde mohou vybrat ze 4 vizuálních podob knihovny.</p>
        <p>Jste-li častými návštěvníky, můžete zde zvolit, jak dlouhou dobu se čerstvě přidané knihy považují za nové, tedy jak staré knihy se zobrazují v sekci nové knihy.</p>

        <h3>Položky menu</h3>
        <p>Protože ne všechny možnosti knihovny využijete, můžete si zde vypnout zobrazování některých položek v menu, jejichž přeskakování by Vás jen zdržovalo. Deaktivované položky si kdykoliv můžete zase zapnout. Některé položky jsou důležité pro běh systému – takové skrýt nelze.</p>

        <h3>Stahování</h3>
        <p>Zde si můžete deaktivoat některé sloupce ve výpisu knih.</p>
        <p>Volba zip archivu – zobrazí na konci řádku s knihou zaškrtávací políčko a pod tabulkou tlačítko stáhnout vše. Slouží pro hromadné stahování více knih ve formě zip archivu.</p>

        <h3>Další volby</h3>
        <p>Volba nahlásit knihu – zobrazí sloupec s odkazem Nahlásit. Po kliknutí na tento odkaz se odešle zpráva združení, že tato kniha je chybná. Můžete takto jednoduše upozornit na chybné zařazení, špatné kódování nebo neúplné údaje knihy.</p>
        <p>Volba anotace v řádku namísto pop-up okna – Můžete si zvolit, chcete-li vypisovat anotaci přímo do řádku, nebo do samostatného okna, které se zobrazí po aktivaci odkazu anotace. V tomto okně se také vypisují všechny další doplňující údaje knihy včetně odkazu pro jednotlivé stažení- můžete tak při volbě pop-up okna schovat ostatní sloupce.</p>
        <p>Volba odkaz na stažení – Vyhověli jsme uživatelským připomínkám a dali odkaz na jednotlivé stažení přímo do tabulky. Pokud Vám to nevyhovuje, můžete si ho zde deaktivovat.</p>
      </section>
      <section>
        <h2>Nejčastější problémy s knihovnou</h2>
        <h3>Zapomenuté heslo</h3>
        <p>Zapomenete-li heslo, lze ho obnovit na úvodní přihlašovací obrazovce.</p>

        <h3>Problémy s přihlašováním</h3>
        <p>Více informací o problémech s přihlášením do knihovny naleznete na přihlašovací stránce.</p>

        <h3>Nefunguje stahování</h3>
        <p>Setkáte-li se s problémem, že Vám nejde nějaká kniha stáhnout, zkuste prosím nejprve, vyskytuje-li se chyba jen u jedné knihy nebo u všech. Vyskytuje-li se pouze u jedné knihy, nahlašte knihu pomocí odkazu nahlásit v anotačním okénku.</p>
        <p>Jedná-li se o nefunkční stahování obecně, kontaktujte nás prosím pomocí formuláře v sekci Kontakty na správce. Do svého požadavku nezapomeňte uvést kdy jste si chyby poprvé všiml, jakou verzi prohlížeče používáte, jaký operační systém je na Vašem počítači nainstalován a jaký používáte ScreenReader a v jaké verzi. Budeme Vás následně kontaktovat prostřednictvím e-mailu s vyřešením Vašeho problému.</p>
      </section>
      <section>
        <h3>Systém knihovny</h3>
        <p>Digitální knihovnu zrakově postižených provozuje <a href="http://www.mathilda.cz/" target="_blank">Mathilda</a>. Knihovní systém verze 3</p>
      </section>
    </div>
  </div>
)

export default(HelpPage)
