import React from 'react'
import PropTypes from 'prop-types'

const InputGroup = ({ name, type, label, handler, value }) => {
  const input = <input id={name} className="form-control" type={type} value={value} onChange={handler} />
  const textarea = <textarea id={name} className="form-control" type={type} value={value} onChange={handler}></textarea>
  return (
    <div className="form-group">
        <label htmlFor="{name}" >{label}:</label>
        {type == 'textarea' ? textarea : input}
    </div>
  )
}

export default(InputGroup)
