import { View, Text, TextInput, Pressable } from "react-native";
import { RegisterH } from "../../hooks/RegisterH";
export default function Register() {
  const { setName, setEmail, setPassword, handleSubmit } = RegisterH();

  function enviar_datos() {
    handleSubmit();
  }

  return (
    <View style={styles.container}>
      <TextInput
        placeholder="Nombre"
        onChangeText={setName}
        style={styles.input}
      />
      <TextInput
        placeholder="Email"
        onChangeText={setEmail}
        style={styles.input}
      />
      <TextInput
        placeholder="Contraseña"
        onChangeText={setPassword}
        style={styles.input}
      />
      <Pressable onPress={enviar_datos} style={styles.button}>
        <Text style={styles.buttonText}>Registrar</Text>
      </Pressable>
    </View>
  );
}

const styles = {
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  input: {
    width: "80%",
    height: 40,
    borderColor: "gray",
    borderWidth: 1,
    marginBottom: 10,
    paddingHorizontal: 10,
  },
  button: {
    backgroundColor: "blue",
    padding: 10,
    borderRadius: 5,
  },
  buttonText: {
    color: "white",
    fontSize: 16,
  },
};
