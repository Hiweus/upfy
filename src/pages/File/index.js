import React,{useState, useEffect} from 'react';
import FileUser from '../../services/file';
import Token from '../../services/token';
import Header from '../../components/Header';

export default function File() {
    const [files, setFiles] = useState([]);

    const token = new Token();
    
    useEffect(()=>{
        async function temp()
        {
            try {
                const fileUser = new FileUser(new Token());
                const filesApi = await fileUser.getFiles();
                setFiles(filesApi); 
            } catch (error) {
                
            }
        }
        temp();
    },[]);
    

    async function handlerDownload(tokenFile, nameFile)
    {
        console.clear();
        console.log(tokenFile);
        const file = new FileUser(token);
        const binary = await file.getFile(tokenFile);
        const url = URL.createObjectURL(binary);
        
        const link = document.createElement("a");
        link.href = url;
        link.download = nameFile;
        link.click();
    }

    return (
        <div className="container-fluid text-center">
            <Header />            
            <div className="row">
                {files.map((f)=>(
                    <div className="card col-12 mt-2 text-center" key={f.token}>
                        <div className="card-body">
                            <h5 className="card-title">{f.name}</h5>
                            <p>Criado em : [{f.creation_time}]</p>
                            <input type="button" className="btn btn-primary w-50" value="Abrir" onClick={()=>handlerDownload(f.token, f.name)} />
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
