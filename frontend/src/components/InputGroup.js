import React from 'react'

const InputGroup = ({ name, type, label, onChange, value }) => {
  const input = <input className="form-control" value={value} onChange={(e) => onChange(e, name)} />
  const textarea = <textarea className="form-control" type={type} value={value} onChange={(e) => onChange(e, name)} />
  return (
    <div className="form-group">
      <label>{label}:</label>
      {type === 'textarea' ? textarea : input}
    </div>
  )
}

export default(InputGroup)
