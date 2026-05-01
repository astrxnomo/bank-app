import { useState } from 'react'
import { post } from '../services/post';

export function LoginH(){
    const [password, setPassword] = useState("")
    const [email, setEmail] = useState("")

    function handleSubmit() {

        const data = {
            email,
            password,

        };

        return fetch("http://127.0.0.1:8000/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data)
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (result) {
            console.log("Success:", result);
            SecureStore.setItemAsync("token", data.access_token);
        })
        .catch(function (error) {
            console.error("Error:", error);
        });
    }

    return {
        email,
        setEmail,
        password,
        setPassword,
        handleSubmit,
    }
}