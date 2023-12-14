<template>

    <nav>
      <img src="images/vendor-8.png" alt="Company Logo" class="logo">
      <input type="number" id="salary-from" placeholder="Salary From">
      <input type="number" id="salary-to" placeholder="Salary To">
      <select id="car-type">
        <option value="sedan">Sedan</option>
        <option value="suv">SUV</option>
        <option value="hatchback">Hatchback</option>
    
      
      </select>
      <input type="text" id="location" placeholder="Location">
      <button onclick="searchCars()">Search</button>
    </nav>

    <br><br><br><br><br><br>

    

</template>





<script>

    function searchCars() {
    const salaryFrom = document.getElementById('salary-from').value;
    const salaryTo = document.getElementById('salary-to').value;
    const carType = document.getElementById('car-type').value;
    const location = document.getElementById('location').value;


    console.log(`Searching for cars with salary range from ${salaryFrom} to ${salaryTo}, type: ${carType}, location: ${location}`);

    
}
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  /* .body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-color: rgb(224, 224, 224); 
    width: 100%;
  } */

nav {
    background-color: #303335;
    color: #8a2828;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 10px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
  }

  nav select, nav input[type="number"], nav input[type="text"], nav button {
    padding: 10px;
    border-radius: 20px;
    border: none;
    margin-right: 30px;
    font-size: 16px;
  }

 

  nav button {
    background-color: #f44336;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 170px;
    height: 50px;
  }

  nav button:hover {
    background-color: #ff665a;
  }

  .logo {
    width: 100px;
    height: auto;
  }
  /*  */

  

  header {
    background-color: #f0f0f0;
    padding: 20px;
    text-align: center;
  }
  
  header img {
    max-width: 100%;
    height: auto;
    margin-top: 20px;
  }
  
  form {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 20px;
  }
  
  form label,
  form input,
  form select,
  form button {
    margin: 5px;
  }
  
</style>
