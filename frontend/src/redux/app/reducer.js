import { Map } from 'immutable';
import actions from './actions';

const initState = new Map({
  app: null,
  openedMenu: false,
  categories: [],
  books: [],

});
export default function appReducer(state = initState, action) {
  switch (action.type) {
    case actions.APP:
      return state.set('app', action.app);
    case actions.TOGGLE_MENU: {
      const actualState = state.get('openedMenu')
      return state.set('openedMenu', !actualState);
    }
    case actions.SET_CATEGORIES: {
      return state.set('categories', action.categories);
    }
    case actions.SET_BOOKS: {
      return state.set('books', action.books);
    }
    default:
      return state;
  }
  return state;
}
