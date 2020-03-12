import api from "./api";

export default class User
{
    constructor(token) {
        this.token = token;
    }

    async login(id, pass)
    {
        try {
            const response = await api.post("/user/login.php",JSON.stringify({
                id,
                pass
            }));
            const data = response.data;
            this.token.set(data.token);

        } catch (error) {
            const message = error.response.data.error;
            // const status = error.response.status;
            throw message;
        }

        return true;
    }


    async create(user)
    {
        try {
            const response = await api.post("/user/create.php",JSON.stringify(user));
            const data = response.data;
            return data;
        } catch (error) {
            throw (error);
        }
       
    }

}