import React from 'react'
import PropTypes from 'prop-types'
import { Title } from '../../components'
import InputGroup from './InputGroup.js'
import { Alert } from 'react-bootstrap';
import { backend_url } from '../../config'

const msgs = {
  'duplicateEmail': 'Uživatelský účet s tímto e-mailem již v knihovně máme. Zvolte si, prosím, jiný e-mail. Pokud se nemůžete přihlásit, zkuste obnovit heslo.',
  'generalError': 'Registraci se nepodařilo dokončit',
  'submittedSuccess': 'Na Váš email byly zaslány další instrukce.',
}

class RegistrationPage extends React.Component {

  constructor(props) {
    super(props);
    
    this.state = {
        submitted: false,
        firstName: '',
        lastName: '',
        handicap: '',
        email: '',
        password: '',
        password2: '',
        alerts: [],
    };
  }
  handleChange = (e) => {
    const object = {}
    object[e.target.id] = e.target.value
    this.setState(object)
}
  handleSubmit = (e) => {
    e.preventDefault();

    // Empty alerts from last submit
    this.state.alerts = []
    
      // TODO validate e-mail
      // TODO validate same psws
      // TODO backend magic here
      fetch(`${backend_url}/register`, {
        method: 'post',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          firstname: this.state.firstName.trim(),
          lastname: this.state.lastName.trim(),
          username: this.state.email.trim(),
          password: this.state.password.trim(),
          handicap: this.state.handicap.trim(),
        })
      })
      .then(
        (response) => {
          if (response.ok) {
            this.setState({
              alerts: [...this.state.alerts, {
                style: 'danger',
                message: msgs.submittedSuccess
              }]
            })
          } else if (response.status === 409) {
            throw new Error(msgs.duplicateEmail)
          } else {
            throw new Error(msgs.generalError)
          }
        },
        (error) => {
          throw new Error()
        }
      )
      // TODO better catching
      .catch(error => {
          this.setState({
            alerts: [...this.state.alerts, {
              style: 'danger',
              message: error
            }]
          })
        }
      )
  }
  render() {
    const form = <form onSubmit={this.handleSubmit}>
        <InputGroup name="firstName" type="text" label="Jméno" handler={this.handleChange} value={this.state.firstName} reguired />
        <InputGroup name="lastName" type="text" label="Příjmení" handler={this.handleChange} value={this.state.lastName} reguired />
        <InputGroup name="email" type="email" label="E-mail" handler={this.handleChange} value={this.state.email} reguired />
        <InputGroup name="password" type="password" label="Heslo" handler={this.handleChange} value={this.state.password}reguired  />
        <InputGroup name="password2" type="password" label="Heslo znovu pro kontrolu" handler={this.handleChange} value={this.state.password2} reguired />
        <InputGroup name="handicap" type="textarea" label="Stupeň zrakového postižení" handler={this.handleChange} value={this.state.handicap} reguired />
        <input type="submit" className="btn btn-primary" value="Zaregistrovat se do knihovny" />
      </form>

  
    return (
      <div className="login-page">
        <Title title={'Zapomenuté heslo | DKZP'} />

        <h1>Registrace do knihovního systému</h1>
        <p>Pro úspěch registrace musíte zadat funkční e-mailovou adresu, na kterou Vám přijde ověřovací e-mail. Bez potrvrzení ověřovacího e-mailu nebude možné registraci dokončit.</p>
        
        {this.state.alerts.map(alert => (
          <Alert bsStyle={alert.style}>
            {alert.message}
          </Alert> 
        ))}
        
        {form}

      </div>
    )
  }
}

export default(RegistrationPage)
