import React from 'react'
import moment from 'moment'
import { Link } from 'react-router-dom'
import './BookItem.css'

const BookItem = ({ book }) => (
  <div className="book-item">
    <h3 className="book-item__title">{book.name}</h3>
    <div className="book-item__body">
      <div>
        <b>Autor: </b>
        {/* <Link to={`/autor/${book.author.id}`}>{book.author.name}</Link> */}
      </div>
      <div>
        <b>Kategorie: </b>
        {/* {book.categories.map((category) => (
          <Link to={`/category/${category.id}`}>{category.name}</Link>
        ))} */}
      </div>
      <div>
        <b>Staženo: </b>
        <span>{`${book.downloadCount}x`}</span>
      </div>
      <div>
        <b>Anotace: </b>
        <p>{book.anotation}</p>
      </div>
      <div>
        <b>Přidáno: </b>
        <p>{moment(book.created.date).format('DD. MM. YYYY')}</p>
      </div>
      <div className="buttons">
        <button>Přidat k oblíbeným</button>
        <button>Nahlásit knihu</button>
      </div>
    </div>
  </div>
)

export default BookItem
