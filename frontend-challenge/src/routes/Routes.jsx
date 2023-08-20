import React from "react";
import { Route, Switch, Redirect } from "react-router-dom";
import NewsDetail from "../components/NewsDetail";
import NewsList from "../components/NewsList";

const Routes = () => {
  return (
    <>
      <Switch>
        <Route path="/" exact component={NewsList} />
        <Route path="/notice/finep/:id" component={NewsDetail} />
      </Switch>
    </>
  );
};

export default Routes;
