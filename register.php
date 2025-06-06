<style>
body{
    background-image: linear-gradient(135deg, #a18cd1, #fbc2eb);
    font-family: Arial;
    margin: 0px;
    padding: 0px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container{
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin: auto;
}

h2 
{
      text-align: center;
      margin-bottom: 24px;
      color: #333;
}

.user,.pass{
      width: 100%;
      padding: 10px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }


.btn{
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

.btn:hover {
      background-color: lightgreen;
}
</style>


<div class = 'container'>
    <form action = 'login.php' method = 'post'>
        <h2>New User</h2>
        <label for="username">Username:</label><br>
        <input type="text" name="username" minlength:3 class="user" required><br>
        <label for = "email">Email:</label><br>
        <input type="email" name="email" class ="user" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" minlenght:8 class="pass" required><br>
        <input type="submit" name="register" value="Register" class="btn"><br>
    </form>
</div>