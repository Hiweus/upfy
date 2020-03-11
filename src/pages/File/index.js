import React,{useState, useEffect} from 'react';
import FileUser from '../../services/file';
import Token from '../../services/token';
import { Redirect } from 'react-router-dom';

export default function File() {
    const [files, setFiles] = useState([]);
    const [redirect, setRedirect] = useState(false);

    const token = new Token();
    
    useEffect(()=>{
        async function temp()
        {
            try {
                const fileUser = new FileUser(new Token());
                const filesApi = await fileUser.getFiles();
                console.log(filesApi);
                setFiles(filesApi); 
            } catch (error) {
                
            }
        }
        temp();
    },[]);
    
    function handlerLogout()
    {
        token.remove();
        setRedirect(true);
    }


    return (
        <div className="container-fluid text-center">
            {redirect && <Redirect to="/" />}
            <input type="button" className="btn btn-warning w-25 p-1 m-1" value="Sair" onClick={handlerLogout} />
            
            <div className="row">
                {files.map((f)=>(
                    <div className="card col-12 mt-2 text-center" key={f.token}>
                        <div className="card-body">
                            <h5 className="card-title">{f.name}</h5>
                            <input type="button" className="btn btn-primary w-50" value="Abrir" />
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
