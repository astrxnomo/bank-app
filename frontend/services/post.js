
export function post(data, endpoint) {
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