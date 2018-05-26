import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route } from 'react-router-dom'
import { Title } from '../components'
import Sidebar from './loginPages/Sidebar.js'
import { Grid, Row, Col } from 'react-bootstrap';
import * as loginPages from './loginPages'

class LoginPage extends React.Component {
  render() {

    // If the user is logged in, redirect him to app
    const { history } = this.props
    if (sessionStorage.getItem('user_id')){
      history.push('/')
    }
    
    return (
      <div className="login-page">
        <Title title={'Přihlašovací stránka | DKZP'} />
        <Grid>
          <Row className="show-grid">
            <Col sm={12} md={3}>
              <Sidebar />
            </Col>
            <Col sm={12} md={9} className="mainContent">
              <Switch>
                {/* TODO regexp na routu  */}
                <Route exact path='/prihlaseni' component={loginPages.SignInPage} />
                <Route exact path='/prihlaseni/registrace' component={loginPages.RegistrationPage} />
                <Route exact path='/prihlaseni/zapomenute-heslo' component={loginPages.LostPasswordsPage} />
                <Route exact path='/prihlaseni/pomoc-s-prihlasenim' component={loginPages.HelpPage} />
                {/* TODO
                - link na obnovu hesla
                - link na potvrzeni emailu
                 */}
              </Switch>
            </Col>
          </Row>
        </Grid>
      </div>
    )
  }
}

export default(LoginPage)
