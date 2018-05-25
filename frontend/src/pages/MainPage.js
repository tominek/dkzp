import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import {Grid, Row, Col} from 'react-bootstrap'
import { Title, Header } from '../components'
import * as pages from './contentPages'
import { FourZeroFour } from './'

class MainPage extends React.Component {
  render() {
    return (
      <div className="main-page">
        <Grid>
          <Row className="show-grid">
            <Col sm={12} md={3}>
              <Header />
            </Col>
            <Col sm={12} md={9} className="text-left">
              <Switch>
                <Route exact path='/' component={pages.HomePage} />
                <Route exact path='/autori' component={pages.AuthorsPage} />
                <Route exact path='/kategorie' component={pages.CategoriesPage} />
                <Route exact path='/kontakt' component={pages.ContactPage} />
                <Route exact path='/oblibene-knihy' component={pages.FavoriteBooksPage} />
                <Route exact path='/nove-knihy' component={pages.NewBooksPage} />
                <Route exact path='/napoveda' component={pages.HelpPage} />
                <Route component={FourZeroFour} />
              </Switch>
            </Col>
          </Row>
        </Grid>
      </div>
    )
  }
}

export default(MainPage)
