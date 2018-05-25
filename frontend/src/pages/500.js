import React from 'react'
import { Link } from 'react-router-dom'

class FiveZeroZero extends React.Component {
  render() {
    return (
      <div className="500Page">
        <h1>
          500
        </h1>
        <h3>
          Něco není správně
        </h3>
        <p>
          Web má nějaké problémy
        </p>
        <Link to="/">
          <button>
            Zpět na úvodní stránku
          </button>
        </Link>
      </div>
    )
  }
}

export default (FiveZeroZero)