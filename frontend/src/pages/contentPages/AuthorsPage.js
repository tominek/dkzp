import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../../components'

class AuthorsPage extends React.Component {
  render() {
    return (
      <div className="authors-page">
        <Title title={'Autoři | DKZP'} />
        <h1>Výpis autorů</h1>
      </div>
    )
  }
}

export default(AuthorsPage)
