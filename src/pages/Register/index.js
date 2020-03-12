import React, {useState} from 'react';
import User from "../../services/user";
import Token from "../../services/token";
import { Redirect } from 'react-router-dom';
import Header from '../../components/Header';

export default function Register() {
  const token = new Token();
  const user = new User(token);

  const [form, setForm] = useState({
    name:"",
    pass:"",
    confirmPass: ""
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
    const status = (form.pass != "" && form.confirmPass != "" && form.name);

    setForm(newForm);
    setBtn(status);
  }

  async function handlerLogin()
  {
    try {
      if(form.pass != form.confirmPass) 
      {
        alert("As senhas estão diferentes");
        return;
      }

      const response = await user.create(form);
      alert("Seja muito bem vindo, seu id de login é {"+response.id+"}");
      setRedirect(true);
    }
    catch (error)
    {
      alert(error);
    } 
  }

  function renderRedirect()
  {
    return redirect ? <Redirect to="/" /> : null;
  }


  return (
    <div className="container-fluid">
      <Header />
      {renderRedirect()}
      <h1 className="font-weight-bold">Cadastrar</h1>
      <form>
        <div className="form-group">
          <label htmlFor="name">Nome</label>
          <input name="name" type="text" className="form-control" id="name" onChange={handlerForm}/>
        </div>

        <div className="form-group">
          <label htmlFor="pass">Senha</label>
          <input name="pass" type="password" className="form-control" id="pass" onChange={handlerForm}/>
        </div>

        <div className="form-group">
          <label htmlFor="confirmPass">Confirme sua senha</label>
          <input name="confirmPass" type="password" className="form-control" id="confirmPass" onChange={handlerForm}/>
        </div>
        
        {btn && <button type="button" className="btn btn-primary" onClick={handlerLogin}>Entrar</button>}
      </form>
    </div>
  );
}
