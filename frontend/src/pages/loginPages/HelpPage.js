import React from 'react'
import PropTypes from 'prop-types'
import { Title } from '../../components'

class HelpPage extends React.Component {
  render() {
    function Faq(props){
      return <div className="media">
        <div className="media-body">
          <h4 className="media-heading">{props.question}</h4>
          <p>{props.answer}</p>
        </div>
      </div>
    }
    return (
      <div className="login-page">
        <Title title={'Nápověda | DKZP'} />
        
        <h3>Potíže s přihlášením</h3>
        <p>Zde jsme pro Vás připravili seznam obvyklých problémů s přihlášením do knihovny:</p>
        
        <Faq question="Problém: Nedaří se mi přeregistrace" answer="Řešení: Zadáváte-li správné údaje a systém informuje o neexistenci této kombinace, pak přeregistrace proběhla správně a pokoušíte se o další (přeregistraci lze provést jen jednou). V takovém případě se zkuste normálně přihlásit." />
        
        <Faq question="Problém: Systém ukazuje následující chybu: Please submit this form again (security token has expired)." answer="Řešení: Zkuste se nejprve přihlásit jako návštěvník. Nebude-li Vám fungovat ani přihlášení jako návštěvník, pak nemáte povoleny cookies. Povolte v prohlížeči cookies." />

        <Faq question="Problém: Systém říká, že mé údaje nejsou platné" answer="Řešení: Pravděpodobně máte špatné přihlašovací jméno. Zkontrolujte, máte-li vypnutý CapsLock, zapnutý NumLock a správně rozmístěná písmena Z a Y na Vaší klávesnici." />

        // TODO odkaz na reset hesla
        <Faq 
        question="Problém: Systém říká, že zadané heslo není platné." 
        answer="Řešení: V takovém případě jste zadali nesprávné heslo. Zkuste zadat heslo znovu, zkontrolujte, máte-li vypnutý CapsLock, zapnutý NumLock a správně rozmístěná písmena Z a Y na Vaší klávesnici.V případě, že pokus opět skončí neúspěchem, nechte si zaslat nové heslo na email. <a href='' title='odkazem přejdete na formulář pro zaslání hesla'>formulář pro zaslání nového hesla</a>."
        />

        <Faq question="Problém: Systém říká, že má registrace nebyla schválena" answer="Řešení: Vzhledem k povaze textů v digitální knihovně je přístup umožněn pouze zrakově postiženým. Každou novou registraci proto musí posoudit pracovník občanského sdružení. O výsledku této procedury budete informování e-mailem. Máte-li pocit, že schvalování Vaší registrace trvá již příliš dlouho, kontaktujte občanské sdružení." />

        <Faq question="Problém: Systém říká, že můj účet byl deaktivován" answer="Řešení: Váš přístup do knihovny byl zakázán administrátorem. Pro vyřešení této situace kontaktujte občanské sdružení." />

        <hr size="1" />

        <p>Nenalezli jste zde co hledáte? Kontaktujte nás prosím ihned na <a href="mailto:knihovna@mathilda.cz?subject=Problém s přihlášením do knihovny&amp;body=Vaše jméno: Vaše přihlašovací jméno: Typ a verze internetového prohlížeče: Popis problému:">knihovna@mathilda.cz</a>.</p>
        
      </div>
    )
  }
}

export default(HelpPage)
