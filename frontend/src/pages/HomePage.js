import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../components'
import { FiveZeroZero, FourZeroFour } from './'

class HomePage extends React.Component {
  render() {
    return (
      <div className="login-page">
        <Title title={'Domovská stránka | DKZP'} />
        <h1>Home page</h1>
        <Router>
          <div className="app-container">
            <Switch>
              <Route exact path='/' component={FiveZeroZero} />
              <Route exact path='/nove' component={FiveZeroZero} />
              <Route component={FourZeroFour} />
            </Switch>
          </div>
        </Router>
      </div>
    )
  }
}

export default(HomePage)
