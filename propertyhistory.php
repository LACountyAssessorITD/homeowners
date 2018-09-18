<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="styles/home-style.css">
<style>
.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

table, th, td {
    border: 0.5px solid black;
}
.header img {
  float: left;
  width: 150px;
  height: 100px;
  background: #555;
}


</style>
</head>
<body>
  <ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="claim.php">Claim</a></li>
  <li><a href="HomeownerInformation.php">Advanced Search</a></li>
  <li><a href="indexv2.php">Logout</a></li>
</ul>


<hr>
<form action="/action_page.php">
Property Name/AIN: <input type="text" name="propertyName" value="xxx-xxxxx"><br>
Address: <input type="text" name="address" value="1600 Pennsylvania Ave"><br>
<input type="submit" value="Submit">
</form>

<hr>

<table style="width:100%">
  <tr>
    <th>Homeowner</th>
    <th>Year</th>
    <th>Exemption</th>
  </tr>
  <tr>
    <td>Nick</td>
    <td>2017-present</td>
    <td></td>
  </tr>
  <tr>
    <td>Molly</td>
    <td>2010-2017</td>
    <td></td>
  </tr>
  <tr>
    <td>Molly</td>
    <td>2005-2010</td>
    <td>NONE</td>
  </tr>
</table>

</body>
</html>
