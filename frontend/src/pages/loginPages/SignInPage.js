import React from 'react'
import PropTypes from 'prop-types'
import { Title } from '../../components'
import InputGroup from './InputGroup.js'
import { Alert } from 'react-bootstrap';
import { backend_url } from '../../config'
import { Route, Redirect } from 'react-router'


const msgs = {
  'wrongEmail': 'Uživatelský účet s tímto přihlašovacím e-mailem v knihovně nemáme. Zkontrolujte prosím správnost zadané e-mailové adresy.',
  'wrongPassword': 'Vámi zadané heslo není správné.',
  'generalError': 'Přihlášení se nepodařilo dokončit',
}

class LostPasswordPage extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
        success: false,
        // TODO odebrat
        email: '',
        password: '',
        alerts: [],
    };

    
  }
  handleChange = (e) => {
    const object = {}
    object[e.target.id] = e.target.value
    this.setState(object)
  }
  handleSubmit  = (e) => {
    // TODO loading
    const { history } = this.props
    e.preventDefault();

    // Empty alerts from last submit
    this.state.alerts = []
    
      // TODO validate e-mail
      fetch(`${backend_url}/login`, {
        method: 'post',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          username: this.state.email.trim(),
          password: this.state.password.trim()
        })
      })
      .then( response => {
        if (!response.ok) {
            throw response 
        }
        return response.json()  //we only get here if there is no error
      })
      .then( json => {
        // TODO if remember me, use localstorage
        sessionStorage.setItem('user_id', json.id)
        sessionStorage.setItem('user_roles', json.roles.join(','))
        history.push('/')
      })
      .catch( error => {

        let errorMessage = ''
        if ( error.status == 401 ) {
          errorMessage = msgs.wrongEmail
        } else {
          errorMessage = msgs.generalError
        }

        console.log(errorMessage)
        

          this.setState({
            alerts: [...this.state.alerts, {
              style: 'danger',
              message: errorMessage
            }]
          })
        })
  }
  render() {
    return (
      <div className="login-page">
        <Title title={'Přihlášení | DKZP'} />

        <h1>Přihlášení do knihovny</h1>
        
        {this.state.alerts.map(alert => (
          <Alert bsStyle={alert.style}>
            {alert.message}
          </Alert> 
        ))}
        
        <form onSubmit={this.handleSubmit}>
          <InputGroup name="email" type="type" label="Váš e-mail nebo přihlašovací jméno" handler={this.handleChange} value={this.state.firstName} reguired />
          <InputGroup name="password" type="password" label="Vaše heslo" handler={this.handleChange} value={this.state.firstName} reguired />
          <input type="submit" className="btn btn-primary" value="Přihlásit se" />
        </form>

        {/* TODO jako návštěvník */}
        <p>
          <a href="">Přihlásit se jako návštěvník</a>
        </p>

      </div>
    )
  }
}

export default(LostPasswordPage)
