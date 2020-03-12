import React from 'react';
import Token from "../services/token";
import {Link} from "react-router-dom";

export default function Header() {
    const token = new Token();
    function renderLoginOrLogout()
    {
        return token.isAuthenticated()?
                <Link className="nav-link active" to="/" onClick={()=>{
                    (new Token()).remove();
                }}>Logout</Link>
                :
                <Link className="nav-link active" to="/">Login</Link>;
    }

    return (
        <ul class="nav shadow-lg p-3 mb-5 bg-white rounded">
            <li class="nav-item">
                {renderLoginOrLogout()}
            </li>

            <li class="nav-item">
                <Link className="nav-link active" to="/upload">Upload</Link>
            </li>

            { token.isAuthenticated() &&
            <li class="nav-item">
                <Link className="nav-link active" to="/file">Files</Link>;
            </li>
            }

        </ul>
    );
}
