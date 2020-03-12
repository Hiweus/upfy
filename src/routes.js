import React from 'react';
import {BrowserRouter, Switch, Route} from "react-router-dom";
import { Redirect } from 'react-router-dom';


//////////////////////////
////////////// PAGES
import Main from "./pages/Main";
import File from './pages/File';
import Upload from './pages/Upload';
//////////////////////////


import Token from "./services/token";

const PrivateRoute = (props) => {
  const token = new Token();

  return token.isAuthenticated() ? <Route {...props} /> : <Redirect to="/" />;
};


export default function Routes() {
  return (
    <BrowserRouter>
        <Switch>
            <Route path="/" exact component={Main}/>
            <Route path="/upload" exact component={Upload}/>
            <PrivateRoute path="/file" exact component={File}/>
        </Switch>
    </BrowserRouter>
  );
}
