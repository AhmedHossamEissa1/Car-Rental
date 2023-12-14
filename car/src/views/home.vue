<template>
  
   <div><navbar/></div>
 
    <main>
        <div class="car-list">
          <div class="car-item">
            <img style="width: 300px; height: 200px;" src="../assets/car-rent-1.png" alt="Car 1">
            <h2>Car 1</h2>
            <p>Price: $700000</p>
            <p>Year: 2022</p>
        
        
          </div>

          <div class="car-item">
            <img style="width: 300px; height: 200px;" src="../assets/car-rent-2.png" alt="Car 2">
            <h2>Car 2</h2>
            <p>Price: $400000</p>
            <p>Year: 2018</p>
       
          </div>

          <div class="car-item">
            <img src="../assets/car-rent-3.png" alt="Car 3">
            <h2>Car 3</h2>
            <p>Price: $1000000</p>
            <p>Year: 2023</p>
        
          </div>
        </div>
      </main>
      <div><end/></div>
     
    
       
      
</template>

<script>
import navbar from '@/components/navbar.vue';
import end from '@/components/end.vue';

export default {
  name: "home",
  components: {
    navbar,
    end
  }
}

</script>

<style scoped>


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
  
  main {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    padding: 20px;
  }
  
  .car-list {
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
    max-width: 1500px;
  }
  
  .car-item {
    text-align: center;
    margin: 70px;
    padding: 15px;
    border: 1px solid rgb(138, 37, 37);
    border-radius: 20px;
    width: 300px;
  }
  
  .car-item img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
  }
</style>