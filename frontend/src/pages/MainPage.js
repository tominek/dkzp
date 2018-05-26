import React from 'react'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import {Grid, Row, Col} from 'react-bootstrap'
import { Title, Header } from '../components'
import * as pages from './contentPages'
import * as adminPages from './adminPages'
import { FourZeroFour } from './'

class MainPage extends React.Component {

  
  render() {

    // If the user is not logged in, redirect him to login
    const { history } = this.props
    if (! sessionStorage.getItem('user_id')){
      history.push('/prihlaseni')
    }
    return (
      <div className="main-page">
        <Grid>
          <Row className="show-grid">
            <Col sm={12} md={3}>
              <Header />
            </Col>
            <Col sm={12} md={9} className="mainContent">
              <Switch>
                <Route exact path='/' component={pages.HomePage} />
                <Route exact path='/autori' component={pages.AuthorsPage} />
                <Route exact path='/kategorie' component={pages.CategoriesPage} />
                <Route exact path='/kontakt' component={pages.ContactPage} />
                <Route exact path='/oblibene-knihy' component={pages.FavoriteBooksPage} />
                <Route exact path='/nove-knihy' component={pages.NewBooksPage} />
                <Route exact path='/napoveda' component={pages.HelpPage} />
                <Route exact path='/admin/nova-kniha' component={adminPages.NewBookPage} />
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