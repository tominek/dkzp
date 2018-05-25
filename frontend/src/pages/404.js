import React from 'react'
import { Link } from 'react-router-dom'

class FourZeroFour extends React.Component {
  render() {
    return (
      <div className="404Page">
        <h1>
          404
        </h1>
        <h3>
          Vypadá to, že jste se ztratili
        </h3>
        <p>
          Stránka neexistuje nebo byla přesunuta.
        </p>
        <Link to="/" >
          <button>
            Zpět na úvodní stránku
          </button>
        </Link>
      </div>
    )
  }
}

export default (FourZeroFour)