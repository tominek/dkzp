import React, { Component } from 'react'
import { Provider } from 'react-redux'
import { store, history } from './redux/store'
import logo from './logo.svg'
import { App } from './app'
import './DashApp.css'

class DashApp extends Component {
  render() {
    return (
      <Provider store={store}>
        <App />
      </Provider>
    );
  }
}

export default DashApp;
