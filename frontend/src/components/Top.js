import React from 'react'
import { Grid, Row, Col } from 'react-bootstrap';

class Top extends React.Component {
  render() {
    return (
      <header className="header text-left">
        <Grid>
          <Row className="show-grid">
            <Col sm={12} md={12}>
                <h1>Digitální knihovna zrakově postižených Mathilda</h1> 
            </Col>
          </Row>
        </Grid>
      </header>
    );
  }
}

export default Top
