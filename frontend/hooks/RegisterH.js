import { useState } from 'react';
import { post } from '../services/post';

export function RegisterH(){
    const [name, setName] = useState("")
    const [password, setPassword] = useState("")
    const [email, setEmail] = useState("")

    function handleSubmit() {

        const data = {
            name,
            email,
            password,
        };

        return post(data, "http://127.0.0.1:8000/api/register")
    }

    return {
        name,
        setName,
        email,
        setEmail,
        password,
        setPassword,
        handleSubmit,
    }
}