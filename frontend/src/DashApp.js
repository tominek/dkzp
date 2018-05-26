import React from 'react'
import { Provider } from 'react-redux'
import { store, history } from './redux/store'
import logo from './logo.svg'
import { App } from './app'

class DashApp extends React.Component {
  render() {
    return (
      <Provider store={store}>
        <App />
      </Provider>
    );
  }
}

export default DashApp;
