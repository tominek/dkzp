import { Map } from 'immutable';
import actions from './actions';

const initState = new Map({
  app: null,
});
export default function appReducer(state = initState, action) {
  switch (action.type) {
    case actions.APP:
      return state.set('app', action.app);
    default:
      return state;
  }
  return state;
}
