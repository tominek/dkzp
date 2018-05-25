import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../../components'

class AuthorsPage extends React.Component {
  render() {
    return (
      <div className="contact-page">
        <Title title={'Kontakt | DKZP'} />
        <h1>Kontakt</h1>
      </div>
    )
  }
}

export default(AuthorsPage)
