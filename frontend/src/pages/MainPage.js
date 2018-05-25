import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../components'
import { HomePage } from './contentPages'
import { FourZeroFour } from './'

class MainPage extends React.Component {
  render() {
    return (
      <Router>
        <Switch>
          <Route exact path='/' component={HomePage} />
          <Route component={FourZeroFour} />
        </Switch>
      </Router>
    )
  }
}

export default(MainPage)
