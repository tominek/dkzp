import React from 'react'
import { Grid, Row, Col } from 'react-bootstrap';
class Footer extends React.Component {
  render() {
    return (
      <header className="footer text-right">
        <Grid>
          <Row className="show-grid">
            <Col sm={12} md={12}>
            <span>Digitální knihovnu zrakově postižených provozuje <a href="http://www.mathilda.cz" title="přejít na stránky provozovatele">Mathilda</a>.</span>
            </Col>
          </Row>
        </Grid>
      </header>
    );
  }
}

export default Footer
