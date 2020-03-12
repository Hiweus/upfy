import React,{useState, useEffect} from 'react';
import FileUser from '../../services/file';
import Token from '../../services/token';
import { Redirect } from 'react-router-dom';
import Header from '../../components/Header';

export default function File() {
    const [form, setForm] = useState({
        "file": null,
        "user":-1
    });


    const token = new Token();

    function handlerForm(e)
    {
        const target = e.target;
        const name = target.getAttribute("name");
        const value = target.value;

        const newForm = form;
        newForm[name] = value;

        if(target.getAttribute("type") == "file") newForm[name] = target;
        
        setForm(newForm);
    }

    async function handlerSubmit(e)
    {
        const file = new FileUser(token);
        try {
            if(form.file == null)
            {
                alert("selecione os arquivos");
                return ;
            }

            await file.sendFile(form.file.files[0], form.user);
            alert("Arquivo enviado com sucesso");            
        } catch (error) {
            console.log(error);
            const msg = error.error.response.data.error;
            alert(msg);
        }
    }


    return (
        <div className="container-fluid text-center shadow">
            <Header />
            <form>
                <div className="form-group">
                    <label>Usuario</label>
                    <input type="number" className="form-control" name="user" onChange={handlerForm}/>
                </div>

                <hr />
                
                <div className="form-group">
                    <label>Selecione o arquivo</label>
                    <input type="file" className="form-control-file" name="file" onChange={handlerForm} />
                </div>
                
                <hr />
                <div className="form-group">
                    <input type="button" className="btn btn-info form-control" value="Enviar" onClick={handlerSubmit}/>
                </div>

            </form>
        </div>
    );
}
