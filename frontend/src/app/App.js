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
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo"/>
        </header>
        <Header />
        <Router>
          <div className="app-container">
            <Switch>
              <Route exact path='/prihlaseni' component={pages.LoginPage} />
              <Route path='/' component={pages.MainPage} />
              <Route component={pages.FourZeroFour} />
            </Switch>
          </div>
        </Router>
        <Footer />
      </div>
    );
  }
}

export default App
