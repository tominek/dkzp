const actions = {
  APP_ACTION: 'APP_ACTION',
  TOGGLE_MENU: 'TOGGLE_MENU',
  SET_CATEGORIES: 'SET_CATEGORIES',
  SET_BOOKS: 'SET_BOOKS',
  appAction: (app) => ({
    type: actions.APP_ACTION,
    app
  }),
  toggleMenu: () => ({
    type: actions.TOGGLE_MENU,
  }),
  setCategories: (categories) => ({
    type: actions.SET_CATEGORIES,
    categories,
  }),
  setBooks: (books) => ({
    type: actions.SET_BOOKS,
    books,
  }),
}

export default actions
