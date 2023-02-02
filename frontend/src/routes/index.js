import React, {useState} from 'react';
import {guest, authorized} from "./routes";
import {Route, Routes} from "react-router";


const Index = () => {
    const [auth, setState] = useState(true);

    if (auth) {

        return (<Routes>
                {authorized.map((route) => {
                    return <Route path={route.path} element={route.component}></Route>
                })}
            </Routes>
        );


    }

    return (
        <Routes>
            {guest.map((route) => {
                return <Route path={route.path} element={route.component}></Route>
            })}
        </Routes>
    );
};

export default Index;
