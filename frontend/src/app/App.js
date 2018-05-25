import React from 'react'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import Helmet from 'react-helmet'

import logo from '../logo.svg'
import * as pages from '../pages'

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
            {/* <Helmet
              htmlAttributes={{ lang: 'cs' }}
              titleTemplate={meta.title}
              meta={meta.metas}
              link={meta.links}
            /> */}
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
