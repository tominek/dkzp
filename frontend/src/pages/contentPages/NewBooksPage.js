import React from 'react'
import moment from 'moment'
import { compose } from 'recompose'
import { connect } from 'react-redux'
import PropTypes from 'prop-types'
import {Switch, Route, BrowserRouter as Router} from 'react-router-dom'
import actions from '../../redux/app/actions'
import { Title, BookItem } from '../../components'
import './NewBooksPage.css'

import { backend_url } from '../../config'

const { setBooks, unsetBooks } = actions

// const getBooks = () => {
//   const books = []
//   for (let i = 0; i < 10; i++) {
//     const book = {
//       title: `Kniha ${i}`,
//       author: {
//         id: i,
//         name: `Autor ${i}`,
//       },
//       categories: [{
//         id: `id ${i}`,
//         name: `Category name ${i}`,
//       }],
//       downloaded: 0,
//       anotation: 'Ani velmi špatná pověst mu nezabrání udělat to, co je správné! Lord Bramwell Johns nezná stud ani výčitky a ví to o něm celý Londýn. A teď, když jeho dva nejlepší přátelé dali přednost teplu rodinného krbu, se cítí podivně nesvůj. Úlevu mu nepřináší ani to, že okrádá jisté londýnské aristokraty o podivně nabyté klenoty, které následně odnáší do kostela. Teprve jedna z těchto nočních výprav přinese kýžené rozptýlení. Bram zaslechne hádku mezi lordem Abernathym a jeho dcerou Rosamundou: dívka má prostřednictvím sňatku s podlým karbaníkem vyrovnat bratrův dluh ze hry. A něco tak podlého považuje za nehoráznost dokonce i Bram… Rose velmi dobře ví, jaká pověst Brama provází, a proto v ní jeho náhlý zájem vzbudí podezření. Jak by také ne, když je to přítel jejího příšerného nastávajícího! Zároveň má ale plán, a pro jeho uskutečnění by se jí mohl Bram hodit. Pro úspěch onoho plánu postačí dodržet pár jednoduchých zásad: mít neustále na paměti, že je to darebák, že jeho polibky vůbec nic neznamenají a že mu za žádných okolností nesmí začít věřit. Anebo může?',
//       createdAt: moment()
//     }
//     books.push(book)
//   }
//   return books
// }

class NewBooksPage extends React.Component {
  state = {
    isLoading: false,
    errors: [],
  }
  componentDidMount() {
    const { setBooks } = this.props
      // TODO validate e-mail
    this.setState({isLoading: true})
    fetch(`${backend_url}/book`, {
      method: 'get',
    })
    .then(res => res.json())
    .then(
      (result) => {
        console.log('result', result);
        setBooks(result)
        this.setState({isLoading: false})
      },
      (error) => {
        console.log(error)
        this.setState({
          errors: [error],
          isLoading: false,
        });
      }
    )
  }
  render() {
    const { books } = this.props
    const { isLoading } = this.state
    return (
      <div className="new-books-page">
        <Title title={'Nové knihy | DKZP'} />
        <h1>Nové knihy</h1>
        {isLoading ? <div>Nahrávání...</div> : null}
        <div className="new-books-page__books">
          {books.map((book, i) => (
            <BookItem key={i} book={book}/>
          ))}
        </div>
      </div>
    )
  }
}

const enhance = compose(
  connect((state) => ({
    books: state.App.toJS().books,
  }), { setBooks, unsetBooks }),
)

export default enhance(NewBooksPage)
