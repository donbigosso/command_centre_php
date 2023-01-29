const test = () => {
  document.write("This is js script.");
  // let test2 = null;
  fetch("./data/userData.json")
    .then((response) => response.json())
    .then((jsonResponse) => {
      console.log(jsonResponse);
      document.getElementById("test_h1").innerHTML = jsonResponse[0].name;
    });
};

const test2 = () => {
  let test2 = document.getElementById("test_2");
  test2.innerHTML = "Blah blahA";
};

const clickTest = () => {
  document.getElementById("test_2").innerHTML =
    document.getElementById("file").value;
  console.log(document.getElementById("file").files);
};

let x = 0;
const clickTest2 = () => {
  x++;
  document.getElementById("test_2").innerHTML = x;
};
