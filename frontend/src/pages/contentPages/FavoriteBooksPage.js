import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title } from '../../components'

class FavoriteBooksPage extends React.Component {
  render() {
    return (
      <div className="favorite-books-page">
        <Title title={'Oblíbené knihy | DKZP'} />
        <h1>Oblíbené knihy</h1>
      </div>
    )
  }
}

export default(FavoriteBooksPage)
