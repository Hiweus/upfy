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
}