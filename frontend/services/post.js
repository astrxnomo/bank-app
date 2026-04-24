var endpoint = "http://127.0.0.1:8000/api/users";

export function post(data,) {
  return fetch(endpoint, {
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
    })
    .catch(function (error) {
      console.error("Error:", error);
    });
}