import { Map } from 'immutable';
import actions from './actions';

const initState = new Map({
  auth: null,
});
export default function appReducer(state = initState, action) {
  switch (action.auth) {
    case actions.AUTH_ACTION:
      return state.set('auth', action.auth);
    default:
      return state;
  }
  return state;
}
