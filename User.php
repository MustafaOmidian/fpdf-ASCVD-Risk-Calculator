<form action="ascvd.php" method="POST">
    <p>Name</p>
    <input type="text" name="Name">
    <br><br>


    <p>Age</p>
    <input type="number" name="Age">
    <br><br>


    <label for="TF">Gender</label>
    <br><br>
        <select id="TF" name="Gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        </select>
        <br><br>
        
    <p>Systolic Blood Pressure</p>
    <input type="number" name="SBP">
    <br><br>

    <p>LDL</p>
    <input type="number" name="LDL">
    <br><br>


    <p>HDL</p>
    <input type="number" name="HDL">
    <br><br>

    <input type="checkbox" id="Diabetes" name="Diabetes" value="Diabetes">
    <label for="Diabetes">Diabetes?</label><br>
    <br><br>


    <input type="checkbox" id="Smoker" name="Smoker" value="Smoker">
    <label for="Smoker">Smoker?</label>
    <br><br>


    <input type="submit" value="Send"><input type="reset" value="Clear">
</form>
