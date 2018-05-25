import React from 'react'
import PropTypes from 'prop-types'
import { Title } from '../../components'
import InputGroup from './InputGroup.js'

const msgs = {
  'error': 'Uživatelský účet s těmito údaji v knihovně není. Zkontrolujte prosím správnost zadané e-mailové adresy.',
  'success': 'Na Váš email byly zaslány další informace.',
  // 'validate': 'E-mailová adresa není platná. Zkontrolujte ji, prosím, na překlepy',
}

class RegistrationPage extends React.Component {

  constructor(props) {
    super(props);
    
    this.state = {
        success: false,
        firstName: '',
        lastName: '',
        handicap: '',
        email: '',
        password: '',
        password2: '',
    };
  }
  handleChange = (e) => {
    const object = {}
    object[e.target.id] = e.target.value
    this.setState(object)
}
handleSubmit = (e) => {
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
        <InputGroup name="firstName" type="text" label="Jméno" handler={this.handleChange} value={this.state.firstName} />
        <InputGroup name="lastName" type="text" label="Příjmení" handler={this.handleChange} value={this.state.lastName} />
        <InputGroup name="email" type="email" label="E-mail" handler={this.handleChange} value={this.state.email} />
        <InputGroup name="password" type="password" label="Heslo" handler={this.handleChange} value={this.state.password} />
        <InputGroup name="password2" type="password" label="Heslo znovu pro kontrolu" handler={this.handleChange} value={this.state.password2} />
        <InputGroup name="handicap" type="textarea" label="Stupeň zrakového postižení" handler={this.handleChange} value={this.state.handicap} />
        <input type="submit" className="btn btn-primary" value="Zaregistrovat se do knihovny" />
      </form>

    const successMsg = <p>{msgs.success}</p>
    console.log(this.state)
    return (
      <div className="login-page">
        <Title title={'Zapomenuté heslo | DKZP'} />

        <h2>Registrace do knihovního systému</h2>
        <p>Pro úspěch registrace musíte zadat funkční e-mailovou adresu, na kterou Vám přijde ověřovací e-mail. Bez potrvrzení ověřovacího e-mailu nebude možné registraci dokončit.</p>
        
        {this.state.errors ? <p>{this.state.errors}</p> : null }
        
        {this.state.success ? successMsg : form}

      </div>
    )
  }
}

export default(RegistrationPage)
