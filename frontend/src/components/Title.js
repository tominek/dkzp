import React from 'react'

class Title extends React.Component {
  componentDidMount() {
    document.title = this.props.title
  }
  render() {
    return (
      <div/>
    )
  }
}

export default Title