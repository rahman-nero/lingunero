import Login from "../pages/Login";
import Main from "../pages/Main";
import Register from "../pages/Register";
import Posts from "../pages/Posts";

export const guest = [
    {path: "/main", component: <Main/>},
    {path: "/login", component: <Login/>},
    {path: "/register", component: <Register/>}
];

export const authorized = [
    {path: "/", component: <Main/>},
    {path: "/posts", component: <Posts/>},
    {path: "/register", component: <Register/>}
];
