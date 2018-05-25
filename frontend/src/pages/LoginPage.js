import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route } from 'react-router-dom'
import { Title } from '../components'
import Sidebar from './loginPages/Sidebar.js'
import { Grid, Row, Col } from 'react-bootstrap';


import SignInPage from './loginPages/SignInPage.js'
import LostPasswordPage from './loginPages/LostPasswordPage.js'
import RegistrationPage from './loginPages/RegistrationPage.js'
import HelpPage from './loginPages/HelpPage.js'

class LoginPage extends React.Component {
  render() {
    return (
      <div className="login-page">
        <Title title={'Přihlašovací stránka | DKZP'} />
        <Grid>
          <Row className="show-grid">
            <Col sm={12} md={3}>
              <Sidebar />
            </Col>
            <Col sm={12} md={9} className="text-left">
              <Switch>
                {/* TODO regexp na routu  */}
                <Route exact path='/prihlaseni' component={SignInPage} />
                <Route exact path='/prihlaseni/registrace' component={RegistrationPage} />
                <Route exact path='/prihlaseni/zapomenute-heslo' component={LostPasswordPage} />
                <Route exact path='/prihlaseni/pomoc-s-prihlasenim' component={HelpPage} />
              </Switch>
            </Col>
          </Row>
        </Grid>
      </div>
    )
  }
}

export default(LoginPage)
