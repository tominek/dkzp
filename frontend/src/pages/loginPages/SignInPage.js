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
  // renderRedirect = () => {
  //   if (this.state.success) {
  //     return <Redirect to='/' />
  //   }
  // }
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
      // .then(response => response)
      .then(
        (response) => {
          if (response.ok) {
            history.push('/')
          }

          throw new Error(response.json().error)
        },
        (error) => {
          throw new Error()
        }
      )
      .catch(
        (error) => {
          this.setState({
            alerts: [...this.state.alerts, {
              style: 'danger',
              message: msgs.wrongEmail
            }]
          })
        }
      )
  }
  render() {
    return (
      <div className="login-page">
        <Title title={'Přihlášení | DKZP'} />

        <h2>Přihlášení do knihovny</h2>
        
        {this.state.alerts.map(alert => (
          <Alert bsStyle={alert.style}>
            {alert.message}
          </Alert> 
        ))}

         {/* {this.renderRedirect()} */}
        
        <form onSubmit={this.handleSubmit}>
        <InputGroup name="email" type="type" label="Váš e-mail nebo přihlašovací jméno" handler={this.handleChange} value={this.state.firstName} />
        <InputGroup name="password" type="password" label="Vaše heslo" handler={this.handleChange} value={this.state.firstName} />
        <input type="submit" className="btn btn-primary" value="Přihlásit se" />
        </form>

      </div>
    )
  }
}

export default(LostPasswordPage)
