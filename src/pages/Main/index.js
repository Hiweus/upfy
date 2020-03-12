import React, {useState} from 'react';
import User from "../../services/user";
import Token from "../../services/token";
import { Redirect } from 'react-router-dom';
import Header from '../../components/Header';

export default function Main() {
  const token = new Token();
  const user = new User(token);

  const [form, setForm] = useState({
    user:"",
    pass:""
  });

  const [btn, setBtn] = useState(false);
  const [redirect, setRedirect] = useState(false);

  function handlerForm(e)
  {
    const target = e.target;
    const name = target.getAttribute("name");
    const value = target.value;

    const newForm = form;
    newForm[name] = value;
    const status = (form.user != "" && form.pass != "");


    setForm(newForm);
    setBtn(status);
  }

  async function handlerLogin()
  {
    try {
      const response = await user.login(form.user, form.pass);
      setRedirect(response);
    }
    catch (error)
    {
      alert(error);
    } 
  }

  function renderRedirect()
  {
    return token.isAuthenticated() ? <Redirect to="/file" /> : null;
  }


  return (
    <div className="container-fluid">
      <Header />
      {redirect && renderRedirect()}
      {renderRedirect()}
      <form>
        <div className="form-group">
          <label htmlFor="user">ID</label>
          <input type="number" name="user" className="form-control" id="user" onChange={handlerForm} />
      </div>

        <div className="form-group">
          <label htmlFor="pass">Password</label>
          <input name="pass" type="password" className="form-control" id="pass" onChange={handlerForm}/>
        </div>
        
        {btn && <button type="button" className="btn btn-primary" onClick={handlerLogin}>Entrar</button>}
      </form>
    </div>
  );
}
