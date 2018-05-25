import React from 'react'
import PropTypes from 'prop-types'
import { Title, InputGroup } from '../../components'
import { FormGroup, FormControl, ControlLabel } from 'react-bootstrap'

const categoryOptions = [
  {value: 1, text: 'text'}
]

const Select = ({ name, value, onChange, options }) => (
 <FormGroup controlId="formControlsSelect">
    <ControlLabel>Select</ControlLabel>
    <FormControl componentClass="select" placeholder="select" onChange={(e) => onChange(e, name)} value={value}>
      <option value="">Nevybráno</option>
      {options.map(opt => (
        <option key={opt.value} value={opt.value}>{opt.text}</option>
      ))}
    </FormControl>
  </FormGroup>
)

class NewBookPage extends React.Component {
  state = {
    author: '',
    name: '',
    category: '',
  }

  handleChange = (e, name) => {
    const newState = {}
    newState[name] = e.target.value
    this.setState(newState)
  }


  handleSubmit = (e) => {
    e.preventDefault()
    const { author, name, category } = this.state
    const object = {
      author,
      name,
      category
    }
    console.log('submit object', object)
  }

  render() {
    const { handleChange, handleSubmit } = this
    const { name, category, author } = this.state
    console.log(this.props)
    return (
      <div className="new-book-page">
        <Title title={'Nová kniha | DKZP'}/>
        <div>
          <div className="new-book-page__form">
            <form onSubmit={handleSubmit}>
              <InputGroup
                name="name"
                type="type"
                label="Jméno"
                onChange={handleChange}
                value={name}
              />
              <InputGroup
                name="author"
                type="type"
                label="Autor"
                onChange={handleChange}
                value={author}
              />
              <Select
                name="category"
                label="Autor"
                onChange={handleChange}
                value={category}
                options={categoryOptions}
              />

              <input type="submit" className="btn btn-primary" value="Přidat knihu" />
            </form>
          </div>
        </div>
      </div>
    )
  }
}

export default(NewBookPage)
