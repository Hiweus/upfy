import api from "./api";

export default class FileUser
{
    constructor(token)
    {
        this.token = token;
    }

    async getFiles()
    {
        const tokenValue = this.token.get();
        console.log("tentando com token "+tokenValue);
        try {
            const response = await api.get("/file/read.php", {headers:{"token":tokenValue}});
            return response.data;  
        } catch (error) {
            console.log({error});
            throw {error};
        }
    }

    async getFile(tokenFile)
    {
        const tokenValue = this.token.get();
        try {
            const response = await api.get("/file/read.php?token="+tokenFile, {
                responseType: 'blob',
                headers:{"token":tokenValue}
            });
            return response.data;

        } catch (error) {
            console.log({error});
            throw {error};
        } 
    }

    async sendFile(file, user)
    {
        try {
            let form = new FormData();
            form.append("user", user);
            form.append("file", file);

            const response = await api.post("/file/create.php", form);
            return response.data;   
        } catch (error) {
            console.log({error});
            throw {error};
        }
    }
}