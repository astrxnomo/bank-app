import * as SecureStore from "expo-secure-store";
import { View, Text, TextInput, Pressable, StyleSheet } from "react-native";
import { LoginH } from "../../hooks/LoginH";

export default function Login() {
  const { setEmail, setPassword, handleSubmit } = LoginH();

  function enviar_datos() {
    handleSubmit();
  }

  return (
    <View style={styles.container}>
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
        <Text style={styles.buttonText}>Iniciar Sesión</Text>
      </Pressable>
    </View>
  );
}

const styles = StyleSheet.create({
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
});
