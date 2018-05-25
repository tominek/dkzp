import React from 'react'
import { connect } from 'react-redux'
import { compose } from 'recompose'
import { Link } from 'react-router-dom'
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
    title: 'Úvod',
    link: '/pes'
  },
]

class Header extends React.Component {
  render() {
    const { openedMenu, toggleMenu } = this.props
    return (
      <header className="main-page-header">
        <button
          className="main-page-header__button"
          aria-expanded={openedMenu ? true : false}
          onClick={toggleMenu}
        >
          Menu
        </button>
        <nav
          role="navigation"
          className="main-page-header__nav"
        >
          <ul className={openedMenu ? 'is-active' : ''}>
            {routes.map((route) => (
              <li><Link to={route.link}>{route.title}</Link></li>
            ))}
          </ul>
        </nav>
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
