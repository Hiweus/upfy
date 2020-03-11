export default class Token{
    get()
    {
        return localStorage.getItem("token");
    }

    set(value)
    {
        localStorage.setItem("token", value);
    }

    remove()
    {
        localStorage.removeItem("token");
    }

    isAuthenticated()
    {
        return this.get() != null;
    }
}