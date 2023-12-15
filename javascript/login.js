
function searchCars() {
  const salaryFrom = document.getElementById("salary-from").value;
  const salaryTo = document.getElementById("salary-to").value;
  const carType = document.getElementById("car-type").value;
  const location = document.getElementById("location").value;

  console.log(
    `Searching for cars with salary range from ${salaryFrom} to ${salaryTo}, type: ${carType}, location: ${location}`
  );
}

function login() {
  window.location.href = "/login.html";
}



const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        const signUpForm = document.querySelector('.sign-up-container');
        const signInForm = document.querySelector('.sign-in-container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
        
        function newuser()
        {
    //    window.location.href = "/login.html";
        }
    function olduser()
{
    //this.$router.push('/admin');
}  
    