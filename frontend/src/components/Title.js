/* @flow */
import Helmet from 'react-helmet'
import React from 'react'
import PropTypes from 'prop-types'

const Title = ({ message, meta }: any) => (
  <Helmet title={message} meta={meta} />
)

Title.propTypes = {
  message: PropTypes.string.isRequired,
}

export default Title
