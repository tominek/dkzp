import { createStore, combineReducers, applyMiddleware } from 'redux'
import { composeWithDevTools } from 'redux-devtools-extension'
import createHistory from 'history/createBrowserHistory'
import { routerReducer, routerMiddleware } from 'react-router-redux'
import { reducer as formReducer } from 'redux-form'
import reducers from './reducers'

const history = createHistory()
const routeMiddleware = routerMiddleware(history)
const middlewares = [routeMiddleware]

const store = createStore(
  combineReducers({
    ...reducers,
    form: formReducer,
    router: routerReducer
  }),
  composeWithDevTools(applyMiddleware(...middlewares))
)

export { store, history }
