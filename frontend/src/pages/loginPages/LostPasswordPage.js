import React from 'react'
import PropTypes from 'prop-types'
import { Title } from '../../components'
import InputGroup from './InputGroup.js'
import { Alert } from 'react-bootstrap';
import { backend_url } from '../../config'

const msgs = {
  'error': 'Uživatelský účet s těmito údaji v knihovně není. Zkontrolujte prosím správnost zadané e-mailové adresy.',
  'submittedSuccess': 'Na Váš email byly zaslány další informace.',
  // 'validate': 'E-mailová adresa není platná. Zkontrolujte ji, prosím, na překlepy',
}

class LostPasswordPage extends React.Component {

  constructor(props) {
    super(props);

    
    this.state = {
        submitted: false,
        email: '',
        alerts: [],
    };
    
  }
  handleChange = (e) => {
    this.setState({email: e.target.value})
  }
  handleSubmit = (e) => {
    e.preventDefault();
    
      // Empty alerts from last submit
      this.state.alerts = []
      
      // TODO validate e-mail and empty string

      // TODO validate e-mail
      fetch(`${backend_url}/login`, {
        method: 'post',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'email': this.state.email.trim.toLowerCase
        })
      })
      .then(res => res.json())
      .then(
        (result) => {
          this.setState({success: true})
        },
        /*
        * 404 / 403
        */
        (error) => {
          console.log(error)
          this.setState({
            errorrs : msgs.error
          });
        }
      )
      
        
        // TODO errors
        this.setState({
          alerts: [...this.state.alerts, {
            style: 'warning',
            message: msgs.error
          }]
        })

        this.setState({
          alerts: [...this.state.alerts, {
            style: 'success',
            message: msgs.submittedSuccess
          }]
        })

        // TODO re-render
  }
  render() {
    const form = <form onSubmit={this.handleSubmit}>
      <InputGroup name="email" type="email" label="E-mail uvedený při registraci" handler={this.handleChange} value={this.state.firstName} reguired />
      <input type="submit" className="btn btn-primary" value="Zaslat heslo" />
      </form>

    const successMsg = <p>{msgs.submittedSuccess}</p>
    

    return (
      <div className="login-page">
        <Title title={'Zapomenuté heslo | DKZP'} />

        <h2>Zapomenuté heslo</h2>
        <p>Pokud jste zapomněli své heslo, máte možnost si nechat vygenerovat nové zadáním údajů v následujícím formuláři. Nové heslo Vám bude zasláno na mail, který jste uvedli při registraci. V naléhavých případech, kdy tento postup nebude fungovat, pište administrátorovi knihovny na adresu <a href="mailto:knihovna@mathilda.cz">knihovna@mathilda.cz</a>.</p>
        
        {this.state.alerts.map(alert => (
          <Alert bsStyle={alert.style}>
            {alert.message}
          </Alert> 
        ))}
        
        {this.state.submitted ? successMsg : form}
      </div>
    )
  }
}

export default(LostPasswordPage)
