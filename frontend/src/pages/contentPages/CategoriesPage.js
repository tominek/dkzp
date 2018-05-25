import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../../components'

class CategoriesPage extends React.Component {
  render() {
    return (
      <div className="categories-page">
        <Title title={'Kategorie | DKZP'} />
        <h1>Kategorie</h1>
      </div>
    )
  }
}

export default(CategoriesPage)
