import React from 'react'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import logo from '../logo.svg'
import * as pages from '../pages'
import './App.css'

class App extends React.Component {
  render() {
    return (
      <div className="App">
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo"/>
          <h1 className="App-title">Welcome to React</h1>
        </header>
        <Router>
          <div className="app-container">
            {/* <Header /> */}
            <Switch>
              <Route exact path='/' component={pages.LoginPage} />
              <Route component={pages.FourZeroFour} />
            </Switch>
          </div>
        </Router>
      </div>
    );
  }
}

export default App
