import React from 'react'
import { Grid, Row, Col } from 'react-bootstrap';
import './Top.css'
class Top extends React.Component {
  render() {
    return (
      <header className="header">
        <Grid>
          <Row className="show-grid">
            <Col sm={12} md={12}>
              <span className="title">Digitální knihovna zrakově postižených Mathilda</span> 
            </Col>
          </Row>
        </Grid>
      </header>
    );
  }
}

export default Top
