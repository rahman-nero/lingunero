import React, {useState} from "react";
import Index from "./routes";

function App() {
    const [count, setCount] = useState(0);
    const [value, setValue] = useState('');


    function clicker() {
        setCount(count + 1);
    }

    function downClick() {
        setCount(count - 1);
    }


    return (
        <div className="App">
            <Index></Index>

            {/*<h1>Количество лайков: {count}</h1>*/}
            {/*<button onClick={clicker}>чел</button>*/}
            {/*<button onClick={downClick}>удали</button>*/}
            {/*<br/>*/}

            {/*<h2>{value}</h2>*/}
            {/*<input type="text" value={value} onChange={(e) => setValue(e.target.value)} />*/}

        </div>
    );
}

export default App;
