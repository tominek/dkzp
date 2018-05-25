import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import DashApp from './DashApp';
import registerServiceWorker from './registerServiceWorker';

ReactDOM.render(<DashApp />, document.getElementById('root'));
registerServiceWorker();
