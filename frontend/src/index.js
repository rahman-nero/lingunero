import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from "react-router-dom";

import {rootReducer} from "./redux/reducers";
import {Provider} from "react-redux";
import App from './App';
import {createStore} from "redux";

const root = ReactDOM.createRoot(document.getElementById('root'));

// const store = createStore({
//     reducer: rootReducer
// });

root.render(
    <BrowserRouter>
        <App />
    </BrowserRouter>
);
