import { View, Text, TextInput, Pressable } from 'react-native'
import { useState } from 'react'
import { post } from '../../services/post';

export default function Register() {
  const [name, setName] = useState("")
  const [password, setPassword] = useState("")
  const [email, setEmail] = useState("")

  function enviarDatos() {

    const data = {
      name,
      password,
      email,
    };

    post(data)
      .then(function (result) {
      console.log(":", result);
    })
  }

  return (
    <View>
      <TextInput placeholder="Name" onChangeText={setName} />
      <TextInput placeholder="Password" onChangeText={setPassword} />
      <TextInput placeholder="Email" onChangeText={setEmail}/>
      <Pressable onPress={enviarDatos}>
        <Text>Registrar</Text>
      </Pressable>
    </View>
  )
}
      