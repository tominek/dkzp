import React from 'react'
import { connect } from 'react-redux'
import { compose } from 'recompose'
import { Link } from 'react-router-dom'
import { Nav, NavItem } from 'react-bootstrap'

import actions from '../redux/app/actions'
import './Header.css'

const { toggleMenu } = actions

const routes = [
  {
    title: 'Úvod',
    link: '/'
  },
  {
    title: 'Kategorie',
    link: '/kategorie'
  },
  {
    title: 'Kontakt',
    link: '/kontakt'
  },
  {
    title: 'Oblíbené knihy',
    link: '/oblibene-knihy'
  },
  {
    title: 'Nové knihy',
    link: '/nove-knihy'
  },
  {
    title: 'Autoři',
    link: '/autori'
  },
  {
    title: 'Nápověda',
    link: '/napoveda'
  },
  {
    title: 'Úvod',
    link: '/pes'
  },
]

class Header extends React.Component {
  render() {
    const { openedMenu, toggleMenu } = this.props
    return (
      <header className="main-page-header">
        <Nav>
          {routes.map((route) => (
            <NavItem componentClass={Link} href={route.link} to={route.link}>
              {route.title}
            </NavItem>
          ))}
        </Nav>

      </header>
    )
  }
}

const enhance = compose(
    connect((state) => ({
    openedMenu: state.App.toJS().openedMenu,
  }), { toggleMenu }),
)

export default enhance(Header)