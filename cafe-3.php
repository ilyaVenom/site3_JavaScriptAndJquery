<?php
include "signIn.php";
function connectingIt(){
$servername = "mysql.cs.uky.edu";
$username = "iyse222";
$password = logIn();
// create coonecttion:

try {
  $conn = new PDO("mysql:host=$servername;dbname=iyse222", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  //echo "Connection failed: " . $e->getMessage();
}
return $conn; // to retun the coonn
}
?>

<?php
// a post request is sent
if(isset($_POST['buttonNames']) ) { // gave it the wrong name, should buttonames as below
 // call those function
 // and connect to the server:
 //$conn = connectingIt();
$bigMenu = bigMenu($_POST['buttonNames']); // passing in a value !
// goes back as response 
echo $bigMenu;
exit;
}
?>

<?php
// section -  3 -> next portortion:

  // make function to pass in the posts:
  // add a comments what each does:
  // the bigMenu is the name and the parameter it passes is $items
      function bigMenu ($items) {
      // make it more modular:
      // echo the header
      // remove echos echo "<h2> Details about $items </h2>";
      // example from dr. f's site
      // ie$sql = "SELECT price FROM menu WHERE category = ?;
      //$prepared = $pdo->prepare($sql);
      //$prepared->execute([$valueFromHTMLform]);
      // connect to the mysql from the above connection and the var $conn named it connectingIt
      $conn = connectingIt();
      // this is the prepare statement and coonect it to the ? marker to protect the site from attacks
      $stmt = $conn->prepare("select number from accesses where category = ?");
      $stmt->execute([$items]); // returns the row 
      // use the fetch to gather the data from the table
      $row =$stmt->fetch();
      // plus need to accumulate for it:
      $row= $row['number']; // comment: the class makes it red too
      // and tie the $row to the accumulation.
      // echo "<p class = 'lingual'>You have requested this information $row times</p>"; // row is the number from the DB
      // and update the accesses with the acculation with this:
      $sql = "update accesses set number = number + 1 where category = ?";
      // another prepared statement for the incrementation:
      $stmt = $conn->prepare($sql); // this adds it up.
      // this excutes the incrementation:
      $stmt->execute([$items]); // returns the row 
        $sql = "select item, description, price from menu where category = ?"; // needs to be moved
        $stmt = $conn->prepare($sql); // this adds it up. // prepare make the website safer
        $stmt->execute([$items]); // good - > check
        $myObj->category = $items;
        // pass row to tables
        $myObj->accesses = $row; 
        // another array: to store the array of the array
        $placeHolder = array();
        while($row = $stmt->fetch()) {
          // add the array here:
          $a=array("items"=>$row['item'], "descriptions"=>$row['description'], "prices"=>$row['price']);
          array_push($placeHolder, $a); // to add more to the array, by placing the a - array inside the placeholder array
         }
         $myObj->details =  $placeHolder;
         $myJSON = json_encode($myObj);
         return $myJSON; 
      }?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
	integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK"
	crossorigin="anonymous"></script>
  <meta charset="UTF-8">
  <title>Munshn Lunshn</title>
</head>
<body Id = "body1">
 
<h1>Welcome to the High Times of Munshn Lunshn &#x2122;!</h1>
<p>All our clients are served right!<br><mark>See this website is under construction, as is our cafe.</mark></p>
<h2>See the menu</h2>
<!-- not the get way tho -->
<!-- <form method ="get"> -->

 <!-- ajax doesn't need a form -->
  <table class = 'Atable'>
    <tr>
<!-- the menu next and for -> each td need 3 funcs: // make all the other this the names of it ! -->
      <td 
      onmouseover="hover(this)" Id = "snacks" 
      onmouseout="mousemove(this)"
      onclick = "myClick('snacks')" 
      >snacks </td> <td>&#x1F34E;</td> 
      <td
      onmouseover="hover(this)" Id = "drinks" 
      onmouseout="mousemove(this)"
      onclick = "myClick('drinks')"
      > drinks </td> <td>&#x1F378;</td>
      <td
      onmouseover="hover(this)" Id = "mains" 
      onmouseout="mousemove(this)"
      onclick = "myClick('mains')"
      >mains </td> <td>&#x1F357;</td>
    </tr>
    <tr>
      <td
      onmouseover="hover(this)" Id = "deserts" 
      onmouseout="mousemove(this)"
      onclick = "myClick('deserts')"
      >deserts </td> <td>&#x1F382;</td>
      <td
      onmouseover="hover(this)" Id = "for kids" 
      onmouseout="mousemove(this)"
      onclick = "myClick('for kids')"
      >for kids </td> <td>&#x1F37C;</td>
      <td
      onmouseover="hover(this)" Id = "for pets" 
      onmouseout="mousemove(this)"
      onclick = "myClick('for pets')"
      >for pets </td> <td>&#x1F415;</td>
    </tr>
    <tr>
      <td
      onmouseover="hover(this)" Id = "TakeOut" 
      onmouseout="mousemove(this)"
      onclick = "myClick('TakeOut')"
      >take out </td> <td>&#x1F355;</td>
       <td
      onmouseover="hover(this)" Id = "inedible" 
      onmouseout="mousemove(this)"
      onclick = "myClick('inedible')" 
       class = 'inedible'>inedible </td> <td> &#x1F388;</td>
    <td
    onmouseover="hover(this)" Id = "poisonous" 
    onmouseout="mousemove(this)"
    onclick = "myClick('poisonous')" 
    class = 'poisonous'>poisonous</td> <td> &#x2620;</td>
    </tr>
  </table>
  <div id = "Inner"> </div>
  
  <h2>We are hiring!</h2>
  <p>We are looking for employees who are</p>
<ol>
<li> Reliable </li>
<li> Prompt </li>
<li> Friendly
  <ul>
    <li> Able to deal with <i>obnoxious customers</i></li>
    <li> Able to deal with <i>critical managers</i></li>
    <li> Able to cater to <i>the chef's whims</i></li>
  </ul>
</li>
<li><span class = "Multi">Multi</span><span class = "lingual">lingual</span> </li>
<li> <b>Healthy</b> <!--too far apart ? why? make comments to clear it up and a make file to explain what was added in the bonus. descriptors  -->
</li>
</ol>
<script>
  // takes in two parameters: styel attri, and what it is - to , and each need quotes
document.getElementById("body1").setAttribute("style", "font-family: Free Serif; color:black;")
// this is how to add for classes [] -> these store it in an arrray and it needs indexing.
    document.getElementsByClassName("Atable")[0].setAttribute("style", "border:1px solid black; background-color: beige; text-align: left;")
              
    document.getElementsByClassName("poisonous")[0].setAttribute("style", "border-top: 2px solid red; border-bottom: 2px solid red; \
                                                                  border-left: 2px solid  blue; border-right: 2px solid blue;")
    document.getElementsByClassName("inedible")[0].setAttribute("style", "border: 2px solid green;")
    document.getElementsByClassName("Multi")[0].setAttribute("style", "color:green;")
    document.getElementsByClassName("lingual")[0].setAttribute("style", "color:red;")
    // adding functions: for the snacks mistakes, missing the bordlines ?? consider current style and mod it.
    function hover(onSnacks){
      onSnacks.style.backgroundColor = 'green'; 
      onSnacks.style.color = 'white';
      };
    // or try the jquery way:
    
    //$(`#${onSnack}`).css({backgroundColor: 'beige', color: 'black'});
    
    function mousemove(onSnacks){
      onSnacks.style.backgroundColor = 'beige';
      onSnacks.style.color = 'black';
      }
    // maybe remove to get some points ? : 
    // the function to see the other menu:
    function SeeIt(){
      var SeeIt = document.getElementById('SeeIt');
      SeeIt.style.border = "solid black";
      SeeIt.style.backgroundColor = "beige";
      SeeIt.style.textAlign = "left";
      document.getElementById('redline').style.color = "red";
    }
    async function myClick(someItems) { 
  // this is a str that must be added to it.
      $.post("http://cs.uky.edu/~iyse222/cs316/cafe-3.php", "buttonNames="+someItems).done(function(msg){ 
        // need to parse after post:
        var parsed // is the json obj
        parsed = JSON.parse(msg);
        console.log(parsed);
        let html = document.getElementById("Inner").innerHTML;
        //html = parse.category;
        if (document.getElementById('Inner') !=null){
            document.getElementById('Inner').innerHTML = "";
        }
        // headers details:
        var header = document.createElement("h2");
        header.innerHTML = `<h2>Details about ${parsed.category}<\h2>`; // shares like details about snacks and mains. // but not working !? x-fix
        var access = document.createElement("p");
        access.innerHTML = `<p>You have requested this information ${parsed.accesses} times<\p>`;
        access.setAttribute("id", "redline");
        // populate table:
        var table = document.createElement("table");
        table.innerHTML = `<table>
                              <tr>
                                  <th>Item<\/th><th>Description<\/th><th>Price<\/th>
                              <\/tr>`
        // var name for .category:
        parsed.category; 
        parsed.accesses;
        if (parsed.details.length <= 0){
          document.getElementById('Inner').innerHTML = "";
        }
        else{
        for(var i = 0; i < parsed.details.length; i++){
         // set = to str literal reminders
         // fix later
          var info_inIt = `<tr>
                <td>${parsed.details[i].items}<\/td>
                <td>${parsed.details[i].descriptions}<\/td> 
                <td>${parsed.details[i].prices}<\/td>
          <\/tr>`
          table.innerHTML = table.innerHTML + info_inIt;
        }
        table.innerHTML = table.innerHTML + `<\/table>`
        table.setAttribute("id", "SeeIt");
        document.getElementById("Inner").append(header, access, table);
        SeeIt();
        }
      });// fill in what's inside it.  
		} // getDate
</script>
</body>
</html>