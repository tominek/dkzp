import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../../components'

class HomePage extends React.Component {
  render() {
    return (
      <div className="home-page">
        <Title title={'Domovská stránka | DKZP'} />
        <h1>Home page</h1>
      </div>
    )
  }
}

export default(HomePage)
