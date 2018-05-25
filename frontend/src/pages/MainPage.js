import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import { Title, Header } from '../components'
import * as pages from './contentPages'
import { FourZeroFour } from './'

class MainPage extends React.Component {
  render() {
    return (
      <div>
        <Header />
        <Switch>
          <Route exact path='/' component={pages.HomePage} />
          <Route exact path='/autori' component={pages.AuthorsPage} />
          <Route exact path='/kategorie' component={pages.CategoriesPage} />
          <Route exact path='/kontakt' component={pages.ContactPage} />
          <Route exact path='/oblibene-knihy' component={pages.FavoriteBooksPage} />
          <Route exact path='/nove-knihy' component={pages.NewBooksPage} />
          <Route component={FourZeroFour} />
        </Switch>
      </div>
    )
  }
}

export default(MainPage)
