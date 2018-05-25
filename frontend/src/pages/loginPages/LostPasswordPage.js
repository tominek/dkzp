import React from 'react'
import PropTypes from 'prop-types'
import { Title } from '../../components'
import InputGroup from './InputGroup.js'

class LostPasswordPage extends React.Component {

  constructor(props) {
    super(props);
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);

    this.msgs = {
        'error': 'Uživatelský účet s těmito údaji v knihovně není. Zkontrolujte prosím správnost zadané e-mailové adresy.',
        'success': 'Na Váš email byly zaslány další informace.',
        // 'validate': 'E-mailová adresa není platná. Zkontrolujte ji, prosím, na překlepy',
    }
    this.state = {
        success: false,
        email: ''
    };

    
  }
  handleChange(e){
    this.setState({email: e.target.value.toLowerCase()})
}
handleSubmit(e){
    e.preventDefault();
    
      // TODO validate e-mail
      // TODO backend magic here
      let a = true
      
      if (a){
        console.log('A name was submitted: ' + this.state.email)
        this.setState({success: true})
      } else {
          // TODO errors
        this.state.errorrs = this.msgs.error
      }
  }
  render() {
    const form = <form onSubmit={this.handleSubmit}>
      <InputGroup name="email" type="email" label="E-mail uvedený při registraci" handler={this.handleChange} value={this.state.firstName} />
      <input type="submit" className="btn btn-primary" value="Zaslat heslo" />
      </form>

    const successMsg = <p>{this.msgs.success}</p>
    console.log(this.state)
    return (
      <div className="login-page">
        <Title title={'Zapomenuté heslo | DKZP'} />

        <h2>Zapomenuté heslo</h2>
        <p>Pokud jste zapomněli své heslo, máte možnost si nechat vygenerovat nové zadáním údajů v následujícím formuláři. Nové heslo Vám bude zasláno na mail, který jste uvedli při registraci. V naléhavých případech, kdy tento postup nebude fungovat, pište administrátorovi knihovny na adresu <a href="mailto:knihovna@mathilda.cz">knihovna@mathilda.cz</a>.</p>
        
        {this.state.errors ? <p>{this.state.errors}</p> : null }
        
        {this.state.success ? successMsg : form}

      </div>
    )
  }
}

export default(LostPasswordPage)
