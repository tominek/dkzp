import React from 'react'
import PropTypes from 'prop-types'
import { Title, InputGroup } from '../../components'
import { FormGroup, FormControl, ControlLabel } from 'react-bootstrap'

const categoryOptions = [
  {value: 1, text: 'text'},
  {value: 2, text: 'text'},
  {value: 3, text: 'text'}
]

const Select = ({ name, value, onChange, options }) => (
 <FormGroup controlId="formControlsSelect">
    <ControlLabel>Select</ControlLabel>
    <FormControl componentClass="select" placeholder="select" onChange={(e) => onChange(e, name)} value={value} multiple>
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
    anotation: '',
    category: [],
    file: null,
  }

  handleChange = (e, name) => {
    const newState = {}
    newState[name] = e.target.value
    this.setState(newState)
  }

  handleMultipleChange = (e, name) => {
    const newState = {}
    const index = this.state[name].indexOf(e.target.value)
    if (index >= 0) {
      const newArray = [...this.state[name]]
      newArray.splice(index, 1)
      newState[name] = newArray
      this.setState(newState)
    } else {
      newState[name] = [...this.state[name], e.target.value]
      this.setState(newState)
    }
  }


  handleSubmit = (e) => {
    e.preventDefault()
    const { author, name, category, file, anotation } = this.state
    const object = {
      author,
      name,
      category,
      file,
      anotation
    }
    console.log('submit object', object)
  }

  render() {
    const { handleChange, handleMultipleChange, handleSubmit } = this
    const { name, category, author, anotation } = this.state
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
              <InputGroup
                name="anotation"
                type="textarea"
                label="Anotace"
                onChange={handleChange}
                value={anotation}
              />

              <Select
                name="category"
                label="Autor"
                onChange={handleMultipleChange}
                value={category}
                options={categoryOptions}
              />

              <input type="file" onChange={e => this.setState({ file: e.target.files[0] })}/>

              <input type="submit" className="btn btn-primary" value="Přidat knihu" />
            </form>
          </div>
        </div>
      </div>
    )
  }
}

export default(NewBookPage)
