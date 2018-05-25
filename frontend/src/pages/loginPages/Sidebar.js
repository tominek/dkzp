import React from 'react'
import { Link } from 'react-router-dom'

class Sidebar extends React.Component {
  render() {
    return (
        <div id="left">
            <sidebar className="sidebar">
                <ul className="nav nav-pills nav-stacked">
                    <li><Link to="/prihlaseni/" activeClassName="active">přihlašovací stránka</Link></li>
                    <li><Link to="/prihlaseni/registrace" activeClassName="active">nová registrace</Link></li>
                    <li><Link to="/prihlaseni/zapomenute-heslo/" activeClassName="active">zapomenuté heslo</Link></li>
                    {/* generatepsw?userKEY=0a6643cd507f1dce9930718994bade1fdcb8d36c&userID=2
 */}
                    <li><Link to="/prihlaseni/pomoc-s-prihlasenim" activeClassName="active">potíže s přihlášením</Link></li>
                </ul>
            </sidebar>
        </div>
    );
  }
}

export default Sidebar