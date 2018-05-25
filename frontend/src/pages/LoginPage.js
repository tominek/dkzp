import React from 'react'
import PropTypes from 'prop-types'
import { Title } from '../components'

class LoginPage extends React.Component {
  render() {
    return (
      <div className="login-page">
        <Title title={'Přihlašovací stránka | DKZP'} />
        <h1>login page ze jo</h1>
      </div>
    )
  }
}

export default(LoginPage)
