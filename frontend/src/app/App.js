import React from 'react'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Header, Footer } from '../components'
import logo from '../logo.svg'
import * as pages from '../pages'
import './App.css'

class App extends React.Component {
  render() {
    return (
      <div className="App">
        <Router>
          <div className="app-container">
            <Switch>
              <Route exact path='/prihlaseni' component={pages.LoginPage} />
              <Route path='/' component={pages.MainPage} />
              <Route component={pages.FourZeroFour} />
            </Switch>
          <Footer />
          </div>
        </Router>
      </div>
    );
  }
}

export default App
